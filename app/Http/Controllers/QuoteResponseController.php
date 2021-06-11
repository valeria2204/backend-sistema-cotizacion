<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quotation;
use App\Detail;
use App\Business;

class QuoteResponseController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $quotationResponse = $request->only("offerValidity","deliveryTime","paymentMethod","answerDate","observation","company_codes_id");
        $response['message']="Envio exitoso";
        $quotation = Quotation::create($quotationResponse);
        $details = $request->only("detalles");
        foreach ($details['detalles'] as $key => $detailResponse) {
            $detailResponse['quotations_id'] = $quotation->id;
            $detail=Detail::create($detailResponse);
        } 
        $idempresa= $request->only("empresaId");
        if($idempresa['empresaId']==0){
            $empresa = $request->only("nameEmpresa","email","nit","rubro");
            $newempresa = Business::create($empresa);
        }
        
        $response['status']=true;
        
        return response()->json(["response"=>$response], $this-> successStatus);
    }
    public function storageQuote(Request $request){
        $quotationResponse = $request->only("offerValidity","deliveryTime","paymentMethod","answerDate","observation","company_codes_id");
        $response['message']="Envio exitoso";
        $quotation = Quotation::create($quotationResponse);
        $response['id'] = $quotation->id;
        return response()->json(["response"=>$response], $this-> successStatus);
    }
    public function storageDetails(Request $request,$id){
        $detailResponse = $request->only("unitPrice","totalPrice","request_details_id","brand","industry","model","warrantyTime");
        $detailResponse['quotations_id'] = $id;
        $detail=Detail::create($detailResponse);
        return response()->json(["response"=>$detail->id], $this-> successStatus);
    }
    public function uploadFile(Request $request,$id)
    {
        $files = $request->file();
        foreach ($files as $file) {
            $filename = $file->getClientOriginalName();
        
            $filename= pathinfo($filename, PATHINFO_FILENAME);
            $name_File = str_replace(" ","_",$filename);
    
            $extension = $file->getClientOriginalExtension();
    
            $name = $id. "-" . $name_File . "." .$extension;
            $file->move(public_path('FilesResponseBusiness/'),$name);
        }
       
        return response()->json(["messaje"=>"Archivos guardados"]);
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
