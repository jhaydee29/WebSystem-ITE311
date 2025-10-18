<?php

namespace App\Models;

use CodeIgniter\Model;

class AnnouncementModel extends Model
{
    protected $table = 'announcements';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'content', 'created_by', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $returnType    = 'array';

    protected $validationRules = [
        'title' => 'required|min_length[5]|max_length[255]',
        'content' => 'required',
        'created_by' => 'required|is_natural_no_zero',
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Announcement title is required',
            'min_length' => 'Title must be at least 5 characters long',
            'max_length' => 'Title cannot exceed 255 characters'
        ],
        'content' => [
            'required' => 'Announcement content is required',
        ],
        'created_by' => [
            'required' => 'Author is required',
            'is_natural_no_zero' => 'Please provide a valid author'
        ]
    ];

    /**
     * Get all announcements with author information
     *
     * @return array
     */
    public function getAnnouncementsWithAuthor()
    {
        $db = \Config\Database::connect();
        
        // Debug: Check if the query works directly
        $query = $db->query('SELECT * FROM announcements');
        $result = $query->getResultArray();
        
        // Debug output (temporary)
        // echo '<pre>';
        // print_r($result);
        // echo '</pre>';
        // die();
        
        return $this->select('announcements.*, users.name as author_name')
                   ->join('users', 'users.id = announcements.created_by')
                   ->orderBy('announcements.created_at', 'DESC')
                   ->findAll();
    }
}
