<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use Validator;

class RoleController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requestRols = Role::all();
        return response()->json(['roles'=> $requestRols],$this-> successStatus);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
<<<<<<< HEAD:app/Http/Controllers/RoleController.php
    {
=======
    { 
        $validator = Validator::make($request->all(), [ 
        'nameRol' => 'required', 
        
    ]);
    if ($validator->fails()) { 
        return response()->json(['error'=>$validator->errors()], 401);            
    }

    $rolFound = Rol::where('nameRol',$request['nameRol'])->get();
    $valor = count($rolFound);
    
    if($valor == 1){
        $message = 'El rol ya esta registrado '.$request['nameRol'];
        return response()->json(['message'=>$message], 200); 
    }
>>>>>>> 95afc076b4b0c0aaf4f52d5816be1219c9a6f555:app/Http/Controllers/RolController.php
        $input = $request->all(); 
        $rol = Role::create($input); 
        return response()->json(['message'=> $rol], $this-> successStatus); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rol = Role::find($id);
        return response()->json($rol, $this-> successStatus);
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
