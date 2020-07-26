<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Transformers\LocalBooksTransformer;
use App\Http\Controllers\ApiController;

use Validator;

class BooksController extends ApiController
{
    protected $bookTransformer;

    public function __construct(LocalBooksTransformer $bookTransformer) 
    {
        $this->bookTransformer = $bookTransformer;
    }

    public function index()
    {
        $books = Book::all();

        $data = $this->bookTransformer->transformCollection($books->toArray());
        return $this->respondSuccess($data);
    }


    public function show($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return $this->respondWithError('Book not found.');
        }
        
        $data = $this->bookTransformer->transform($book);
        return $this->respondSuccess($data);
    }


    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'isbn' => 'required|string',
            'authors' => 'required|array',
            'country' => 'required|string',
            'number_of_pages' => 'required|numeric',
            'publisher' => 'required|string',
            'release_date' => 'required|date'
        ]);       
    
        if ($validator->fails()) {
            $message = $validator->errors();
            return $this->setStatusCode(401)->setStatus("fail")->respondWithError($message);
        }   
        
        $data = $request->all();

        $data['authors'] = json_encode($data['authors']);
        $book = Book::create($data);
        
        $data = array(
            "book"  => $book
        );

        $book = $this->bookTransformer->transform($book);

        return $this->respondWithCreateSuccess($book);       
    }

    public function update(Request $request, $id)
    {      

        $updated_at = date('Y-m-d H:i:s');
        
        $data_array = $request->all();
        
        $data_array['updated_at'] = $updated_at;

        if($request->has('authors'))
            $data_array['authors'] = json_encode($data_array['authors']);

        $book = Book::find($id);

        $book->update($data_array);

        $book = Book::find($id);
        $data = $this->bookTransformer->transform($book);
        $message = "The book {$book->name} was updated successfully";
        return $this->setMessage($message)->respondWithMessage($data);       
    }

    public function destroy($id)
    {
        $book = Book::find($id);
        $message = "The book {$book->name} was deleted successfully";
        $book->delete();
        return $this->setMessage($message)->respondWithMessage([]); 
    }    
}
