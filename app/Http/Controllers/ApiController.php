<?php

namespace App\Http\Controllers;

class ApiController extends Controller
{
    protected $statusCode = 200;
    protected $status = "success";
    protected $message = "";

    public function getStatusCode() {
        return $this->statusCode;
    }

    public function setStatusCode($statusCode) {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function getMessage() {
        return $this->message;
    }

    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    public function responseNotFound($message = "Not Found") {
        return $this->setStatusCode(404)->setStatus("fail")->respondWithError($message);
    }

    public function respondWithError($message) {
        return $this->respond([
            "status_code" => $this->getStatusCode(),
            "status" => $this->getStatus(),
            "error" => [
                "message" => $message,
                
            ]
        ]);
    }

    public function respondWithCreateSuccess($data) {
        return $this->setStatusCode(201)->respondSuccess($data);
    }

    public function respondSuccess($data, $headers = []) {
        $response = [];
        $response['status_code'] = $this->getStatusCode();
        $response['status'] =  $this->getStatus();
        $response['data'] = $data;        
        return response()->json($response, $this->getStatusCode(), $headers);
    }

    public function respondWithMessage($data) {
        return $this->respond([
            "status_code" => $this->getStatusCode(),
            "status" => $this->getStatus(),
            "message" => $this->getMessage(),
            "data" => $data
        ]);        
    }    

    public function respond($data, $headers = []) {

        return response()->json($data, $this->getStatusCode(), $headers);
    }
} 