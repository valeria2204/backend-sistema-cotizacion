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

    public function index($id)
    {
        $limiteAmount = LimiteAmount::where('administrative_units_id',$id)->get();
        return response()->json(['Limite_Amounts'=>$limiteAmount],200);
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
       
        $input = $request->all();//where('administrative_units_id',$id)->get();; 
        $limiteAmount = LimiteAmount::create($input); 
        return response()->json(['message'=>""], $this-> successStatus); 
    
    }

    public function updateLimiteAmount(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [ 
            'monto' => 'required', 
            'dateStamp' => 'required', 
            'steps' => 'required', 
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
       
        $input = $request->where('administrative_units_id',$id)->get();
        $limiteAmount = LimiteAmount::create($input); 
        return response()->json(['message'=>""], $this-> successStatus); 
    
    }
    // muestra el ultimo registro de los montos limites
    public function sendCurrentData($id)
    {
        $currentLimiteAmount = LimiteAmount::select('monto','steps')->where('administrative_units_id',$id)->latest()->take(1)->get();
        return response()->json(['current_limit_amount'=>$currentLimiteAmount],200);
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
