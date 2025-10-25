<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CourseModel;
use App\Models\EnrollmentModel;
use App\Models\UserModel;
use App\Models\MaterialModel;
use App\Models\NotificationModel;
use CodeIgniter\API\ResponseTrait;

class Course extends BaseController
{
    use ResponseTrait;

    /**
     * Display all available courses
     *
     * @return mixed
     */
    public function index()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $courseModel = new CourseModel();
        $enrollmentModel = new EnrollmentModel();
        $userId = session()->get('id');

        // Get all courses with enrollment counts
        $courses = $courseModel->getCoursesWithEnrollmentCount();

        // Get user's enrolled courses for highlighting
        $userEnrollments = $enrollmentModel->getUserEnrollments($userId);
        $enrolledCourseIds = array_column($userEnrollments, 'course_id');

        $this->data['courses'] = $courses;
        $this->data['enrolledCourseIds'] = $enrolledCourseIds;
        $this->data['user'] = [
            'name' => session()->get('name'),
            'role' => session()->get('role')
        ];

        return view('courses/index', $this->data);
    }
    public function enroll()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return $this->respond([
                'success' => false,
                'message' => 'Please login to enroll in courses'
            ], 401);
        }

        // Get course_id from POST request
        $courseId = $this->request->getPost('course_id');

        if (!$courseId) {
            return $this->respond([
                'success' => false,
                'message' => 'Course ID is required'
            ], 400);
        }

        // Validate course exists
        $courseModel = new CourseModel();
        $course = $courseModel->find($courseId);

        if (!$course) {
            return $this->respond([
                'success' => false,
                'message' => 'Course not found'
            ], 404);
        }

        $userId = session()->get('id');

        // Load the EnrollmentModel
        $enrollmentModel = new EnrollmentModel();

        // Check if user is already enrolled
        if ($enrollmentModel->isAlreadyEnrolled($userId, $courseId)) {
            return $this->respond([
                'success' => false,
                'message' => 'You are already enrolled in this course'
            ], 409);
        }

        // Prepare enrollment data
        $enrollmentData = [
            'user_id' => $userId,
            'course_id' => $courseId,
            'enrollment_date' => date('Y-m-d H:i:s')
        ];

        // Attempt to enroll the user
        if ($enrollmentModel->enrollUser($enrollmentData)) {
            //notification para sa  student
            $notificationModel = new NotificationModel();
            $notificationMessage = "You have been enrolled in " . $course['title'];
            $notificationModel->createNotification($userId, $notificationMessage);
            
            return $this->respond([
                'success' => true,
                'message' => 'Successfully enrolled in the course',
                'course' => $course,
                'enrollment' => $enrollmentData,
                'csrf' => csrf_hash()
            ], 200);
        } else {
            return $this->respond([
                'success' => false,
                'message' => 'Failed to enroll in the course'
            ], 500);
        }
    }
    /**
     * Display course details with materials
     *
     * @param int $id Course ID
     * @return mixed
     */
    public function view($id = null)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $courseModel = new CourseModel();
        $enrollmentModel = new EnrollmentModel();
        $userModel = new UserModel();
        $materialModel = new MaterialModel();
        
        // Get course details
        $course = $courseModel->getCourse($id);
        
        if (!$course) {
            return redirect()->to('/courses')->with('error', 'Course not found');
        }
        
        // Check if current user is enrolled
        $isEnrolled = false;
        $enrollment = null;
        
        if (session()->has('id')) {
            $userId = session()->get('id');
            $isEnrolled = $enrollmentModel->isAlreadyEnrolled($userId, $id);
            if ($isEnrolled) {
                $enrollment = $enrollmentModel->where('user_id', $userId)
                                            ->where('course_id', $id)
                                            ->first();
            }
        }
        
        // Get instructor details
        $instructor = $userModel->find($course['instructor_id']);
        
        // Get enrolled students count
        $enrolledStudents = $enrollmentModel->where('course_id', $id)
                                          ->countAllResults();
        
        // STEP 6: Fetch materials for the course
        $materials = $materialModel->getCourseMaterials($id);
        
        // Check if user can upload materials (admin or course instructor)
        $canUploadMaterials = false;
        $userRole = session()->get('role');
        if ($userRole === 'admin' || ($userRole === 'teacher' && $course['instructor_id'] == session()->get('id'))) {
            $canUploadMaterials = true;
        }
        
        $this->data['course'] = $course;
        $this->data['instructor'] = $instructor;
        $this->data['isEnrolled'] = $isEnrolled;
        $this->data['enrollment'] = $enrollment;
        $this->data['enrolledStudents'] = $enrolledStudents;
        $this->data['materials'] = $materials;
        $this->data['canUploadMaterials'] = $canUploadMaterials;
        $this->data['user'] = [
            'name' => session()->get('name'),
            'role' => session()->get('role'),
            'id' => session()->get('id')
        ];
        
        return view('courses/view', $this->data);
    }
}
