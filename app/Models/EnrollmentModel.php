<?php

namespace App\Models;

use CodeIgniter\Model;

class EnrollmentModel extends Model
{
    protected $table = 'enrollments';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'course_id', 'enrollment_date'];
    protected $useTimestamps = true;
    protected $createdField = 'enrollment_date';
    protected $updatedField = '';

    /**
     * Enroll a user in a course
     *
     * @param array $data
     * @return bool
     */
    public function enrollUser($data)
    {
        // Check if user is already enrolled
        if ($this->isAlreadyEnrolled($data['user_id'], $data['course_id'])) {
            return false;
        }

        // Set enrollment date if not provided
        if (!isset($data['enrollment_date'])) {
            $data['enrollment_date'] = date('Y-m-d H:i:s');
        }

        return $this->insert($data);
    }

    /**
     * Get all enrollments for a specific user
     *
     * @param int $user_id
     * @return array
     */
    public function getUserEnrollments($user_id)
    {
        return $this->select('enrollments.*, courses.title as course_name, courses.description')
                    ->join('courses', 'enrollments.course_id = courses.id')
                    ->where('enrollments.user_id', $user_id)
                    ->findAll();
    }

    /**
     * Check if a user is already enrolled in a specific course
     *
     * @param int $user_id
     * @param int $course_id
     * @return bool
     */
    public function isAlreadyEnrolled($user_id, $course_id)
    {
        return $this->where('user_id', $user_id)
                    ->where('course_id', $course_id)
                    ->countAllResults() > 0;
    }
}
