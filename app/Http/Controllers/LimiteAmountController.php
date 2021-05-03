<?php

namespace App\Http\Controllers;

use App\LimiteAmount;
use Illuminate\Http\Request;
use Validator;

class LimiteAmountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $successStatus = 200;

    public function index()
    {
        $LimiteAmount = LimiteAmount::all();
        return response()->json(['Limite_Amount'=>$LimiteAmount],200);
    }

// registra montos limites
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'monto' => 'required', 
            'dateStamp' => 'required', 
            'steps' => 'required', 
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
       
        $input = $request->all(); 
        $limiteAmount = LimiteAmount::create($input); 
        return response()->json(['message'=>""], $this-> successStatus); 
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LimiteAmount  $limiteAmount
     * @return \Illuminate\Http\Response
     */
    public function show(LimiteAmount $limiteAmount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LimiteAmount  $limiteAmount
     * @return \Illuminate\Http\Response
     */
    public function edit(LimiteAmount $limiteAmount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LimiteAmount  $limiteAmount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LimiteAmount $limiteAmount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LimiteAmount  $limiteAmount
     * @return \Illuminate\Http\Response
     */
    public function destroy(LimiteAmount $limiteAmount)
    {
        //
    }
}
