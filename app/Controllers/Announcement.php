<?php

namespace App\Controllers;

use App\Models\AnnouncementModel;

class Announcement extends BaseController
{
    protected $announcementModel;

    public function __construct()
    {
        $this->announcementModel = new AnnouncementModel();
        helper(['form', 'url']);
    }

    /**
     * Display all announcements
     *
     * @return mixed
     */
    public function index()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Please login to view announcements');
        }

        try {
            $data = [
                'title' => 'Announcements',
                'announcements' => $this->announcementModel->getAnnouncementsWithAuthor(),
                'user' => [
                    'name' => session()->get('name'),
                    'role' => session()->get('role'),
                    'id' => session()->get('id')
                ]
            ];

            return view('announcements/index', $data);
        } catch (\Exception $e) {
            // Log the error
            log_message('error', 'Error in Announcement controller: ' . $e->getMessage());
            
            // Show a user-friendly error message
            return redirect()->back()->with('error', 'An error occurred while loading announcements. Please try again later.');
        }
    }
}
