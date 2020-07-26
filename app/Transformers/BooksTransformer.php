<?php 
namespace App\Transformers;

use App\Transformers\Transformer;

class BooksTransformer extends Transformer {
    
    public function transform($book) 
    {
        return [
            "name" => $book['name'],
            "isbn" => $book['isbn'],
            "authors" => $book['authors'],
            "number_of_pages" => $book['numberOfPages'],
            "publisher" => $book['publisher'],
            "country" => $book['country'],
            "release_date" => $book['released']
        ];
    }
}