<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $rules = [
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/'
    ];
    private $messages = [
        'name.required' => 'Поле имя не должно бвть пустым',
        'email.required' => 'Поле почта не должно быть пустым',
        'email.email' => 'Поле почта должно содержать адрес почты',
        'password.required' => 'Поле пароль не должно быть пустым',
        'password.min' => 'Пароль должен состоять минимум из 8 символов',
        'password.regex' => 'Пароль должен содержать хотя-бы одну заглавную букву, одну прописную букву и одну цифру',
    ];
    public function authorization(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'ошибка валидации',
                'errors' => $validator->errors()
            ], 401);
        } else {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->email);
            $result = $user->save();
            if ($result) {
                return [
                    'status' => 'true',
                    'message' => 'Юзер успешно создан',
                    'token' => $user->createToken('API TOKEN')->plainTextToken
                ];
            } else {
                return ['Error'];
            }
        }
    }
}
