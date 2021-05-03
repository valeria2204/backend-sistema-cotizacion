<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rol;
use Validator;

class RolController extends Controller
{
    public $successStatus = 200;
    /**
     * Devuelve todos los roles que existen en la base de datos
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requestRols = Rol::all();
        return response()->json(['rols'=> $requestRols],$this-> successStatus);
    }

    /**
     * Recibe un solicitud para poder crear una nuevo rol 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $input = $request->all(); 
        $rol = Rol::create($input); 
        return response()->json(['message'=> $rol], $this-> successStatus); 
    }

    /**
     * Devuelve el nombre y descripcion del rol cuando te pasan el id del rol
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {     
        $rol = Rol::find($id);
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
