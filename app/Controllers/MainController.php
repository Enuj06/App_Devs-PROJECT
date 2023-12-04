<?php

namespace App\Controllers;


use App\Controllers\BaseController;
use CodeIgniter\Restful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\MainModel;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Orhanerday\OpenAi\OpenAi;

class MainController extends ResourceController
{
    public function getData(){
        $main = new MainModel();
        $data = $main->findAll();
        return $this->respond($data, 200);
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
            return $this->respond(['msg' => 'okay', 'token' => $data['token']], 200);
        } else {
            return $this->respond(['msg' => 'invalid'], 200);
        }
    } else {
        return $this->respond(['msg' => 'invalid'], 200);
    }
}
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

    public function index()
    {
        return view('chatbot_interaction');
    }
}
