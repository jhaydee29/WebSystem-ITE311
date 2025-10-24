<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MaterialModel;
use App\Models\CourseModel;
use App\Models\EnrollmentModel;
use CodeIgniter\API\ResponseTrait;

class Material extends BaseController
{
    use ResponseTrait;

    /**
     * Upload a material file to a course
     *
     * @return mixed
     */
    public function upload()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            if ($this->request->isAJAX()) {
                return $this->respond([
                    'success' => false,
                    'message' => 'Please login to upload materials'
                ], 401);
            }
            return redirect()->to(site_url('login'))->with('error', 'Please login to upload materials');
        }

        $userRole = session()->get('role');
        
        // Only admin and teacher can upload materials
        if (!in_array($userRole, ['admin', 'teacher'])) {
            return $this->respondUpload(false, 'You do not have permission to upload materials', 403);
        }

        $courseId = $this->request->getPost('course_id');
        $title = $this->request->getPost('title');
        $description = $this->request->getPost('description');
        $file = $this->request->getFile('material_file');

        // Validation
        if (!$courseId || !$title || !$file) {
            return $this->respondUpload(false, 'Course ID, title, and file are required', 400, $courseId);
        }

        // Validate course exists
        $courseModel = new CourseModel();
        $course = $courseModel->find($courseId);

        if (!$course) {
            return $this->respondUpload(false, 'Course not found', 404, $courseId);
        }

        // For teachers, verify they are the instructor of the course
        if ($userRole === 'teacher' && $course['instructor_id'] != session()->get('id')) {
            return $this->respondUpload(false, 'You can only upload materials to your own courses', 403, $courseId);
        }

        // Validate file
        if (!$file->isValid()) {
            return $this->respondUpload(false, 'Invalid file upload: ' . $file->getErrorString(), 400, $courseId);
        }

        // Check file type (PDF, PPT, PPTX, DOC, DOCX)
        $allowedTypes = ['pdf', 'ppt', 'pptx', 'doc', 'docx'];
        $fileExtension = $file->getExtension();

        if (!in_array(strtolower($fileExtension), $allowedTypes)) {
            return $this->respondUpload(false, 'Invalid file type. Only PDF, PPT, PPTX, DOC, and DOCX files are allowed', 400, $courseId);
        }

        // Check file size (max 10MB)
        $maxSize = 10 * 1024 * 1024; // 10MB in bytes
        if ($file->getSize() > $maxSize) {
            return $this->respondUpload(false, 'File size exceeds 10MB limit', 400, $courseId);
        }

        try {
            // Create uploads directory if it doesn't exist
            $uploadPath = FCPATH . 'uploads/materials/course_' . $courseId;
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Generate unique filename
            $newFileName = $file->getRandomName();
            
            // Move file to uploads directory
            $file->move($uploadPath, $newFileName);

            // Save to database
            $materialModel = new MaterialModel();
            $materialData = [
                'course_id' => $courseId,
                'title' => $title,
                'description' => $description,
                'file_name' => $file->getClientName(),
                'file_path' => 'uploads/materials/course_' . $courseId . '/' . $newFileName,
                'file_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
                'uploaded_by' => session()->get('id')
            ];

            if ($materialModel->insert($materialData)) {
                return $this->respondUpload(true, 'Material uploaded successfully', 200, $courseId, ['material' => $materialData]);
            } else {
                // Delete uploaded file if database insert fails
                unlink($uploadPath . '/' . $newFileName);
                
                return $this->respondUpload(false, 'Failed to save material to database', 500, $courseId);
            }
        } catch (\Exception $e) {
            return $this->respondUpload(false, 'Error uploading file: ' . $e->getMessage(), 500, $courseId);
        }
    }

    private function respondUpload(bool $success, string $message, int $status = 200, $courseId = null, array $extra = [])
    {
        $payload = array_merge([
            'success' => $success,
            'message' => $message
        ], $extra);

        $payload['csrf'] = csrf_hash();

        if ($this->request->isAJAX()) {
            return $this->respond($payload, $status);
        }

        if ($success) {
            $redirectUrl = $courseId ? site_url('course/view/' . $courseId) : (previous_url() ?: site_url('/courses'));
            return redirect()->to($redirectUrl)->with('success', $message);
        }

        return redirect()->back()->withInput()->with('error', $message);
    }

    /**
     * Download a material file - STEP 7 IMPLEMENTATION
     *
     * @param int $id Material ID
     * @return mixed
     */
    public function download($id = null)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Please login to download materials');
        }

        if (!$id) {
            return redirect()->back()->with('error', 'Material ID is required');
        }

        $materialModel = new MaterialModel();
        $material = $materialModel->find($id);

        if (!$material) {
            return redirect()->back()->with('error', 'Material not found');
        }

        // Check if user is enrolled in the course (unless they are admin or the instructor)
        $userRole = session()->get('role');
        $userId = session()->get('id');

        if ($userRole === 'student') {
            $enrollmentModel = new EnrollmentModel();
            $isEnrolled = $enrollmentModel->isAlreadyEnrolled($userId, $material['course_id']);

            if (!$isEnrolled) {
                return redirect()->back()->with('error', 'You must be enrolled in this course to download materials');
            }
        } elseif ($userRole === 'teacher') {
            // Check if teacher is the instructor of the course
            $courseModel = new CourseModel();
            $course = $courseModel->find($material['course_id']);
            
            if ($course['instructor_id'] != $userId) {
                return redirect()->back()->with('error', 'You do not have permission to download this material');
            }
        }
        // Admin can download any material

        // Get file path
        $filePath = FCPATH . $material['file_path'];

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File not found on server');
        }

        // Force download using Response class
        return $this->response->download($filePath, null)->setFileName($material['file_name']);
    }

    /**
     * Delete a material
     *
     * @param int $id Material ID
     * @return mixed
     */
    public function delete($id = null)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            if ($this->request->isAJAX()) {
                return $this->respond([
                    'success' => false,
                    'message' => 'Please login to delete materials'
                ], 401);
            }
            return redirect()->to(site_url('login'))->with('error', 'Please login to delete materials');
        }

        $userRole = session()->get('role');
        
        // Only admin and teacher can delete materials
        if (!in_array($userRole, ['admin', 'teacher'])) {
            return $this->respondDelete(false, 'You do not have permission to delete materials', 403);
        }

        if (!$id) {
            return $this->respondDelete(false, 'Material ID is required', 400);
        }

        $materialModel = new MaterialModel();
        $material = $materialModel->find($id);

        if (!$material) {
            return $this->respondDelete(false, 'Material not found', 404);
        }

        // For teachers, verify they uploaded the material or are the course instructor
        if ($userRole === 'teacher') {
            $courseModel = new CourseModel();
            $course = $courseModel->find($material['course_id']);
            
            if ($material['uploaded_by'] != session()->get('id') && $course['instructor_id'] != session()->get('id')) {
                return $this->respondDelete(false, 'You can only delete materials you uploaded or from your courses', 403, $material['course_id']);
            }
        }

        // Delete material
        if ($materialModel->deleteMaterial($id)) {
            return $this->respondDelete(true, 'Material deleted successfully', 200, $material['course_id']);
        } else {
            return $this->respondDelete(false, 'Failed to delete material', 500, $material['course_id']);
        }
    }

    private function respondDelete(bool $success, string $message, int $status = 200, $courseId = null)
    {
        $payload = [
            'success' => $success,
            'message' => $message
        ];

        $payload['csrf'] = csrf_hash();

        if ($this->request->isAJAX()) {
            return $this->respond($payload, $status);
        }

        if ($success) {
            $redirectUrl = $courseId ? site_url('course/view/' . $courseId) : (previous_url() ?: site_url('/courses'));
            return redirect()->to($redirectUrl)->with('success', $message);
        }

        return redirect()->back()->with('error', $message);
    }
}
