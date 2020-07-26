<?php 
namespace App\Transformers;

use App\Transformers\Transformer;

class LocalBooksTransformer extends Transformer {
    
    public function transform($book) 
    {
        return [
            "name" => $book['name'],
            "isbn" => $book['isbn'],
            "authors" => $book['authors'],
            "number_of_pages" => $book['number_of_pages'],
            "publisher" => $book['publisher'],
            "country" => $book['country'],
            "release_date" => $book['release_date']
        ];
    }
}