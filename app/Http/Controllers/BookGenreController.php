<?php

namespace App\Http\Controllers;

use App\Models\BookGenre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookGenreController extends Controller
{
    private $messages = [
        'book_id.required' => 'Поле айди книги не должнол быть пустым!!!',
        'genre_id.required' => 'Поле айди жанра не должнол быть пустым!!!',
    ];

    private $rules = [
        "book_id" => "required",
        "genre_id" => "required",
    ];
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            return $validator->errors();
        } else {
            $book = new BookGenre;
            $book->book_id = $request->book_id;
            $book->genre_id = $request->genre_id;
            $result = $book->save();
            if ($result) {
                return ['Success'];
            } else {
                return ['Error'];
            }
        }
    }

    public function all()
    {
        return DB::table('book_genres')
            ->join('books', 'book_genres.book_id', '=', 'books.id')
            ->join('genres', 'book_genres.genre_id', '=', 'genres.id')
            ->select('books.name AS name', 'genres.name AS genre')
            ->get();
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            return $validator->errors();
        } else {
            $book = BookGenre::find($request->id);
            if (!$book) {
                return ['Нет такого id'];
            }
            $book->book_id = $request->book_id;
            $book->genre_id = $request->genre_id;
            $result = $book->save();
            $result = $book->save();
            if ($result) {
                return ['Success'];
            } else {
                return ['Error'];
            }
        }
    }

    
    public function delete($id)
    {
        $author = BookGenre::find($id);
        if (!$author) {
            return ["Запись" => "$id не существует"];
        } else {
            $result = $author->delete();
            if ($result) {
                return ["Запись была удалена" => "$id"];
            }
        }
    }
}
