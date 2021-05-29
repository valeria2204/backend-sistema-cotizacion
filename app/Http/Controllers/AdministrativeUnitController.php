<?php

namespace App\Http\Controllers;

use App\AdministrativeUnit;
use App\Faculty;
use App\User;
use Illuminate\Http\Request;
use Validator;

class AdministrativeUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public $successStatus = 200;

    public function index()
    {
        $administrativeUnits = AdministrativeUnit::all();
        foreach ($administrativeUnits as $key => $administrativeUnit) {
            $facultie_id =  $administrativeUnit['faculties_id'];
            //para mostrar en la columna Facultad de la lista de Unidades administrativas
            $faculty = Faculty::find($facultie_id);
            $nameFaculty = $faculty['nameFacultad'];
            $administrativeUnit['faculty'] = $nameFaculty;
            $administrativeUnits[$key]=$administrativeUnit;
        }
        return response()->json(['Administrative_unit'=>$administrativeUnits],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'faculties_id' => 'required', 
            
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $input = $request->all(); 
        $id_facultad = $input['faculties_id'];
        $facultad = Faculty::find($id_facultad);
        $facultad['inUse']=1;
        $facultad->save();
        $AdministrativeUnit = AdministrativeUnit::create($input);
        return response()->json(['message'=>"Registro exitoso"], $this-> successStatus);
    }

    public function assignHeadUnit($idU,$idA)
    {
        $user = User::where('id',$idU)->get();
        $countUsers = count($user);

        $unitExist = AdministrativeUnit::where('id',$idA)->get();
        $countUnits = count($unitExist);

        if($countUsers > 0)
        {
            if($countUnits > 0)
            {
                $user2 = User::find($idU);
                $user2['administrative_units_id'] = $idA;
                $user2->update();
                return response()->json(['res'=>true], $this-> successStatus);
            }
            else
            {
                $message = 'La unidad Administrativa con id'. $idA.' no existe  ';
                return response()->json(['message'=>$message], 200);
            }

        }
        else
        {
            $message2 = 'El usuario con id'. $idU.' no existe  ';
            return response()->json(['message'=>$message2], 200);
        }
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
     * @param  \App\AdministrativeUnit  $administrativeUnit
     * @return \Illuminate\Http\Response
     */
    public function show(AdministrativeUnit $administrativeUnit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AdministrativeUnit  $administrativeUnit
     * @return \Illuminate\Http\Response
     */
    public function edit(AdministrativeUnit $administrativeUnit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AdministrativeUnit  $administrativeUnit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdministrativeUnit $administrativeUnit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AdministrativeUnit  $administrativeUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdministrativeUnit $administrativeUnit)
    {
        //
    }
}
