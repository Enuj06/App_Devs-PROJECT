<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Restful\ResourceController;
use App\Models\AnnouncementModel;
use CodeIgniter\API\ResponseTrait;
use App\Models\MainModel;
use App\Models\FaqModel;
use App\Models\ReserveModel;

class ReservationController extends ResourceController
{
    public function index()
    {
        $scheduleModel = new ReserveModel();
        $data['appointments'] = $scheduleModel->findAll();

        return view('schedule', $data);
    }

    public function create()
    {
        $data = [];

        if ($this->request->getMethod() === 'post') {
            $validation = \Config\Services::validation();

            $validationRules = [
                'appointment_date' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
                'status' => 'required'
            ];

            if ($this->validate($validationRules)) {
                $scheduleModel = new ReserveModel();
                $json = $this->request;
                $scheduleData = [
                    'appointment_date' => $this->request->getVar('appointment_date'),
                    'start_time' => $this->request->getVar('start_time'),
                    'end_time' => $this->request->getVar('end_time'),
                    'status' => $this->request->getVar('status')
                ];

                $scheduleModel->save($scheduleData);
                // return $this->response(['msg' => 'okay'], 200);
                return $this->response->setStatusCode(200)->setJSON(['msg' => 'okay']);
            } else {
                return $this->response->setStatusCode(400)->setJSON(['msg' => 'validation_error', 'errors' => $validation->getErrors()]);
            }
        }

        // return view('schedule/create', $data);
    }
    public function updateSched($id)
    {
        $model = new ReserveModel();
        $sched = $model->find($id);

        if ($sched) {
            $data = [
                'appointment_date' => $this->request->getVar('appointment_date'),
                'start_time' => $this->request->getVar('start_time'),
                'end_time' => $this->request->getVar('end_time'),
                'status' => $this->request->getVar('status')
            ];

            $updated = $model->update($id, $data);

            if ($updated) {
                return redirect()->to('/faq')->with('success', 'FAQ updated successfully');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to update FAQ');
            }
        } else {
            return redirect()->to('/faq')->with('error', 'FAQ not found');
        }
    }
    public function deleteSched($id = null)
    {
        $model = new ReserveModel();
        $findById = $model->find(['user_id' => $id]);
        if (!$findById) return $this->fail('No Data Found', 404);
        $product = $model->delete($id);
        if (!$product) return $this->fail('Failed Deleted', 400);
        return $this->respondDeleted('Deleted Successfully');
    }

    public function viewSchedules()
    {
        $scheduleModel = new ReserveModel();
        $schedules = $scheduleModel->findAll();
    }

    public function updateAvailability($scheduleId, $status)
    {
        $scheduleModel = new ReserveModel();
        $schedule = $scheduleModel->find($scheduleId);

        if ($schedule) {
            $schedule['status'] = $status;
            $scheduleModel->save($schedule);

            return $this->response->setStatusCode(200)->setJSON(['msg' => 'Schedule availability updated successfully']);
        } else {
            return $this->response->setStatusCode(404)->setJSON(['msg' => 'Schedule not found']);
        }
    }
    public function bookAppointment()
    {
        $scheduleModel = new ReserveModel();

        $appointmentId = $this->request->getPost('appointment');
        $appointmentStatus = $this->request->getPost('status');

        $appointment = $scheduleModel->find($appointmentId);

        try {
            if ($appointment) {
                if (array_key_exists('status', $appointment)) {
                    if (strtolower($appointment['status']) === 'available') {
                        $appointment['status'] = 'booked';
                        $scheduleModel->save($appointment);

                        return $this->response->setStatusCode(200)->setJSON(['success' => true]);
                    } else {
                        return $this->response->setStatusCode(400)->setJSON(['success' => false, 'error' => 'Invalid appointment or already booked!']);
                    }
                } else {
                    return $this->response->setStatusCode(400)->setJSON(['success' => false, 'error' => 'Status key not found in appointment data']);
                }
            } else {
                return $this->response->setStatusCode(404)->setJSON(['success' => false, 'error' => 'Appointment not found']);
            }
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
