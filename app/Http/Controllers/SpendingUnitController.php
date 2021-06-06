<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\SpendingUnit;
use App\AdministrativeUnit;
use App\Faculty;
use App\Role;
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
        $spendingUnits = SpendingUnit::select("id","nameUnidadGasto","faculties_id")->get();
        foreach ($spendingUnits as $key => $gasto) {
            $id_facultad = $gasto->faculties_id;
            //para mostrar en la columna Facultad de la lista de Unidades de gasto
            $facultad = Faculty::find($id_facultad);
            //$nameFaculty = $facultad['nameFacultad'];
            //$gasto['faculty'] = $nameFaculty;
            $gasto['faculty'] =  $facultad;
            $users = User::select("id")->where('spending_units_id', $gasto['id'])->get();
            $numUsers = count($users);
            $gasto['admin']=null;
            $userF['id'] = '';
            $userF['name'] = 'Seleccione';
            $userF['lastName'] = 'administrador';
            if($numUsers>0){
                $rolr = Role::where('nameRol','Jefe unidad de gasto')->get();
                $rol = $rolr[0];
                $usersd=$rol->users()->get();
                $numUsersd = count($usersd);
                foreach($usersd as $keyu => $user){
                    $id_us=$user['id'];
                    $userUnit=User::select("id","name","lastName")->where('spending_units_id', $gasto['id'])->where('id',$id_us)->get();
                    $numUserUnit = count($userUnit);
                    if($numUserUnit==1){
                        $userN=$userUnit[0];
                        $gasto['admin']=$userN;
                    }
                    else{
                        if($gasto['admin']==null && $keyu==$numUsersd-1){
                            $gasto['admin'] = $userF;
                        }
                    }
                }
                //$id_rol = $rol['id'];
                //dd($er);
                /**foreach($users as $keyu => $user){
                    $roles = $user->roles()->orderBy('id','DESC')->get();
                    //dd($roles);
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
                }*/
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
          $idUser = $input['idUser'];
          if($idUser!=null){
               //$requestSpendingUnit = $request->only('nameUnidadGasto','faculties_id');
               //$spendingUnit = SpendingUnit::create($requestSpendingUnit);
               $user2 = User::find($idUser);
               //$user2->roles()->sync(2,['spending_units_id' =>6,'administrative_units_id' =>237]);
               $user2->roles()->updateExistingPivot(2,['spending_units_id' =>7111,'administrative_units_id' =>1000]);
               dd('llego aqui');
               //$it=2;
               //consulta para obtener usuarios que pertenecen a un rol
               //$pp = Role::with(['users' =>  function($query) use($it) {
                //$query->whereRoleId($it);
            //}])->get();
            //otra forma
            //$pp = Role::has('users')->with(['users' =>  function($query) use($it) {
             //   $query->whereRoleId($it);
            //}])->get();
             //  dd($pp);
               $trs = $user2->roles;
               foreach($trs as $ku => $tr){
                   $eyu = $tr->pivot->spending_units_id;
                   //dd($eyu);
                }

                //$user2['spending_units_id'] = $spendingUnit['id'];
                $user2->update();
               //$user2->roles()->attach(3,['spending_units_id'=>3,'administrative_units_id'=>2]);
               return response()->json(['message'=> "Registro exitoso"], $this-> successStatus); 
          }else{
               $spendingUnit = SpendingUnit::create($input); 
               return response()->json(['message'=> "Registro exitoso"], $this-> successStatus); 
          }
        }

        $input = $request->all();
        $idUser = $input['idUser'];
       //si se le manda el id del usuario entonces registra a ese usuario como administrador de la unidad creada
       if($idUser!=null){
            $requestSpendingUnit = $request->only('nameUnidadGasto','faculties_id');
            $spendingUnit = SpendingUnit::create($requestSpendingUnit);
            $user2 = User::find($id_user);
            //$user2->roles()->attach(2);
            $user2['spending_units_id'] = $spendingUnit['id'];
            $user2->update();
            //$user2->roles()->attach(3,['spending_units_id'=>3,'administrative_units_id'=>2]);
            //$user2->roles()->update();
            return response()->json(['message'=> "Registro exitoso"], $this-> successStatus); 
       }else{
            $spendingUnit = SpendingUnit::create($input); 
            return response()->json(['message'=> "Registro exitoso"], $this-> successStatus); 
       }
    }
    
    
    public function assignHeadUnit($idU,$idS)
    {
        //$user = User::where('id',$idU)->get();
        //$countUsers = count($user);
        //$unitExist = SpendingUnit::where('id',$idS)->get();
        //$countUnits = count($unitExist);
        //if($countUsers > 0)
        //{
        //    if($countUnits > 0)
        //    {
        //        $user2 = User::find($idU);
        //        $user2['spending_units_id'] = $idS;
        //        $user2->update();
        //        return response()->json(['res'=>true], $this-> successStatus);
        //    }
        //    else
        //    {
        //        $message = 'La unidad de gasto con id'. $idS.' no existe  ';
        //        return response()->json(['message'=>$message], 200);
        //    }
        //}
        //else
        //{
        //    $message2 = 'El usuario con id'. $idU.' no existe  ';
        //    return response()->json(['message'=>$message2], 200);
        //}
        $user = User::find($idU);
        //$arregloRoles = $user->roles()->get();
        //foreach($arregloRoles as $kr => $rol){
        //    $namerol = $rol->nameRol;
        //    if($namerol=='Jefe unidad de gasto'){
        //        $rolestatus = $rol->pivot->role_status;
        //        $adminstatus = $rol->pivot->administrative_unit_status;
        //        $spenstatus = $rol->pivot->spending_unit_status;
        //        if($rolestatus==1 && $adminstatus==0 && $spenstatus==0){
        //            $resp2[] = $user;
        //        }
        //    }
        //dd($ar);
        //if(1==2){

        //}
        //else{
            $user->roles()->attach(1,['spending_unit_id'=>$idS,'spending_unit_status'=>1]);
            $user->roles()->updateExistingPivot(1,['spending_unit_status'=>0]);
            $user->update;
        //}
        //dd($are);
        return response()->json(['message'=>true], 200);
        
    }
    
    public function assignPersonal(Request $request){
        $validator = Validator::make($request->all(), [ 
            'idUser' => 'required', 
            'spending_units_id' => 'required', 
            'idRol' => 'required',
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all();
        $tamInput = count($input);
        $id_user = $input['idUser'];
        $id_unit = $input['spending_units_id'];
        //si se le manda el id del rol entonces registra el rol que tendra ese usuario dentro la unidad
        $idRol = $input['idRol'];
        $user = User::find($id_user);
        $user['spending_units_id'] = $id_unit;
        $user->update();
        //$user->roles()->attach($idRol);
        $roles = $user->roles()->orderBy('id','DESC')->get();
        dd($roles);
        foreach($roles as $keyrl => $rol){
            $numRoles = count($roles);
            //$ty=$rol[]
            $rol_user = $rol['pivot'];
            //$tty= $rol_user['id'];
            //dd($rol_user);
            if($rol_user['role_id']==$idRol){
                $gasto['admin'] = $user;
            }
            /*else{
                if($gasto['admin']==null && $keyr==$numRoles-1){
                    $gasto['admin'] = $userF;
                }
            }*/
        }
        //$rol = $roles[$numRoles-1];
        //$rol['spending_units_id']= $id_unit;
        //$rol->update();
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
