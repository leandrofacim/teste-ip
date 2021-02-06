<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPost;
use App\Mail\UserPostSendEmail;
use App\User;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserPost $request)
    {
        if ($request->file('curriculo')->isValid()) {
            $nameFile = $request->nome . '.' . $request->curriculo->extension();
            $curriculo = $request->file('curriculo')->storeAs('curriculos', $nameFile);
        }
        $user = User::create([
            'name' => $request->input('nome'),
            'email' => $request->input('email'),
            'telefone' => $request->input('telefone'),
            'endereco' => $request->input('endereco'),
            'curriculo' => $curriculo,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $ipUser = $request->ip();
        $user['ip'] = $ipUser;

        if ($user) Mail::to($user->email)->send(new UserPostSendEmail($user));
        
        return response()->json([
            'data' => $user,
            'menssage' => 'Dados enviado com sucesso!',
        ], 200);
    }
}
