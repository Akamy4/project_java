<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    private $messages = [
        'name.required' => 'Поле имя не должнол быть пустым!!!',
        'ISBN.required' => 'Поле ISBN не должнол быть пустым!!!',
        'year.required' => 'Поле год не должнол быть пустым!!!',
        'publish_id.required' => 'Поле айди издателя не должнол быть пустым!!!',
        'year.numeric' => 'Поле год должно быть цифрой!!!',
        'publish_id.numeric' => 'Поле айди издателя должно быть цифрой!!!',
    ];

    private $rules = [
        "name" => "required",
        "ISBN" => "required",
        "year" => "required|numeric",
        "publish_id" => "required|numeric",
    ];
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            return $validator->errors();
        } else {
            $book = new Book;
            $book->name = $request->name;
            $book->ISBN = $request->ISBN;
            $book->year = $request->year;
            $book->publish_id = $request->publish_id;
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
        return DB::table('books')
            ->join('publishings', 'books.publish_id', '=', 'publishings.id')
            ->join('book_genres', 'books.id', '=', 'book_genres.genre_id')
            ->join('genres', 'book_genres.genre_id', '=', 'genres.id')
            ->select(
                'books.name AS name',
                'ISBN',
                'year',
                'publishings.name AS publish',
                'book_genres.genre_id AS genre',
                'genres.name AS genre_name',
            )
            ->get();
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            return $validator->errors();
        } else {
            $book = Book::find($request->id);
            if (!$book) {
                return ['Нет такого id'];
            }
            $book->name = $request->name;
            $book->ISBN = $request->ISBN;
            $book->year = $request->year;
            $book->publish_id = $request->publish_id;
            $result = $book->save();
            if ($result) {
                return ['Success'];
            } else {
                return ['Error'];
            }
        }
    }

    public function by_name($name)
    {
        $res = DB::table('books')
            ->join('publishings', 'books.publish_id', '=', 'publishings.id')
            ->select('books.name AS name', 'ISBN', 'year', 'publishings.name AS publish')
            ->where('books.name', 'like', "%$name%")
            ->get();
        if ($res) {
            return $res;
        }
    }

    public function by_id($id)
    {
        return DB::table('books')
            ->join('publishings', 'books.publish_id', '=', 'publishings.id')
            ->select('books.name AS name', 'ISBN', 'year', 'publishings.name AS publish')
            ->where('books.id', '=', $id)
            ->get();
    }

    public function delete($id)
    {
        $author = Book::find($id);
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
