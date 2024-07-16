<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ClientException;

class BaseClient
{
    private $accessToken;
    private $options = [];
    
    public function __construct(){
        
    }
    
    public function call($url, $params, $method = "POST"){
        
        $response = [
            "response"  => [
                "code"      => 400,
                "message"   => "Failed to call endpoint",
            ],
            "data"      => []
        ];
        
        //$push = new PushNotificationController();
        
        try {
            
            $options = [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ],
                'json' => $params,
            ];
            
            $client = new Client();
            if($method == "POST"){
                $payload = $client->post($url, $options);
            } else {
                $payload = $client->get($url, $options);
            }
            
            $response = json_decode($payload->getBody()->getContents(), true);
            
            if(!empty($response) && $payload->getStatusCode() == 200){
                return $response;
            }
        } catch (\Exception $e) {
            
            $response["response"]["message"] .= " ".$url;
            /*
             $request = array(
                'url' => $url,
                'method' => "",
                'payload' => "",
                'error_line' => "",
                'error_message' => $response["response"]["message"]
            );
            $push->telegram($request);
             
            */
        }
        
        return $response;
    }
    
    public function callApi($url, $header_params, $request_params, $method = "POST"){
        
        $response = [
            "response"  => [
                "code"      => 400,
                "message"   => "Failed to call endpoint",
            ],
            "data"      => []
        ];
        
        //$push = new PushNotificationController();
        
        try {
            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ];
            
            if(count($header_params) > 0){
                foreach ($header_params as $key => $value){
                    $headers[$key] = $value;
                }
            }
            
            $options = [
                'headers' => $headers,
                'json' => $request_params,
            ];
            
            $client = new Client();
            if($method == "POST"){
                $payload = $client->post($url, $options);
            } else {
                $payload = $client->get($url, $options);
            }
            
            if(in_array($payload->getStatusCode(), [200,201,204])){
                $response = json_decode($payload->getBody()->getContents(), true);
                if(!empty($response)){
                    return $response;
                }
            } else {
                throw new \Exception("Failed to process request");
            }
        } catch (\Exception | GuzzleException | ClientException $e) {
            Log::info("Line #".$e->getLine().": ".$e->getMessage());
            Log::info($e->getTraceAsString());

            //$isNotDuplicateData = true;
            $response["response"]["message"] = $e->getResponse()->getBody()->getContents();
            $message = json_decode($e->getResponse()->getBody()->getContents(), true);
            //$isNotDuplicateData = (is_array($message) && array_key_exists("error", $message) && array_key_exists("message", $message["error"]) && $message["error"]["message"] == "Duplicate data") ? false : true;
            /*
            if($isNotDuplicateData && self::pushNotif($response["response"]["message"])){
                $request = array(
                    'url' => $url,
                    'method' => "",
                    'payload' => "",
                    'error_line' => "",
                    'error_message' => "Line #".$e->getLine().": ".$e->getMessage()
                );
                $push->telegram($request);
            }
            */
        }
        
        return $response;
    }
    
    
    
    public function loginCouchDB($url){
        
        $response = [
            "response"  => [
                "code"      => 400,
                "message"   => "Failed to call endpoint",
            ],
            "data"      => []
        ];
        
        //$push = new PushNotificationController();
        
        try {
            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ];
            
            $options = [
                'headers' => $headers,
                'json' => ['name' => 'admin', 'password'  => 'adminpw'],
            ];
            
            $client = new Client();
            $payload = $client->post($url, $options);
            
            if(in_array($payload->getStatusCode(), [200,201,204])){
                if($payload->hasHeader("Set-Cookie") && is_array($payload->getHeader("Set-Cookie"))){
                    $response = $payload->getHeader("Set-Cookie")[0];
                    if(!empty($response)){
                        return $response;
                    }
                }
            } else {
                throw new \Exception("Failed to process request");
            }
        } catch (\Exception | GuzzleException | ClientException $e) {
            Log::channel("developer")->info("Line #".$e->getLine().": ".$e->getMessage());
            Log::channel("developer")->info($e->getTraceAsString());
            
            $response["response"]["message"] = $e->getResponse()->getBody()->getContents();
        }
        
        return $response;
    }
}