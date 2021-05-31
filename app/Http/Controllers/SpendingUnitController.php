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
            $users = User::where('spending_units_id', $gasto['id'])->get();
            $numUsers = count($users);
            $gasto['admin']=null;
            $userF['id'] = '';
            $userF['name'] = '';
            $userF['lastName'] = '';
            if($numUsers>0){
                foreach($users as $keyu => $user){
                    $roles = $user->roles()->get();
                    foreach($roles as $keyr => $rol){
                        $numRoles = count($roles);
                        if($rol['nameRol']=='Jefe unidad de gasto'){
                            $gasto['admin'] = $user;
                        }
                        else{
                            if($gasto['admin']==null && $keyr==$numRoles-1){
                                $gasto['admin'] = $userF;
                            }
                        }
                    }
                }
            }
            else{
                $gasto['admin'] = $userF;
            }
            $spendingUnits[$key]=$gasto;
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
          $tamInput = count($input);
          if($tamInput==3){
               $requestSpendingUnit = $request->only('nameUnidadGasto','faculties_id');
               $spendingUnit = SpendingUnit::create($requestSpendingUnit);
               $id_user = $input['idUser'];
               $user2 = User::find($id_user);
               $user2['spending_units_id'] = $spendingUnit['id'];
               $user2->update();
               return response()->json(['message'=> "Registro exitoso"], $this-> successStatus); 
          }else{
               $spendingUnit = SpendingUnit::create($input); 
               return response()->json(['message'=> "Registro exitoso"], $this-> successStatus); 
          }
        }

       $input = $request->all();
       $tamInput = count($input);
       //si se le manda el id del usuario entonces registra a ese usuario como administrador de la unidad creada
       if($tamInput==3){
            $requestSpendingUnit = $request->only('nameUnidadGasto','faculties_id');
            $spendingUnit = SpendingUnit::create($requestSpendingUnit);
            $id_user = $input['idUser'];
            $user2 = User::find($id_user);
            $user2['spending_units_id'] = $spendingUnit['id'];
            $user2->update();
            return response()->json(['message'=> "Registro exitoso"], $this-> successStatus); 
       }else{
            $spendingUnit = SpendingUnit::create($input); 
            return response()->json(['message'=> "Registro exitoso"], $this-> successStatus); 
       }
    }
    
    
    public function assignHeadUnit($idU,$idS)
    {
        $user = User::where('id',$idU)->get();
        $countUsers = count($user);

        $unitExist = SpendingUnit::where('id',$idS)->get();
        $countUnits = count($unitExist);

        if($countUsers > 0)
        {
            if($countUnits > 0)
            {
                $user2 = User::find($idU);
                $user2['spending_units_id'] = $idS;
                $user2->update();
                return response()->json(['res'=>true], $this-> successStatus);
            }
            else
            {
                $message = 'La unidad de gasto con id'. $idS.' no existe  ';
                return response()->json(['message'=>$message], 200);
            }

        }
        else
        {
            $message2 = 'El usuario con id'. $idU.' no existe  ';
            return response()->json(['message'=>$message2], 200);
        }
    }
    
    /**public function assignPersonal(Request $request){
        $validator = Validator::make($request->all(), [ 
            'idUser' => 'required', 
            'spending_units_id' => 'required', 
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all();
        $tamInput = count($input);
        $id_user = $input['idUser'];
        $id_unit = $input['spending_units_id'];
        //si se le manda el id del rol entonces registra el rol que tendra ese usuario dentro la unidad
        if($tamInput==3){
            $idRol = $input['idRol'];
            $user = User::find($id_user);
            $user['spending_units_id'] = $id_unit;
            $user->update();
            //$user->roles()->attach($idRol);
            $roles = $user->roles()->get();
            $numRoles = count($roles);
            $rol = $roles->last();
            dd($rol);
            //$rol['spending_units_id']= $id_unit;
            //$rol->update();
            return response()->json(['message'=> "Registro exitoso"], $this-> successStatus); 
        }
        else{
            $user = User::find($id_user);
            $user['spending_units_id'] = $id_unit;
            $user->update();
            return response()->json(['message'=> "Registro exitoso"], $this-> successStatus); 
        }
    }*/
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
