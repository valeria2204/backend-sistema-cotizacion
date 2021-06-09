<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quotation;
use App\Detail;
use App\RequestDetail;
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
        return $quote;
        
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
