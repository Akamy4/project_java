<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class GenreController extends Controller
{
    private $messages = [
        'name.required' => 'Поле имя не должнол быть пустым!!!',
    ];

    private $rules = [
        "name" => "required",
    ];
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            return $validator->errors();
        } else {
            $genre = new Genre;
            $genre->name = $request->name;
            $result = $genre->save();
            if ($result) {
                return ['Success'];
            } else {
                return ['Error'];
            }
        }
    }

    public function all()
    {
        return Genre::all('name');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            return $validator->errors();
        } else {
            $genre = Genre::find($request->id);
            if (!$genre) {
                return ['Нет такого id'];
            }
            $genre->name = $request->name;
            $result = $genre->save();
            if ($result) {
                return ['Success'];
            } else {
                return ['Error'];
            }
        }
    }

    public function by_name($name)
    {
        return Genre::select('name')->where('name', 'like', "%$name%")->get();
    }

    public function by_id($id)
    {
        $genre = Genre::select('name')->where('id', $id)->get();
        return $genre;
    }

    public function delete($id)
    {
        $genre = Genre::find($id);
        if (!$genre) {
            return ["Запись" => "$id не существует"];
        } else {
            $result = $genre->delete();
            if ($result) {
                return ["Запись была удалена" => "$id"];
            }
        }
    }
}
