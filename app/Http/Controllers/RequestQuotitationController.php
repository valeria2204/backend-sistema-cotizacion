<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facade\File;
use App\RequestQuotitation; 
use App\RequestDetail; 
use App\User;
use App\SpendingUnit;
use App\LimiteAmount;
use App\AdministrativeUnit;
<<<<<<< HEAD
use App\Faculty;
=======
>>>>>>> 8c00f561bc606e8562ce8549fdd554de6c4396ba
use Validator;
use Illuminate\Support\Facades\Storage;

class RequestQuotitationController extends Controller
{
    public $successStatus = 200;
    /**
     * Devuelve todas las solicitudes
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$requestQuotitation = RequestQuotitation::with('reports','request_details')->get();
        $requestQuotitation = RequestQuotitation::all();
        return response()->json(['request_quotitations'=>$requestQuotitation],200);
    }
    /**
     * Devuelve todas las solicitudes que perteneces a esa unidad administrativa
     *
     * @return \Illuminate\Http\Response
     */
    public function showRequestQuotationAdministrative($id)
    {
        $unidadAdministrativa = AdministrativeUnit::where('id',$id)->get();
        $idFacultad = $unidadAdministrativa->faculties_id;
        $unidadesGAsto = SpendingUnit::where('faculties_id',$idFacultad);
        $requestQuotitation = RequestQuotitation::all();
        return response()->json(['request_quotitations'=>$requestQuotitation],200);
    }
    /**
     * resive un solicitud para poder crear una nueva solictud 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $input = $request->only('nameUnidadGasto', 'aplicantName','requestDate','amount');
        $arrayDetails = $request->only('details');
        $arrayDetails=$arrayDetails['details'];
        $validator = Validator::make($request->all(), [ 
            'nameUnidadGasto' => 'required', 
            'aplicantName' => 'required', 
            'requestDate' => 'required', 
            'amount' => 'required', 
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        } 
         $requestQuotitation = RequestQuotitation::create($input);
         $idQuotitation = $requestQuotitation['id'];
         $countDetails = count($arrayDetails);
         for ($i = 0; $i < $countDetails; $i++)
         {
             $detailI=$arrayDetails[$i];
             $detailI['request_quotitations_id']= $idQuotitation;
             RequestDetail::create($detailI);
            
         }
         
         return response()->json(['success' =>$idQuotitation], $this-> successStatus);
    }
    /* public function saveFile($files , $datas){
        
        return;
    } */

    public function upload(Request $request){
        $request->file('archivo')->store('public');
        
    }

    public function uploadOne(Request $req,$id){
        
        $result = $req->file('file')->store('Archivos');
        return ["result"=>$result];
    } 
    public function download(Request $req){
        $path = storage_path('app\Archivos\KEr48AL1e7QHtSmq3CMhysAQK53FJvm0DpVJcROm.pdf');
        return response()->download($path);
    }


    public function uploadFile(Request $request,$id)
    {
       
        $tamanio = count($request->file());
        $files = $request->file();
        foreach ($files as $file) {
            $filename = $file->getClientOriginalName();
        
            $filename= pathinfo($filename, PATHINFO_FILENAME);
            $name_File = str_replace(" ","_",$filename);
    
            $extension = $file->getClientOriginalExtension();
    
            $name = date('His') . "-" . $name_File . "." .$extension;
            $file->move(public_path('FilesAquisicion/'.$id),$name);
        }
       
        return response()->json(["messaje"=>"Archivos guardados"]);
        /* if($request->hasFile('file')){
           
        }else{
            return response()->json(["messaje"=>"Error"]);
        } */
    }
    public function fileDowload(){
        return response()->download(public_path('Files/db.pdf'), "base de datos");
    }
    public function downloadFile($id,$namefile){
        $path = public_path('FilesAquisicion\\'.$id.'\\'.$namefile);
        //dd($path);
        return response()->download($path);

    }
    public function showFile($id,$namefile){
        $path = public_path('FilesAquisicion\\'.$id.'\\'.$namefile);
        //dd($path);
        return response()->file($path);
    }
    /**
     * devuelve el detalle de la solicitud cuando te pasan el id de la solitud
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {  
        //devuelve datos y detalles de una solicitud
        $requestQuotitations = RequestQuotitation::all();
        $deils = RequestDetail::where('request_quotitations_id',$id)->get();
        $requestQuotitation = $requestQuotitations->find($id);
        $requestQuotitation['details'] = $deils;      
        //sacar el monto estimado de la solicitud
        $amountEstimated =  $requestQuotitation['amount'];
        //obtener el monto limite que una unidad administrativa tiene para sus unidades de gasto
         //primero obtener la unidad de gasto desde la cual se hace la solicitud
        $spendingUnit_id = $requestQuotitation['spending_units_id'];
        $spendingUnit = SpendingUnit::find($spendingUnit_id);
        $facultie_id =  $spendingUnit['faculties_id'];
        $administrativeUnit = AdministrativeUnit::where('faculties_id',$facultie_id)->first();
        $administrativeUnit_id = $administrativeUnit['id'];
        $amountLimite = LimiteAmount::where('administrative_units_id',$administrativeUnit_id)->get()->last();
        //sacar el monto limite
        $amountTope = $amountLimite['monto'];
        $requestQuotitation['message'] = "";
        if( $amountEstimated > $amountTope){
            $requestQuotitation['message'] = "El monto es superior al tope";
        }
        return response()->json($requestQuotitation,200);
    }

    public function updateState(Request $request, $id)
    {
        $status = $request->only('status');
        $requestQuotitation = RequestQuotitation::find($id);
        $requestQuotitation['status'] = $status['status'];
        $requestQuotitation->update();
        return response()->json($requestQuotitation,200);
    }



      /**
     * devuelve los archivos adjuntos de una solicitud cuando te pasan el id de la solicitud
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showFiles($id)
    {
        $directory = public_path().'/FilesAquisicion'.'/'.$id;
        $listDir = $this-> dirToArray($directory);
        return response()->json($listDir,200);
    }

    
    //devuelve un arreglo de archivos de un directorio determinado $dir
    public function dirToArray($dir) {
        $listDir = array();
        if($handler = opendir($dir)) {
            while (($file = readdir($handler)) !== FALSE) {
                if ($file != "." && $file != "..") {
                    if(is_file($dir."/".$file)) {
                        $listDir[] = $file;
                    }elseif(is_dir($dir."/".$file)){
                        $listDir[$file] = $this->dirToArray ($dir."/".$file);
                    }
                }
            }
            closedir($handler);
        }
        return $listDir;
    }


    public function getInformation($id)
    {
        $dates = SpendingUnit::select('spending_units.nameUnidadGasto','users.name','users.lastName')
        ->join('users','spending_units.id','=','users.spending_units_id')
        ->where('users.id','=',$id)->get();
        return response()->json(["User"=> $dates],200);
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
