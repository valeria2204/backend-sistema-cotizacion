<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\SpendingUnit;
use App\AdministrativeUnit;
use App\Faculty;
use Validator;

class SpendingUnitController extends Controller
{
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
        foreach ($spendingUnits as $key => $gasto) {
            $id_facultad = $gasto->faculties_id;
            //para mostrar en la columna Facultad de la lista de Unidades de gasto
            $facultad = Faculty::find($id_facultad);
            $gasto['faculty'] = $facultad;
            //para mostrar en la columna Unidad Administrativa de la lista de Unidades de gasto
            $administrativeUnit = AdministrativeUnit::where('faculties_id','=',$id_facultad)->get();
            $gasto['administrativeUnit'] = $administrativeUnit[0];
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

        $spendingUnits = SpendingUnit::where('faculties_id',$request['faculties_id'])->get();
        $existenUnidadesGasto = count($spendingUnits);

        if($existenUnidadesGasto > 0)
        {
          //devuelve los datos si existen nombres de unidades de gasto iguales en una facultad
          $spendingeUnitFound = SpendingUnit::where('faculties_id',$request['faculties_id'])
                                       ->get()-> where('nameUnidadGasto',$request['nameUnidadGasto']);

          $valor = count($spendingeUnitFound);

          //devuelve mensaje si ya existe una unidad de gasto con el mismo nombre
          if($valor == 1){
              $message = 'El nombre '.$request['nameUnidadGasto'].' ya esta registrado ';
              return response()->json(['message'=>$message], 200); 
            }

          $input = $request->all();
          $spendingUnit = SpendingUnit::create($input); 
          return response()->json(['message'=> "Registro exitoso"], $this-> successStatus); 
          
        }

       $input = $request->all();
       $spendingUnit = SpendingUnit::create($input); 
       return response()->json(['message'=> "Registro exitoso"], $this-> successStatus); 
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
