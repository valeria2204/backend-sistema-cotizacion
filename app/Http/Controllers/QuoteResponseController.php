<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quotation;
use App\Detail;
use App\RequestDetail;
use App\Business;
use App\CompanyCode;

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
    public function show($idCo,$idRe)
    {
        $quote = Quotation::select('id','offerValidity','deliveryTime','answerDate','paymentMethod','observation')
        ->where('id',$idCo)->get();
 
        $requestDetail = RequestDetail::select('id','amount','unitMeasure','description')
                                        ->where('request_quotitations_id',$idRe)->get();
        $quo = array();
        $quo = $quote;

        foreach ($requestDetail as $key => $detail)
        {
            $idDetail = $detail->id;

            $req = RequestDetail::select('request_details.id','request_details.amount'
             ,'request_details.unitMeasure','request_details.description','details.unitPrice','details.totalPrice')
             ->join('details','request_details.id','=','details.request_details_id')
             ->where('request_details.id','=',$idDetail)
             ->where('details.quotations_id','=',$idCo)->get();
            $quo[] = $req;
        
        }

        return response()->json(['Cotizacion'=>$quo], $this-> successStatus);
       
        
    }

    public function getQuotes($idReq)
    {
        //sacar nombres de empresa, numero de items cotizados, el total de todos los items cotizados
        $lista = array();
        $codesCompany = CompanyCode::where('request_quotitations_id',$idReq)->get();

        /*$details = RequestDetail::where('request_quotitations_id',$idReq)->get();
        $nroDetails = count($details);*/
        
        foreach($codesCompany as $key => $codeCompany)
        {
            $idCode = $codeCompany->id; 
            $emailBussi = $codeCompany->email;
            $quotations = Quotation::all();
            foreach($quotations as $key2 => $quotation)
            {
                if($quotation['company_codes_id'] == $idCode) 
                {
                    $idQuo = $quotation->id;
                    $empresa = Business::select('businesses.nameEmpresa')
                    ->join('quotations','businesses.id','=','quotations.business_id')
                    ->where('businesses.id','=',$idQuo)->get();
                    $empresa2 = $empresa[0];
                    $empresa3 = $empresa2['nameEmpresa'];
                    $res['Empresa'] = $empresa3;

                    $prices = Detail::select('totalPrice')->where('quotations_id',$idQuo)->get();
                    $nroDetails = count($prices);
                    $totals = 0;

                    foreach($prices as $key3 => $price)
                    {
                      $total = $price->totalPrice;
                      $totals = $totals + $total;
                    }
                    $res['ItemsCotizados'] = $nroDetails;
                    $res['TotalEnBs'] = $totals;
                    $res['idCotizacion'] = $idQuo;
                    $lista[] = $res;
                    
        
                
                }
            }
        }

        return response()->json(['Cotizaciones'=>$lista], $this-> successStatus);
            
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
