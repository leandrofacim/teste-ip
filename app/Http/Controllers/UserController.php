<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPostRequest;
use App\Mail\UserPostSendEmail;
use App\User;
use Exception;
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
    public function store(UserPostRequest $request)
    {
        try {
            if ($request->file('curriculo')->isValid()) {
                // $nameFile = $request->name . '.' . $request->curriculo->extension();
                $curriculo = $request->file('curriculo')->store('curriculos');
            }
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'telefone' => $request->input('telefone'),
                'endereco' => $request->input('endereco'),
                'curriculo' => $curriculo,
            ]);
    
            $ipUser = $request->ip();
            $user['ip'] = $ipUser;
    
            if ($user) Mail::to($user->email)->send(new UserPostSendEmail($user));
            
            return response()->json([
                'created' => true,
                'message' => 'Dados enviado com sucesso!',
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'created' => false,
                'message' => 'Erro: não foi possivel enviar os dados',
            ], 404);
        }
       
    }
}
