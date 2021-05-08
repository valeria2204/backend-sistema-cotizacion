<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facade\File;
use App\RequestQuotitation; 
use App\RequestDetail; 
use App\SpendingUnit;
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


    /**
     * devuelve el detalle de la solicitud cuando te pasan el id de la solitud
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {  // guarda todas las solicitudes o tuplas
        // requestQuot = requests
        $requestQuotitations = RequestQuotitation::all();
        $deils = RequestDetail::where('request_quotitations_id',$id)->get();
        $requestQuotitation = $requestQuotitations->find($id);
        $requestQuotitation['details'] = $deils;
        //para el mensaje
        $dateRequestQuotitation =  $requestQuotitation['requestDate'];
        
        $spendingUnit_name = $requestQuotitation['nameUnidadGasto'];
        $spendingUnit = SpendingUnit::where('nameUnidadGasto',$spendingUnit_name)->get();
        $facultie_id =  $spendingUnit['faculties_id'];
        $administrativeUnit = AdministrativeUnit::find($facultie_id);
        $amountLimites = $administrativeUnit->limiteAmount()->get();
        
        //validar fechas de solicitud
        //$amountLimite = amountLimites->where('dateStamp',$dateRequestQuotitation)->get();

        $amountLimite = LimiteAmount::where('administrative_units_id',$administrativeUnit_id)->get();
        $spendingUnit['administrativeUnit'] = $administrativeUnit;
        

        $isHigher = 
        $requestQuotitation['amountIsHigher'] = $isHigher;
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
