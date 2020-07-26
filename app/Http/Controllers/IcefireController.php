<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Transformers\BooksTransformer;
use App\Http\Controllers\ApiController;

class IcefireController extends ApiController
{
    //
    protected $booksTransformer;

    protected $response;

    function __construct(BooksTransformer $booksTransformer) 
    {
        $this->booksTransformer = $booksTransformer;
    }

    function index(Request $request) 
    {
        $nameOfBook = $request->query('name');
        
        if (empty($nameOfBook)) {
            return $this->responseNotFound('Book Not Found');
        }

        $client = new Client(['base_uri' => 'https://www.anapioficeandfire.com']);

        $response = $client->request('GET', '/api/books?name=' . $nameOfBook);

        $this->setResponse($response);

       $transformedData = $this->getTransformedData();

        return response()->json($transformedData, 200);
    }

    private function getResponseArray()
    {
        return json_decode($this->getJson($this->getResponse()), true);
    }

    public function getTransformedData()
    {
        $responseArray = [];
        if($this->getResponse()->getStatusCode() == "200"){
            $responseArray['status_code'] = $this->getResponse()->getStatusCode() ;
            $responseArray['status'] = "success";
            $responseArray['data'] = $this->booksTransformer->transformCollection($this->getResponseArray());
        } 
        return $responseArray;
    }

    private function getData()
    {
        return json_decode($this->getJson($this->getResponse()), true);       
    }

    private function getJson($response) 
    {
        return $response->getBody()->getContents();        
    }

    public function setResponse($response) 
    {
        $this->response = $response;

        return $this;
    }

    public function getResponse() 
    {
        return $this->response;
    }
}