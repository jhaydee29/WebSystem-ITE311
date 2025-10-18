<?php
namespace App\Models;

use CodeIgniter\Model;

class CourseModel extends Model
{
    protected $table = 'courses';
    protected $primaryKey = 'id';
<<<<<<< HEAD
    protected $allowedFields = [
        'title', 
        'description', 
        'instructor_id', 
        'level', 
        'duration', 
        'module_count',
        'learning_outcomes',
        'prerequisites',
        'created_at', 
        'updated_at'
    ];
    protected $useTimestamps = true;
    
    // Validation rules for creating/updating courses
    protected $validationRules = [
        'title' => 'required|min_length[5]|max_length[255]',
        'description' => 'required|min_length[10]',
        'instructor_id' => 'required|is_natural_no_zero',
        'level' => 'permit_empty|in_list[Beginner,Intermediate,Advanced,All Levels]',
        'duration' => 'permit_empty|string|max[100]',
        'module_count' => 'permit_empty|integer|greater_than_equal_to[0]',
        'learning_outcomes' => 'permit_empty|string',
        'prerequisites' => 'permit_empty|string'
    ];
    
    protected $validationMessages = [
        'title' => [
            'required' => 'Course title is required',
            'min_length' => 'Course title must be at least 5 characters long',
            'max_length' => 'Course title cannot exceed 255 characters'
        ],
        'description' => [
            'required' => 'Course description is required',
            'min_length' => 'Description must be at least 10 characters long'
        ],
        'instructor_id' => [
            'required' => 'Instructor is required',
            'is_natural_no_zero' => 'Please select a valid instructor'
        ]
    ];
=======
    protected $allowedFields = ['title', 'description', 'instructor_id', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
>>>>>>> 4ea0f464c41604ac8b9ef56ccd448fdc7b56931e

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
<<<<<<< HEAD
    
    /**
     * Get courses by instructor
     *
     * @param int $instructorId
     * @return array
     */
    public function getInstructorCourses($instructorId)
    {
        return $this->where('instructor_id', $instructorId)
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }
    
    /**
     * Get popular courses (most enrolled)
     * 
     * @param int $limit Number of courses to return
     * @return array
     */
    public function getPopularCourses($limit = 5)
    {
        return $this->select('courses.*, COUNT(enrollments.id) as enrollment_count')
                   ->join('enrollments', 'enrollments.course_id = courses.id', 'left')
                   ->groupBy('courses.id')
                   ->orderBy('enrollment_count', 'DESC')
                   ->limit($limit)
                   ->findAll();
    }
    
    /**
     * Search courses by keyword
     * 
     * @param string $keyword
     * @return array
     */
    public function searchCourses($keyword)
    {
        return $this->like('title', $keyword)
                   ->orLike('description', $keyword)
                   ->orLike('learning_outcomes', $keyword)
                   ->findAll();
    }
    
    /**
     * Get courses with filters
     * 
     * @param array $filters
     * @return array
     */
    public function getFilteredCourses($filters = [])
    {
        $builder = $this;
        
        if (!empty($filters['level'])) {
            $builder->where('level', $filters['level']);
        }
        
        if (!empty($filters['instructor_id'])) {
            $builder->where('instructor_id', $filters['instructor_id']);
        }
        
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $builder->groupStart()
                   ->like('title', $search)
                   ->orLike('description', $search)
                   ->orLike('learning_outcomes', $search)
                   ->groupEnd();
        }
        
        // Add sorting
        $sortField = $filters['sort'] ?? 'created_at';
        $sortOrder = $filters['order'] ?? 'DESC';
        $builder->orderBy($sortField, $sortOrder);
        
        // Add pagination
        if (!empty($filters['per_page'])) {
            $perPage = (int)$filters['per_page'];
            $page = (int)($filters['page'] ?? 1);
            
            return [
                'courses' => $builder->paginate($perPage, 'default', $page),
                'pager' => $this->pager
            ];
        }
        
        return $builder->findAll();
    }
=======
>>>>>>> 4ea0f464c41604ac8b9ef56ccd448fdc7b56931e
}
