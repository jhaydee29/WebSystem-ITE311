<?php

namespace App\Controllers;

use App\Models\EnrollmentModel;
use App\Models\CourseModel;

class Auth extends BaseController
{
    public function register()
    {
        helper(['form', 'url']);
        $data = [];

        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'name'     => 'required|min_length[2]|max_length[100]',
                'email'    => 'required|valid_email|max_length[100]',
                'password' => 'required|min_length[6]',
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $db = \Config\Database::connect();

                $newData = [
                    'name'       => trim($this->request->getPost('name')),
                    'email'      => trim($this->request->getPost('email')),
                    'password'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                    'role'       => 'student',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                try {
                    // Check if email already exists
                    $existingUser = $db->table('users')->where('email', $newData['email'])->get()->getRow();

                    if ($existingUser) {
                        session()->setFlashdata('error', 'Email already exists.');
                        return redirect()->to('/register');
                    }

                    $result = $db->table('users')->insert($newData);

                    if ($result) {
                        session()->setFlashdata('success', 'Registration successful!');
                        return redirect()->to('/login');
                    } else {
                        session()->setFlashdata('error', 'Registration failed. Please try again.');
                    }
                } catch (\Exception $e) {
                    session()->setFlashdata('error', 'Database error: ' . $e->getMessage());
                }
            }
        }

        return view('auth/register', $data);
    }

    public function login()
    {
        helper(['form', 'url']);
        $data = [];

        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'email'    => 'required|valid_email',
                'password' => 'required|min_length[6]',
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                // Validation passed - now check database
                $db = \Config\Database::connect();
                $user = $db->table('users')->where('email', $this->request->getPost('email'))->get()->getRowArray();

                if ($user) {
                    if (password_verify($this->request->getPost('password'), $user['password'])) {
                        // Store user data including role in session
                        $sessionData = [
                            'id'        => $user['id'],
                            'name'      => $user['name'],
                            'email'     => $user['email'],
                            'role'      => $user['role'],
                            'isLoggedIn'=> true,
                        ];

                        session()->set($sessionData);

<<<<<<< HEAD
                        // Redirect based on user role
                        switch ($user['role']) {
                            case 'admin':
                                return redirect()->to('/admin/dashboard');
                            case 'teacher':
                                return redirect()->to('/teacher/dashboard');
                            case 'student':
                            default:
                                return redirect()->to('/announcements');
                        }
=======
                        // Redirect all users to unified dashboard
                        return redirect()->to('/dashboard');
>>>>>>> 4ea0f464c41604ac8b9ef56ccd448fdc7b56931e
                    } else {
                        session()->setFlashdata('error', 'Wrong password.');
                        return redirect()->to('/login');
                    }
                } else {
                    session()->setFlashdata('error', 'Email not found.');
                    return redirect()->to('/login');
                }
            }
        }

        return view('auth/login', $data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    public function dashboard()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userRole = session()->get('role');
        $userId = session()->get('id');
        $db = \Config\Database::connect();

        // Debug: Check what's in session
        // $sessionData = session()->get();
        // log_message('debug', 'Dashboard Session Data: ' . json_encode($sessionData));

        // Initialize dashboard data
        $dashboardData = [
            'user' => [
                'name' => session()->get('name'),
                'role' => $userRole,
                'email' => session()->get('email')
            ]
        ];

        // Fetch role-specific data
        switch ($userRole) {
            case 'admin':
                $dashboardData['stats'] = [
                    'total_users' => $db->table('users')->countAll(),
                    'total_courses' => $db->table('courses')->countAll(),
                    'recent_registrations' => $db->table('users')
                        ->where('created_at >=', date('Y-m-d H:i:s', strtotime('-7 days')))
                        ->countAllResults(),
                    'active_courses' => $db->table('courses')->countAll()
                ];
                break;

            case 'teacher':
                $dashboardData['stats'] = [
                    'my_courses' => $db->table('courses')
                        ->where('instructor_id', $userId)
                        ->countAllResults(),
                    'total_students' => $db->table('enrollments')
                        ->join('courses', 'enrollments.course_id = courses.id')
                        ->where('courses.instructor_id', $userId)
                        ->countAllResults(),
                    'pending_submissions' => 0
                ];
                break;

            case 'student':
            default:
                // Initialize models
                $enrollmentModel = new EnrollmentModel();
                $courseModel = new CourseModel();

                // Get user's enrolled courses
                $enrolledCourses = $enrollmentModel->getUserEnrollments($userId);

                // Get all available courses
                $allCourses = $courseModel->getAllCourses();

                // Get enrolled course IDs for easy checking
                $enrolledCourseIds = array_column($enrolledCourses, 'course_id');

                // Filter available courses (not enrolled)
                $availableCourses = array_filter($allCourses, function($course) use ($enrolledCourseIds) {
                    return !in_array($course['id'], $enrolledCourseIds);
                });

                $dashboardData['stats'] = [
                    'enrolled_courses' => $db->table('enrollments')
                        ->where('user_id', $userId)
                        ->countAllResults(),
                    'completed_courses' => 0,
                    'total_submissions' => $db->table('submissions')
                        ->where('user_id', $userId)
                        ->countAllResults(),
                    'average_grade' => $db->table('submissions')
                        ->selectAvg('score')
                        ->where('user_id', $userId)
                        ->where('score IS NOT NULL')
                        ->get()
                        ->getRow()
                        ->score ?? 0
                ];

                // Add enrollment data for the dashboard view
                $dashboardData['enrolledCourses'] = $enrolledCourses;
                $dashboardData['availableCourses'] = array_values($availableCourses);

                break;
        }

        return view('dashboard', $dashboardData);
    }
}