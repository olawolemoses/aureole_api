<?php 

use Faker\Factory as Faker;
use App\Book;

class CreateBookCest
{
    protected $faker;

    function __construct()
    {
      $this->faker = Faker::create();
    }
    
    public function _before(ApiTester $I)
    {
    }

    public function makeBook($bookFields = []){
        $book = array_merge([                                                  
          'name' => $this->faker->title,
          'isbn' => $this->faker->randomNumber(),
          'authors' => json_encode([$this->faker->name]),
          'number_of_pages' => $this->faker->numberBetween(100, 500),
          'publisher' => 'Bantam Books',
          'country' => $this->faker->country,
          'release_date' => date("Y-m-d h:i:s")
        ], $bookFields);

        $book = Book::create($book);
        return $book->toArray();
    }

    // tests
    public function tryToCreate(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('/', [
          'name' => 'davert', 
          'isbn' => '978-0553103540',
          'authors' => ["George R. R. Martin"],
          'number_of_pages' => '694',
          'publisher' => 'Bantam Books',
          'country' => 'United States',
          'release_date' => '2018-03-02 10:00:00',
        ]);
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(array('status_code' => 201));        
    }

    public function tryToRead(ApiTester $I)
    {
        for($i = 0; $i<5; $i++){
          $this->makeBook();
        }

        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGet('/');
         
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();  
        $I->seeResponseContainsJson(array('status_code' => 200));   
    }  
    
    public function tryToUpdate(ApiTester $I)
    {
        $book = $this->makeBook();
        $I->sendPatch('/' . $book['id'], [
          'country' => 'Nigeria',
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(array('status_code' => 200));   
    }

    public function tryToDelete(ApiTester $I)
    {
        $book = $this->makeBook();
        $I->sendDelete('/' . $book['id']);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(array('status_code' => 200));   
    }    
}
