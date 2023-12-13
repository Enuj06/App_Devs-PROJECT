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

        $question = $this->request->getPost('question');
        $answer = $this->request->getPost('answer');
        $category = $this->request->getPost('category');

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

    public function editFAQ($id)
    {
        $faqModel = new FAQModel();
        $faq = $faqModel->find($id);

        if ($faq) {
            return view('edit_faq', ['faq' => $faq]);
        } else {
            return redirect()->to('/faq')->with('error', 'FAQ not found');
        }
    }

    public function updateFAQ($id)
    {
        $faqModel = new FAQModel();
        $faq = $faqModel->find($id);

        if ($faq) {
            $data = [
                'question' => $this->request->getVar('question'),
                'answer' => $this->request->getVar('answer'),
                'category' => $this->request->getVar('category'),
            ];

            $updated = $faqModel->update($id, $data);

            if ($updated) {
                return redirect()->to('/faq')->with('success', 'FAQ updated successfully');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to update FAQ');
            }
        } else {
            return redirect()->to('/faq')->with('error', 'FAQ not found');
        }
    }

    public function deleteFAQ($id)
    {
        $faqModel = new FAQModel();
        $deleted = $faqModel->delete($id);

        if ($deleted) {
            return redirect()->to('/faq')->with('success', 'FAQ deleted successfully');
        } else {
            return redirect()->to('/faq')->with('error', 'Failed to delete FAQ');
        }
    }

    public function createannounce()
    {
        $announcement = new AnnouncementModel();
    
        $file = $this->request->getFile('userfile');
    
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads', $newName);
    
            $imageUrl = base_url('uploads/' . $newName);
    
            $data = [
                'title' => $this->request->getVar('title'),
                'content' => $this->request->getVar('content'),
                'image_url' => $imageUrl, 
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

    public function editAnnouncement($id)
    {
        $announcementModel = new AnnouncementModel();
        $announcement = $announcementModel->find($id);

        if ($announcement) {
            return view('edit_announcement', ['announcement' => $announcement]);
        } else {
            return redirect()->to('/')->with('error', 'Announcement not found');
        }
    }

    public function updateAnnouncement($id)
    {
        $announcementModel = new AnnouncementModel();
        $announcement = $announcementModel->find($id);
    
        if ($announcement) {
            $file = $this->request->getFile('userfile');
            if ($file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move('uploads', $newName);
    
                // Update the image URL along with other fields
                $imageUrl = base_url('uploads/' . $newName);
            } else {
                // Keep the existing image URL if no new image is uploaded
                $imageUrl = $announcement['image_url'];
            }
    
            // Update data including the image URL
            $data = [
                'title' => $this->request->getVar('title'),
                'content' => $this->request->getVar('content'),
                'image_url' => $imageUrl,
            ];
    
            $updated = $announcementModel->update($id, $data);
    
            if ($updated) {
                return redirect()->to('/')->with('success', 'Announcement updated successfully');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to update announcement');
            }
        } else {
            return redirect()->to('/')->with('error', 'Announcement not found');
        }
    }    

    public function deleteAnnouncement($id)
    {
        $announcementModel = new AnnouncementModel();
        $deleted = $announcementModel->delete($id);

        if ($deleted) {
            return redirect()->to('/')->with('success', 'Announcement deleted successfully');
        } else {
            return redirect()->to('/')->with('error', 'Failed to delete announcement');
        }
    }
}
