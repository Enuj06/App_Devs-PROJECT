<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Restful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\MainModel;
use GuzzleHttp\Client;

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
        $input = $this->request->getPost('message');
        $apiKey = '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'; 
    
        $client = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ],
        ]);
    
        try {
            $response = $client->post('engines/davinci/completions', [
                'json' => [
                    'prompt' => $input,
                    'max_tokens' => 50, 
                ],
            ]);
    
            if ($response->getStatusCode() === 200) {
                $openaiResponse = $response->getBody()->getContents();
                $result = json_decode($openaiResponse, true); // Define $result here
                return $this->response->setJSON(['response' => $result]);
            } else {
                return $this->response->setStatusCode($response->getStatusCode())->setJSON(['error' => 'Unexpected status code']);
            }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $errorMessage = $e->getMessage();
            return $this->response->setStatusCode(500)->setJSON(['error' => $errorMessage]);
        }
    }

    public function index()
    {
        
    }
}
