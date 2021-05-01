<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use App\User;
use App\Rol;
use Illuminate\Support\Facades\Auth; 
use Validator;

class UserController extends Controller
{
    public $successStatus = 200;
    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            return response()->json(['success' => $success], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }

    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'userName' => 'required', 
            'email' => 'required|email', 
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $userEncontrado = User::where('email',$request['email'])->get();
        $valor = count($userEncontrado);
        if($valor == 1){
            $mensge = 'El email ya esta registrado '.$request['email'];
            return response()->json(['message'=>$mensge], 200); 
        }
        $userEncontrado = User::where('ci',$request['ci'])->get();
        $valor = count($userEncontrado);
        if($valor == 1){
            $mensge = 'El cedula de identidad ya esta registrado '.$request['ci'];
            return response()->json(['message'=>$mensge], 200); 
        }
       
        $input = $request->all(); 
        //$inpu
        $input['password'] = $input['ci'];
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        return response()->json(['message'=>""], $this-> successStatus); 
    }
    /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user], $this-> successStatus); 
    } 
    /**
     * Devuelve una lista de usuarios mas su rol
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $countUsers = count($users);
        for ($id = 1; $id <= $countUsers; $id++)
        {
             $user = User::find($id);
             $rol = $user->rols()->get();
             $user['userRol'] = $rol;
             $i = $id-1;
             $users[$i] = $user;
        }
        return response()->json(['users'=>$users], $this-> successStatus);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
