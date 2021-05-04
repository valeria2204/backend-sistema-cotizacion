<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CompanyCode; 
use App\RequestDetail;

class CompanyCodeController extends Controller
{
    //
    public $successStatus = 200;
        /**
     * devuelve el detalle de la solicitud cuando te pasan el id de la solitud
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $coder = $request->only('code');
        $code = $coder['code'];
        $companycode = CompanyCode::find($code);
        $requestQuotitation_id = $companycode['request_quotitations_id'];
        $deils = RequestDetail::where('request_quotitations_id',$requestQuotitation_id)->get();
        $companycode['details'] = $deils;
        return response()->json($requestQuotitation,200);
    }
}
