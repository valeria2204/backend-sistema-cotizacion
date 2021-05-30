<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quotation;
use App\Detail;

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
