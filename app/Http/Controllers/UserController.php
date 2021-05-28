<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use App\User;
use App\Role;
use Illuminate\Support\Arr;
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
        if(Auth::attempt(['userName' => request('userName'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            //dd($user);
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            return response()->json(['success' => $success], $this-> successStatus);
        } 
        else{ 
            return response()->json(['error'=>'Datos incorrectos. Por favor revise su nombre de usuario y contraseña'], 401); 
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
       
        $input = $request->all();  
        $input['password'] = $input['ci'];
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);
        $user->roles()->attach($idRol);
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
        $roles=$user->roles;
        $user['roles']=$roles;
        $permissions = array();
        foreach ($roles as $key => $role) {
            $permissions[$key]=$role->permissions;
        }
        $permi=array();
        foreach ($permissions as $key => $arraypermi) {
            foreach ($arraypermi as $key => $permission) {
                array_push($permi,$permission->namePermission);
            }
        }
        $user['permissions']=$permi;
        return response()->json(['user' => $user], $this-> successStatus); 
    }
    /** 
     * permisos de usuario 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function permissions() 
    { 
        $user = Auth::user();
        $roles=$user->roles;
        $permissions = array();
        foreach ($roles as $key => $role) {
            $permissions[$key]=$role->permissions;
        }
        $permi=array();
        foreach ($permissions as $key => $arraypermi) {
            foreach ($arraypermi as $key => $permission) {
                array_push($permi,$permission->namePermission);
            }
        }
        return response()->json(['permissions' => $permi], $this-> successStatus); 
    }

    public function roles(){
        $user = Auth::user();
        $roles=$user->roles;
        return response()->json(['roles' => $roles], $this-> successStatus);
    }
    /**
     * Devuelve una lista de usuarios mas sus roles
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
             $roles = $user->roles()->get();
             $valor = count($roles);
             if($valor>1){
                $nameRol = "";
                for ($i = 0; $i < $valor; $i++)
                {
                    $rol = $roles[$i];
                    if($i==$valor-1){
                        $nameRol = $nameRol.$rol['nameRol'];
                    }
                    else{
                        $nameRol = $nameRol.$rol['nameRol'].', ';
                    }
                }
                $user['userRol'] = $nameRol;
             }
             else{
                $rold = $roles[0];
                $user['userRol'] = $rold['nameRol'];
             }
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
        $user->roles()->sync($idRol);


        return response()->json(['res'=>true], $this-> successStatus);
    }

    public function verifyPasswordChange($id)
    {
        $user = User::find($id);
        $password = $user['password'];
        $ci = $user['ci'];
        return $ci;

    }

    public function usersAdmiWithoutDrives()
    {

        $users = User::select('id','name','lastName','administrative_units_id')->get();
        $countUsers = count($users);
        $resp = array();
        foreach ($users as $key => $user)
        {
             $roles = $user->roles()->get();
             
             $countRoles = count($roles);

           if($countRoles>0)
            {
                    $rol1 = Role::where('nameRol','Jefe Administrativo')->get();
                    $unRol = $rol1[0];
                    $idRol = $unRol['id'];
                    
                    foreach ($roles as $keyR => $rol) 
                    {
                        
                        if($rol['id']==$idRol && $user['administrative_units_id']== null)
                        {
                            
                            
                            $resp[] = $user;
                        }
                        else
                        {
                            //no guarda a los usuarios          
                        }
                    }
            }
            else
            {
               //no guarda a los usuarios
            }

        }

        return response()->json(['users'=>$resp], $this-> successStatus);

    }

    public function usersSpendingWithoutDrives()
    {

        $users2 = User::select('id','name','lastName','spending_units_id')->get();
        $countUsers2 = count($users2);
        $resp2 = array();
        foreach ($users2 as $key => $user2)
        {
             $roles2 = $user2->roles()->get();
             
             $countRoles2 = count($roles2);

           if($countRoles2>0)
            {
                    $rol2 = Role::where('nameRol','Jefe Unidad de Gasto')->get();
                    $unRol2 = $rol2[0];
                    $idRol2 = $unRol2['id'];
                    
                    foreach ($roles2 as $keyR2 => $rol2) 
                    {
                        
                        if($rol2['id']==$idRol2 && $user2['spending_units_id']== null)
                        {
                            
                            
                            $resp2[] = $user2;
                        }
                        else
                        {
                            //no guarda a los usuarios          
                        }
                    }
            }
            else
            {
               //no guarda a los usuarios
            }

        }

        return response()->json(['users'=>$resp2], $this-> successStatus);

    }
    
    /**
     * Devuelve todos los usuarios pertenecientes a una unidad administrativa
     *
     * @param  int  $id de unidad administrativa
     * @return \Illuminate\Http\Response
     */
    public function showUsersUnitAdministrative($id)
    {
        $users = User::where('administrative_units_id',$id)->get();
        return response()->json(['users'=>$users], $this-> successStatus);
    }
    /**
     * Devuelve todos los usuarios pertenecientes a una unidad de gasto
     *
     * @param  int  $id de unidad administrativa
     * @return \Illuminate\Http\Response
     */
    public function showUsersUnitSpending($id)
    {
        $users = User::where('spending_units_id',$id)->get();
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
