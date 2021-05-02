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
    public function register(Request $request, $idRol) 
    { 
        $validator = Validator::make($request->all(), [ 
            'userName' => 'required', 
            'email' => 'required|email', 
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $userEncontrado = User::where('ci',$request['ci'])->get();
        $valor = count($userEncontrado);
        if($valor == 1){
            $mensge = 'La cedula de identidad '.$request['ci'].' ya esta registrada ';
            return response()->json(['message'=>$mensge], 200); 
        }

        $userEncontrado = User::where('email',$request['email'])->get();
        $valor = count($userEncontrado);
        if($valor == 1){
            $mensge = 'El email '.$request['email'].' ya esta registrado';
            return response()->json(['message'=>$mensge], 200); 
        }

        $userEncontrado = User::where('userName',$request['userName'])->get();
        $valor = count($userEncontrado);
        if($valor == 1){
            $mensge = 'El nombre de usuario '.$request['userName'].' ya esta registrado';
            return response()->json(['message'=>$mensge], 200); 
        }
       
        $input = $request->all();  
        $input['password'] = $input['ci'];
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);
        $user->rols()->attach($idRol);
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
     * Modificar el rol de un usuario ya registrado
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRol($idUser, $idRol)
    {
        $user = User::find($idUser);
        $user->rols()->sync($idRol);
        return response()->json(['res'=>true], $this-> successStatus);
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
