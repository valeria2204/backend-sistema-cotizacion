<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RequestQuotitation; 
use App\Report;
use Validator;

class ReportController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //metodo with recupera un modelo que carga tambien con la informacion de las tablas que estan
        //relacionadas
        $report = Report::with('request_quotitations')->get();
        return response()->json(['reports'=>$report],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'dateReport' => 'required',
            //nombre de quien realiza el informe
            'administrative_username' => 'required', 
            'description' => 'required',
            'request_quotitations_id' => 'required',

        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $input = $request->all();
        $report = Report::create($input);
        return response()->json(['message'=> "Envio exitoso"], $this-> successStatus);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //devuelve el informe de una determinada solicitud
        $report = Report::where('request_quotitations_id',$id)->get();
        return response()->json($report , $this-> successStatus);

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
