<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class AuthorController extends Controller
{
    private $messages = [
        'name.required' => 'Поле имя не должнол быть пустым!!!',
        'surname.required' => 'Поле фамилия не должнол быть пустым!!!',
    ];

    private $rules = [
        "name" => "required",
        "surname" => "required",
    ];
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            return $validator->errors();
        } else {
            $author = new Author;
            $author->name = $request->name;
            $author->surname = $request->surname;
            $result = $author->save();
            if ($result) {
                return ['Success'];
            } else {
                return ['Error'];
            }
        }
    }

    public function all()
    {
        return Author::all(['name','surname']);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            return $validator->errors();
        } else {
            $author = Author::find($request->id);
            if (!$author) {
                return ['Нет такого id'];
            }
            $author->name = $request->name;
            $author->surname = $request->surname;
            $result = $author->save();
            if ($result) {
                return ['Success'];
            } else {
                return ['Error'];
            }
        }
    }

    public function by_name($name)
    {
        return Author::select('name', 'surname')->where('name', 'like', "%$name%")->get();
    }

    public function by_id($id)
    {
        $Author = Author::select('name', 'surname')->where('id', $id)->get();
        return $Author;
    }

    public function delete($id)
    {
        $author = Author::find($id);
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
