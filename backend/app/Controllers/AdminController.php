<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Restful\ResourceController;
use App\Models\AnnouncementModel;
use CodeIgniter\API\ResponseTrait;
use App\Models\MainModel;
use App\Models\FaqModel;
use App\Models\ReserveModel;
use App\Models\FeedbackModel;

class AdminController extends ResourceController
{
    public function index()
    {
        return view('faq');
    }

    public function createFAQ()
    {
        $faqModel = new FAQModel();

        $question = $this->request->getJSON()->question;
        $answer = $this->request->getJSON()->answer;

        $data = [
            'question' => $question,
            'answer' => $answer,
        ];

        $inserted = $faqModel->insert($data);

        if ($inserted) {
            return $this->respond(['msg' => 'okay']);
        } else {
            return $this->respond(['msg' => 'failed']);
        }
    }

    public function getFAQById($id)
    {
        $faqModel = new FAQModel();
        $faq = $faqModel->find($id);

        if ($faq) {
            return $this->response->setStatusCode(200)->setJSON($faq);
        } else {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'FAQ not found']);
        }
    }

    public function getannounce()
    {
        return view('announcement');
    }

    public function editFAQ($id)
    {
        $faqModel = new FAQModel();
        $faq = $faqModel->find($id);

        if ($faq) {
            // Log or debug statement
            log_message('info', 'FAQ found for ID ' . $id);

            return view('edit_faq', ['faq' => $faq]);
        } else {
            // Log or debug statement
            log_message('error', 'FAQ not found for ID ' . $id);

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

    public function deleteFAQ($id = null)
    {
        $model = new FaqModel();
        $findById = $model->find(['user_id' => $id]);
        if (!$findById) return $this->fail('No Data Found', 404);
        $product = $model->delete($id);
        if (!$product) return $this->fail('Failed Deleted', 400);
        return $this->respondDeleted('Deleted Successfully');
    }
    public function createannounce()
    {
        $request = $this->request;

        $data = [
            'title' => $request->getPost('title'),
            'content' => $request->getPost('content'),
        ];

        if ($request->getFile('image_url')->isValid()) {
            $image = $request->getFile('image_url');

            $imageName = $image->getName();

            $data['image_url'] = $this->handleRoomImageUpload($image, $imageName);
        }

        $roomModel = new AnnouncementModel(); // Assuming you have a RoomModel

        try {
            $roomModel->insert($data);
            return $this->respond(["message" => "Room data saved successfully"], 200);
        } catch (\Exception $e) {
            return $this->respond(["message" => "Failed to save room data: " . $e->getMessage()], 500);
        }
    }
    public function updateannounc($id)
    {
        $request = $this->request;

        $data = [
            'title' => $request->getPost('title'),
            'content' => $request->getPost('content'),
        ];

        $image = $request->getFile('image');

        if ($image->isValid()) {
            $imageName = $image->getName();
            $data['image_url'] = $this->handleRoomImageUpload($image, $imageName);
        }

        $roomModel = new AnnouncementModel();

        try {
            $roomModel->update($id, $data);
            return $this->respond(["message" => "Announcement updated successfully"], 200);
        } catch (\Exception $e) {
            return $this->respond(["message" => "Failed to update announcement data: " . $e->getMessage()], 500);
        }
    }


    public function handleRoomImageUpload($image, $imageName)
    {
        $uploadPath = 'C:\laragon\www\App_Devs-PROJECT\frontend\src\assets\img';

        $image->move($uploadPath, $imageName);
        return  $imageName;
    }
    public function updateRoom($id = null)
    {
        $request = $this->request;

        $roomModel = new AnnouncementModel();
        $existingData = $roomModel->find($id);

        if (empty($existingData)) {
            return $this->respond(["message" => "Record not found"], 404);
        }

        $data = [
            'title' => $request->getVar('title') ?? $existingData['title'],
            'content' => $request->getVar('content') ?? $existingData['content'],
        ];

        try {
            if ($data !== array_intersect_key($existingData, $data)) {
                $roomModel->update($id, $data);
                return $this->respond(["message" => "Data updated successfully"], 200);
            } else {
                return $this->respond(["message" => "No changes detected, data not updated"], 200);
            }
        } catch (\Exception $e) {
            return $this->respond(["message" => "Failed to update data: " . $e->getMessage()], 500);
        }
    }

    public function fetchFaq($id)
    {
        $model = new FaqModel();

        $data = $model->find(['id' => $id]);
        if (!$data) return $this->failNotFound('No Data Found');
        return $this->respond($data[0]);
    }
    public function fetchAnnouncements()
    {
        $announcementModel = new AnnouncementModel();
        $announcements = $announcementModel->findAll();

        if ($announcements) {
            return $this->response->setJSON($announcements); // Return the announcements as a JSON response
        } else {
            return $this->respond(['msg' => 'No announcements found'], 404);
        }
    }
    public function fetchSched($id)
    {
        $model = new ReserveModel();

        $data = $model->find(['id' => $id]);
        if (!$data) return $this->failNotFound('No Data Found');
        return $this->respond($data[0]);
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
            return $this->respondDeleted(['msg' => 'Announcement deleted successfully']);
        } else {
            return $this->fail('Failed to delete announcement', 400);
        }
    }

    public function feedback()
    {
        return view('feedback');
    }
    public function createFeedback()
    {
        $feedModel = new FeedbackModel();

        $first_name = $this->request->getJSON()->first_name;
        $last_name = $this->request->getJSON()->last_name;
        $feed_content = $this->request->getJSON()->feed_content;

        $data = [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'feed_content' => $feed_content,
        ];

        $inserted = $feedModel->insert($data);

        if ($inserted) {
            return $this->respond(['msg' => 'okay']);
        } else {
            return $this->respond(['msg' => 'failed']);
        }
    }

    public function getfeed(){
        $main = new FeedbackModel();
        $data = $main->findAll();
        return $this->response->setStatusCode(200)->setJSON($data);
    }

    public function updateFeed($id)
    {
        $feedModel = new FeedbackModel();
        $faq = $feedModel->find($id);

        if ($faq) {
            $data = [
                'first_name' => $this->request->getVar('first_name'),    //which is the variable?
                'last_name' => $this->request->getVar('last_name'),
                'feed_content' => $this->request->getVar('feed_content'),
            ];

            $updated = $feedModel->update($id, $data);

            if ($updated) {
                return redirect()->to('/feedback')->with('success', 'Feedback updated successfully');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to update Feedback');
            }
        } else {
            return redirect()->to('/feedback')->with('error', 'Feedback not found');
        }
    }

    public function deleteFeedback($id = null)
    {
        $model = new FeedbackModel();
        $findById = $model->find(['user_id' => $id]);
        if (!$findById) return $this->fail('No Data Found', 404);
        $product = $model->delete($id);
        if (!$product) return $this->fail('Failed Deleted', 400);
        return $this->respondDeleted('Deleted Successfully');
    }

    public function fetchFeed($id)
    {
        $model = new FeedbackModel();

        $data = $model->find(['id' => $id]);
        if (!$data) return $this->failNotFound('No Data Found');
        return $this->respond($data[0]);
    }
}
