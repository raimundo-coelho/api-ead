<?php

namespace IDEALE\Http\Controllers\Api;

use IDEALE\Http\Requests\UserRequest;
use IDEALE\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use IDEALE\Http\Controllers\Controller;


class AuthController extends Controller
{
    use AuthenticatesUsers;

    public function login(Request $request)
    {

        // $this->validateLogin($request);
        $credentials = $this->credentials($request);
        $token = \JWTAuth::attempt($credentials);
        return $this->responseToken($token);
    }

    protected function credentials(Request $request)
    {
        $data = $request->only($this->username(), 'password');
        $usernameKey = $this->usernameKey();
        if ($usernameKey != $this->username()) {
            $data[$this->usernameKey()] = $data[$this->username()];
            unset($data[$this->username()]);
        }
        return $data;
    }

    protected function usernameKey()
    {
        $email = \Request::get('email'); //email,phone,cpf
        $validator = \Validator::make([
            'email' => $email
        ], ['email' => 'cpf']);
        if (!$validator->fails()) {
            return 'cpf';
        }
        if (is_numeric($email)) {
            return 'phone';
        }
        return 'email';
    }


    private function responseToken($token)
    {
        //
        return $token ? response()->json([
            'id' => auth()->user()->id,
            'name' => auth()->user()->name,
            'role' => auth()->user()->role,
            'access_token' => $token
        ]) :
            response()->json([
                'message' => \Lang::get('auth.failed')
            ], 403);
    }

    public function logout()
    {
        \Auth::guard('api')->logout();
        return response()->json([], 204); //No-content
    }

    public function refresh()
    {
        $token = \Auth::guard('api')->refresh();
        return ['access_token' => $token, 'name' => auth()->user()->name]; //No-content
    }


    public function sendSMS(Request $request)
    {
        $phone = $request->phone;
        $query = User::all()->where('phone', '=', "$phone")->count();
        return $query;
    }


    public function newUser(UserRequest $request)
    {
        $data = $request->all();
        $data['type'] = User::ROLE_STUDENT;
        $user = User::createFully($data);

        return $user;

    }


}