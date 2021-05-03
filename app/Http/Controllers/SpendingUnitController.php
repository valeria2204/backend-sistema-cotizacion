<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SpendingUnit;
use App\AdministrativeUnit;
use App\Faculty;
use Validator;

class SpendingUnitController extends Controller
{
    //
    public $successStatus = 200;
    /**
     * Devuelve todos las unidades de gasto que existen en la base de datos
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $spendingUnits = SpendingUnit::all();
        $countSpendingUnits = count($spendingUnits);
        for ($id = 1; $id <= $countSpendingUnits; $id++)
        {
             $spendingUnit = SpendingUnit::find($id);
             $administrative_unit_id = $spendingUnit['administrative_units_id'];
             $administrativeUnit = AdministrativeUnit::find($administrative_unit_id);
             $spendingUnit['administrativeUnit'] = $administrativeUnit;
             $facultie_id =  $administrativeUnit['faculties_id'];
             $faculty = Faculty::find($facultie_id);
             $spendingUnit['faculty'] = $faculty;
             $i = $id-1;
             $spendingUnits[$i] = $spendingUnit;
        }
        return response()->json(['spending units'=> $spendingUnits],$this-> successStatus);
    }

    /**
     * Recibe un solicitud para poder crear una nueva unidad de gasto
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $validator = Validator::make($request->all(), [ 
            'nameUnidadGasto' => 'required', 
            'administrative_units_id' => 'required', 
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $input = $request->all(); 
        $spendingUnit = SpendingUnit::create($input); 
        return response()->json(['message'=> $spendingUnit], $this-> successStatus); 
    }

    /**
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
