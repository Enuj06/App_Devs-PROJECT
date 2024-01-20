<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Restful\ResourceController;
use App\Models\AnnouncementModel;
use CodeIgniter\API\ResponseTrait;
use App\Models\MainModel;
use App\Models\FaqModel;
use App\Models\ReserveModel;
use App\Models\AppointmentModel;

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
        try {
            $appointmentData = $this->request->getJSON();
    
            // Ensure that the 'appointment' key exists in the JSON payload
            if (!isset($appointmentData->appointment)) {
                return $this->respond(['error' => 'Invalid JSON payload. Missing appointment field.'], 400);
            }
    
            $appointmentId = $appointmentData->appointment;
            $data = [
                 'userid' =>  $appointmentData->user_id,
            'reason' =>  $appointmentData->reason,
            'appointmentid' =>  $appointmentData->appointment,
    
            ];
    
            $scheduleModel = new ReserveModel();
            $appointment = $scheduleModel->find($appointmentId);
    
            if (!$appointment) {
                return $this->respond(['error' => 'Appointment not found'], 404);
            }
    
            if ($appointment['status'] !== 'Available') {
                return $this->respond(['error' => 'Invalid appointment or already booked!'], 400);
            }

                    // Update the appointment status to 'Booked'
        $appointment['status'] = 'Booked';
        $scheduleModel->update($appointmentId, $appointment);
        $appointmentmodel = new AppointmentModel();
        $appointmentmodel->insert($data);
        return $this->respond(['success' => true, 'msg' => 'Appointment booked successfully']);
    } catch (\Exception $e) {
        return $this->respond(['error' => $e->getMessage()], 500);
        }
    }

}
