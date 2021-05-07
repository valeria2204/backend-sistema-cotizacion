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
     * Devuelve todos las unidades de gasto que existen en la base de datos, mas su facultad
     *  y unidad administrativa correspondiente.
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
             $facultie_id =  $spendingUnit['faculties_id'];
             $faculty = Faculty::find($facultie_id);
             $spendingUnit['faculty'] = $faculty;;
             $administrativeUnit = AdministrativeUnit::find($facultie_id);
             $spendingUnit['administrativeUnit'] = $administrativeUnit;
             $i = $id-1;
             $spendingUnits[$i] = $spendingUnit;
        }
        return response()->json(['spending_units'=> $spendingUnits],$this-> successStatus);
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
            'faculties_id' => 'required', 
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $spendingeUnitFound = SpendingUnit::where('nameUnidadGasto',$request['nameUnidadGasto'])->get();
        $valor = count($spendingeUnitFound);
        
        if($valor == 1){
            $message = 'El nombre '.$request['nameUnidadGasto'].' ya esta registrado ';
            return response()->json(['message'=>$message], 200); 
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
