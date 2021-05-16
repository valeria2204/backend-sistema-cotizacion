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
        $limiteAmount = LimiteAmount::all();
        return response()->json(['limit_amout'=> $limiteAmount],$this-> successStatus);
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
        return response()->json(['message'=>$limiteAmount],200); 
    
    }

    public function updateLimiteAmount(Request $request)
    {
        //falta terminar
        $validator = Validator::make($request->all(), [ 
            'monto' => 'required', 
            'dateStamp' => 'required', 
            'steps' => 'required',
            'administrative_units_id' => 'required',
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        //En el caso de cuando se registra un monto por primera vez
        $montosEncontrados = LimiteAmount::where('administrative_units_id',$request['administrative_units_id'])->get();
        $valor = count($montosEncontrados);
        //si una unidad administrativa no ha registrado ningun monto
        if($valor == 0){
            //se registra el primer monto
            $input = $request->only('monto', 'dateStamp','steps','administrative_units_id');  
            LimiteAmount::create($input);
            return response()->json(['message'=>""], 200); 
        }
        //$input = $request->where('administrative_units_id',$id)->get();
        //En el caso de que ya hay al menos un monto registrado
        $input = $request->all();
        $administrativeUnit_id = $request->administrative_units_id;
        $ultimoMontoRegistrado = $montosEncontrados[$valor-1];
        //sacar fecha de registro del nuevo monto y ponerla como fecha fin del ultimo monto registrado

        //$ultimoMontoRegistrado = LimiteAmount::select('monto','dateStamp')->where('administrative_units_id',$administrativeUnit_id)->latest()->take(1)->get();
        //dd($ultimoMontoRegistrado);
        // $request['dateEnd'] = 
        $limiteAmount = LimiteAmount::create($input); 
        //dd($limiteAmount);
        return response()->json(['message'=>$limiteAmount], $this-> successStatus); 
    
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
    public function show($id)
    {
        $limiteAmount = LimiteAmount::where('administrative_units_id',$id)->get();
        return response()->json(['Limite_Amounts'=>$limiteAmount],200);
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
