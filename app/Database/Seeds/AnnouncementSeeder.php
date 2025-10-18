<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\AnnouncementModel;

class AnnouncementSeeder extends Seeder
{
    public function run()
    {
        $announcementModel = new AnnouncementModel();

        $data = [
            [
                'title' => 'Welcome to the Student Portal',
                'content' => 'We are excited to welcome all students to our new online learning platform. Please take some time to explore the features and let us know if you have any questions.',
                'created_by' => 1, // Assuming admin user with ID 1 exists
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
            ],
            [
                'title' => 'Important: System Maintenance',
                'content' => 'The student portal will be undergoing scheduled maintenance on October 20, 2025, from 1:00 AM to 5:00 AM. The system will be unavailable during this time. Please plan accordingly.',
                'created_by' => 1, // Assuming admin user with ID 1 exists
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
            ],
            [
                'title' => 'New Course Available: Advanced Web Development',
                'content' => 'We are pleased to announce our new Advanced Web Development course is now available for enrollment. This course covers modern web technologies including React, Node.js, and MongoDB.',
                'created_by' => 1, // Assuming admin user with ID 1 exists
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Using insertBatch for better performance with multiple records
        $announcementModel->insertBatch($data);

        echo "Announcements seeded successfully!\n";
    }
}
