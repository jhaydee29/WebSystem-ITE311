<?php
namespace App\Models;

use CodeIgniter\Model;

class CourseModel extends Model
{
    protected $table = 'courses';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'description', 'instructor_id', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    /**
     * Get all available courses with instructor names
     *
     * @return array
     */
    public function getAllCourses()
    {
        return $this->select('courses.*, users.name as instructor_name')
                    ->join('users', 'users.id = courses.instructor_id', 'left')
                    ->findAll();
    }

    /**
     * Get a specific course by ID with instructor name
     *
     * @param int $courseId
     * @return object|null
     */
    public function getCourse($courseId)
    {
        return $this->select('courses.*, users.name as instructor_name')
                    ->join('users', 'users.id = courses.instructor_id', 'left')
                    ->find($courseId);
    }

    /**
     * Get courses with enrollment count for each course
     *
     * @return array
     */
    public function getCoursesWithEnrollmentCount()
    {
        return $this->select('courses.*, users.name as instructor_name, COUNT(enrollments.id) as enrollment_count')
                    ->join('users', 'users.id = courses.instructor_id', 'left')
                    ->join('enrollments', 'enrollments.course_id = courses.id', 'left')
                    ->groupBy('courses.id')
                    ->findAll();
    }
}
