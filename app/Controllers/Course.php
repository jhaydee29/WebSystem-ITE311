<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CourseModel;
use App\Models\EnrollmentModel;
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

        $data = [
            'courses' => $courses,
            'enrolledCourseIds' => $enrolledCourseIds,
            'user' => [
                'name' => session()->get('name'),
                'role' => session()->get('role')
            ]
        ];

        return view('courses/index', $data);
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
            return $this->respond([
                'success' => true,
                'message' => 'Successfully enrolled in the course'
            ], 200);
        } else {
            return $this->respond([
                'success' => false,
                'message' => 'Failed to enroll in the course'
            ], 500);
        }
    }
}
