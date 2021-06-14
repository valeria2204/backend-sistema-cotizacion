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
        $quotation = Quotation::create($quotationResponse);
        $details = $request->only("detalles");
        foreach ($details['detalles'] as $key => $detailResponse) {
            $detailResponse['quotations_id'] = $quotation->id;
            $detail=Detail::create($detailResponse);
        }
        $idempresa= $request->only("empresaId");
        if($idempresa['empresaId']==0){
            $empresa = $request->only("nameEmpresa","email");
            $newempresa = Business::create($empresa);
        }
        $response['status']=true;
        $response['message']="Envio exitoso";
        return response()->json(["response"=>$response], $this-> successStatus);
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

        foreach ($requestDetail as $key => $detail)
        {
            $idDetail = $detail->id;
            $res = Detail::select('id','unitPrice','totalPrice')->where('request_details_id',$idDetail)
            ->where('quotations_id',$idCo)->get();
            $detail['detalle']= $res;
        }
        
        $quote['details'] = $requestDetail;
        return response()->json(['Cotizacion'=>$quote], $this-> successStatus);
       
        
    }

    public function getQuotes($idReq)
    {
        //sacar nombres de empresa, numero de items cotizados, el total de todos los items cotizados
        $lista = array();
        $codesCompany = CompanyCode::where('request_quotitations_id',$idReq)->get();

        $details = RequestDetail::where('request_quotitations_id',$idReq)->get();
        $nroDetails = count($details);
        
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
                    $totals = 0;

                    foreach($prices as $key3 => $price)
                    {
                      $total = $price->totalPrice;
                      $totals = $totals + $total;
                    }
                    $res['Items Cotizados'] = $nroDetails;
                    $res['Total en Bs'] = $totals;
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
