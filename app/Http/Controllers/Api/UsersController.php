<?php

namespace IDEALE\Http\Controllers\Api;

use IDEALE\Http\Requests\UserRequest;
use IDEALE\Http\Resources\user\UserCollection;
use IDEALE\Http\Resources\user\UserResource;
use IDEALE\Models\User;
use IDEALE\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Nexmo\Client;
use Nexmo\Client\Credentials\Basic;

class UsersController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth:api')->except('store');
        $this->middleware('auth:api')->except(['store']);
    }

    public function index()
    {
        $users = User::all();
        return new UserCollection($users);
    }

    public function store(UserRequest $request)
    {
        /*        $data = $request->all();
                $data['type'] = User::ROLE_STUDENT;
                $data['password'] = '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm';

                $user = User::createFully($data);
                return $user;*/

        /*       $basic  = new Basic('55e605db', 'TSaKe1GDd6CpMhYA');
               $client = new Client($basic);

               $message = $client->message()->send([
                   'to' => '5532999759260',
                   'from' => 'Nexmo',
                   'text' => 'Hello from Nexmo'
               ]);*/

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.smsmarket.com.br/webservice-rest/send-single
        ?user=idealedigita
        &password=ra171830A
        &country_code=55
        &number=32999759260
        &content=Seu código de ativação é: 123123
        &campaign_id=abc123
        &type=0");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_POSTFIELDS, "Ola teste");

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/x-www-form-urlencoded",
            "Accept: application/json"
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        var_dump($response);
    }


    public function show(User $user)
    {
        return new UserResource($user);
    }


    public function update(UserRequest $request, User $user)
    {

        $data = $request->all();

        if ($data['password'] != null)
            $data['password'] = bcrypt($data['password']);
        else
            $data['password'] = \Auth::user()->getAuthPassword();


        $user->fill($data);
        $user->save();
        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([], 204);
    }


}
