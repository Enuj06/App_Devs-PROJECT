<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ReserveModel;

class ReservationController extends BaseController
{
    public function index()
    {
        $scheduleModel = new ReserveModel();
        $data['appointments'] = $scheduleModel->findAll(); // Fetch all appointments from the database

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

                $scheduleData = [
                    'appointment_date' => $this->request->getPost('appointment_date'),
                    'start_time' => $this->request->getPost('start_time'),
                    'end_time' => $this->request->getPost('end_time'),
                    'status' => $this->request->getPost('status')
                ];

                $scheduleModel->insert($scheduleData);

                return redirect()->to('/schedule'); 
            } else {
                $data['validation'] = $validation;
            }
        }
        return view('schedule/create', $data); 
    }
    public function edit($scheduleId)
    {
        $scheduleModel = new ReserveModel();
        $data['schedule'] = $scheduleModel->find($scheduleId);
    
        if (empty($data['schedule'])) {
            return redirect()->to('/schedule'); 
        }
    
        return view('schedule', $data);
    }
    
    public function update($scheduleId)
    {
        $scheduleModel = new ReserveModel();
        $data['schedule'] = $scheduleModel->find($scheduleId);
    
        if (empty($data['schedule'])) {
            return redirect()->to('/schedule'); // Redirect to schedule list if schedule ID is invalid
        }
    
        if ($this->request->getMethod() === 'post') {
            $validation = \Config\Services::validation();
    
            $validationRules = [
                'appointment_date' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
                'status' => 'required'
            ];
    
            if ($this->validate($validationRules)) {
                $scheduleData = [
                    'appointment_date' => $this->request->getPost('appointment_date'),
                    'start_time' => $this->request->getPost('start_time'),
                    'end_time' => $this->request->getPost('end_time'),
                    'status' => $this->request->getPost('status')
                ];
    
                $scheduleModel->update($scheduleId, $scheduleData);
    
                return redirect()->to('/schedule'); // Redirect to schedule list after successful update
            } else {
                $data['validation'] = $validation;
            }
        }
    
        return view('schedule', $data); // Load the view for editing the appointment with existing data
    }

    public function delete($scheduleId)
    {
        $scheduleModel = new ReserveModel();
        $schedule = $scheduleModel->find($scheduleId);

        if (empty($schedule)) {
            return redirect()->to('/schedule'); 
        }

        $scheduleModel->delete($scheduleId);

        return redirect()->to('/schedule'); 
    }

    public function viewSchedules() {
        $scheduleModel = new ReserveModel();
        $schedules = $scheduleModel->findAll();

    }

    public function updateAvailability($scheduleId, $status) {
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

        // Retrieve the appointment data by ID
        $appointment = $scheduleModel->find($appointmentId);

        if ($appointment && $appointment['status'] === 'available') {
            $appointment['status'] = 'booked';
            $scheduleModel->save($appointment);

            return redirect()->to('/schedule')->with('success', 'Appointment booked successfully!');
        } else {
            return redirect()->to('/schedule')->with('error', 'Invalid appointment or already booked!');
        }
    }
}
