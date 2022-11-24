<?php

namespace App\Http\Controllers;

use App\Models\Publishing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublishingController extends Controller
{
    private $messages = [
        'name.required' => 'Поле имя не должнол быть пустым!!!',
        'adress.required' => 'Поле адрес не должнол быть пустым!!!',
    ];

    private $rules = [
        "name" => "required",
        "adress" => "required",
    ];
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            return $validator->errors();
        } else {
            $publishing = new Publishing;
            $publishing->name = $request->name;
            $publishing->adress = $request->adress;
            $result = $publishing->save();
            if ($result) {
                return ['Success'];
            } else {
                return ['Error'];
            }
        }
    }

    public function all()
    {
        return Publishing::all('name');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            return $validator->errors();
        } else {
            $publishing = Publishing::find($request->id);
            if (!$publishing) {
                return ['Нет такого id'];
            }
            $publishing->name = $request->name;
            $publishing->adress = $request->adress;
            $result = $publishing->save();
            if ($result) {
                return ['Success'];
            } else {
                return ['Error'];
            }
        }
    }

    public function by_name($name)
    {
        return Publishing::select('name', 'adress')->where('name', 'like', "%$name%")->get();
    }

    public function by_id($id)
    {
        $publishing = Publishing::select('name', 'adress')->where('id', $id)->get();
        return $publishing;
    }

    public function delete($id)
    {
        $author = Publishing::find($id);
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
