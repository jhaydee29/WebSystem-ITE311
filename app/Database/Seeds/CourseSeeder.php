<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $courses = [
            [
                'title' => 'PHP Fundamentals',
                'description' => 'Learn the basics of PHP programming including variables, functions, and control structures.',
                'instructor_id' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Database Design',
                'description' => 'Master database architecture, SQL queries, and relational database design principles.',
                'instructor_id' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Web Development with CodeIgniter',
                'description' => 'Build dynamic web applications using the CodeIgniter PHP framework.',
                'instructor_id' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'JavaScript Essentials',
                'description' => 'Learn JavaScript programming from basics to advanced concepts including ES6+ features.',
                'instructor_id' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'HTML & CSS Mastery',
                'description' => 'Create beautiful, responsive websites with modern HTML5 and CSS3 techniques.',
                'instructor_id' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];

        foreach ($courses as $course) {
            $this->db->table('courses')->insert($course);
        }
    }
}
