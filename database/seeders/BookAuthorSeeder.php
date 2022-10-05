<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookAuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(int $n)
    {
        $books = Book::limit($n)->inRandomOrder()->get('book_id');
        $authors = Author::limit($n)->inRandomOrder()->get('author_id');

        $book_authors = array();
        foreach (array_keys($books->toArray()) as $key) {
            array_push($book_authors, [
                'book_id' => $books[$key]['book_id'],
                'author_id' => $authors[$key]['author_id'],
            ]);
        }
        DB::table('book_authors')->insert($book_authors);

    }
}
