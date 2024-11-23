<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login() {
        return view('login');
    }

    public function logout() {
        session()->forget('user');
        return redirect()->to('/login');
    }

    public function loginSubmit(Request $request, ) {
        // Form Validation

        $request->validate(
            [
                'text_username' => 'required|email', 
                'text_password' => 'required|min:6|max:24'
            ],
            [
                'text_username.required' => 'O e-mail é obrigatório.',
                'text_username.email' => 'O e-mail deve ser válido.',
                'text_password.required' => 'A senha é obrigatória.',
                'text_password.min' => 'A senha deve conter no mínimo :min caracteres',
                'text_password.max' => 'A senha deve conter no máximo :max caracteres',
            ]
            );

        // Get User Input

        $username = $request->input('text_username');
        $password = $request->input('text_password');


        // check if user exists
        $user = User::where('username', $username)
            ->where('deleted_at', NULL)
            ->first();
        
        if(!$user || !password_verify($password, $user->password)) {
            return redirect()
                    ->back()
                    ->withInput()
                    ->with('loginError', 'Usuário ou senha incorretos.');
        }

        //update last login
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        //login user

        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->username
            ]
            ]);


        return redirect()->to('/');
    }
}
