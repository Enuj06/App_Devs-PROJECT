<?php

namespace App\Controllers;


use App\Controllers\BaseController;
use App\Models\ReserveModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\MainModel;
use App\Models\AnnouncementModel;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Orhanerday\OpenAi\OpenAi;
use App\Models\FaqModel;

class MainController extends ResourceController
{
    public function authenticateUser()
    {
        $token = $this->request->getVar('token');
        $user = new MainModel();

        $userData = $user->where('token', $token)->first();

        if ($userData) {
            return $this->response->setStatusCode(200)->setJSON(['msg' => 'User authenticated', 'userData' => $userData]);
        } else {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Invalid token']);
        }
    }
    public function getData()
    {
        // Authenticate user before proceeding
        $authResult = $this->authenticateUser();

        if ($authResult->getStatusCode() === 200) {
            // User is authenticated, proceed with fetching data
            $main = new MainModel();
            $data = $main->findAll();
            return $this->respond($data, 200);
        } else {
            // User authentication failed
            return $authResult;
        }
    }

    public function getUser(){
        $main = new MainModel();
        $data = $main->findAll();
        return $this->respond($data, 200);
    }

    public function getSchedule(){
        $main = new ReserveModel();
        $data = $main->findAll();
        return $this->respond($data, 200);
    }

    public function getFAQ(){
        $main = new FaqModel();
        $data = $main->findAll();
        return $this->response->setStatusCode(200)->setJSON($data);
    }
    public function getAvailableAppointments(){
        $main = new ReserveModel();
        $data = $main->findAll();
        return $this->response->setStatusCode(200)->setJSON($data);
    }
    
    public function register() 
    { 

        $user = new MainModel(); 
        $token = $this->verification(50); 
        $data = [ 
            'username' => $this->request->getVar('username'), 
            'password' => password_hash($this->request->getVar('password'),PASSWORD_DEFAULT), 
            'token' => $token, 
            'status' => 'active', 
            'role' =>'user', 
        ]; 
    $u = $user->save($data); 
        if($u){ 
            return $this->respond(['msg' => 'okay', 'token' =>$token]); 
        }
        else
        { 
            return $this->respond(['msg' => 'failed']); 
        } 

    } 

    public function verification($length)
    { 
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
         return substr(str_shuffle($str_result), 
         0, $length); 
      } 
    public function login()
    {
        $username = $this->request->getVar("username");
        $password = $this->request->getVar("password");
        $user = new MainModel();
        $data = $user->where("username", $username)->first();

        if ($data) {
            $pass = $data["password"];
            $authenticatedPassword = password_verify($password, $pass);

            if ($authenticatedPassword) {
                // Include the user's role in the response
                return $this->respond([
                    'msg'   => 'okay',
                    'token' => $data['token'],
                    'role'  => $data['role'], //include the user's role
                ], 200);
            } else {
                return $this->respond(['msg' => 'invalid'], 200);
            }
        } else {
            return $this->respond(['msg' => 'invalid'], 200);
        }
    }

    
    /*
public function chatbotInteraction()
{
    $open_ai_key = 'a'; 

    $open_ai = new OpenAI([
        'key' => $open_ai_key,
        'headers' => [
            'Content-Type: application/json',
        ],
    ]);

    $prompt = $_POST['userMessage']; 

    try {
        $complete = $open_ai->completion([
            'model' => 'text-davinci-003',
            'prompt' => $prompt, 
            'temperature' => 0.9,
            'max_tokens' => 150,
            'frequency_penalty' => 0,
            'presence_penalty' => 0.6,
        ]);

        if (isset($complete['choices'][0]['text'])) {
            $responseText = $complete['choices'][0]['text'];
            $jsonResponse = json_encode(['text' => $responseText]);
            header('Content-Type: application/json');
            echo $jsonResponse;
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Unexpected response from OpenAI']);
        }
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}
*/
    public function index()
    {
        
    }
}
