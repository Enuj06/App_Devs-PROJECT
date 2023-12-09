<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Restful\ResourceController;
use App\Models\AnnouncementModel;
use CodeIgniter\API\ResponseTrait;
use App\Models\MainModel;
use App\Models\FaqModel;

class AdminController extends ResourceController
{
    public function index()
    {
        return view('faq');
    }

    public function createFAQ()
    {
        $faqModel = new FAQModel();

        // Retrieve form data
        $question = $this->request->getPost('question');
        $answer = $this->request->getPost('answer');
        $category = $this->request->getPost('category');

        // Prepare the data to insert into the FAQ table
        $data = [
            'question' => $question,
            'answer' => $answer,
            'category' => $category
        ];

        $inserted = $faqModel->insert($data);

        if ($inserted) {
            return redirect()->to('/faq')->with('success', 'FAQ added successfully');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to add FAQ');
        }
    }

    public function createannounce()
    {
        $announcement = new AnnouncementModel();
    
        // Handle the image upload
        $file = $this->request->getFile('userfile');
    
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads', $newName);
    
            // Include the image URL in the announcement data
            $imageUrl = base_url('uploads/' . $newName);
    
            // Get other announcement data
            $data = [
                'title' => $this->request->getVar('title'),
                'content' => $this->request->getVar('content'),
                'image_url' => $imageUrl, // Include the image URL in the data
            ];
    
            $saved = $announcement->save($data);
    
            if ($saved) {
                return $this->respond(['msg' => 'Announcement created successfully']);
            } else {
                return $this->respond(['msg' => 'Failed to create announcement'], 500);
            }
        } else {
            return $this->respond(['msg' => 'Failed to upload image'], 500);
        }
    }    

    public function fetchAnnouncements()
    {
        $announcementModel = new AnnouncementModel();
        $announcements = $announcementModel->findAll(); // Fetch all announcements
    
        if ($announcements) {
            return $this->response->setJSON($announcements); // Return the announcements as a JSON response
        } else {
            return $this->respond(['msg' => 'No announcements found'], 404);
        }
    }
}
