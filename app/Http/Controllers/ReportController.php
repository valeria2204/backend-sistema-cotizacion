<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RequestQuotitation; 
use App\Report;

class ReportController extends Controller
{
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
    public function store(Request $request,$id)
    {
        $input = $request->only('description','dateReport','request_quotitations_id');
        $stateQuotitation = $request->only('status');
        $report = Report::create($input);
        $quotitation = RequestQuotitation::find($id);
        $quotitation->update($stateQuotitation->all());
        return response()->json(['success' => $report], $this-> successStatus);
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
