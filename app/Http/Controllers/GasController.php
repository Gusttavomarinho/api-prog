<?php

namespace App\Http\Controllers;

use App\Models\gas;
use DateTime;
use Illuminate\Http\Request;

class GasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $data = [
        'error'=>'',
        'result'=>[]
    ];

    public function index()
        
    {
        $gas = Gas::all();

        if($gas){
            foreach($gas as $g){
                $this->data['result'][] = [
                    'id'=>$g->id,
                    'type'=>$g->type,
                    'price'=>$g->price,
                    'created_at'=>$g->created_at,
                    'update_at'=>$g->update_at
                ];
            }
        }

        return $this->data;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   
        $date = new DateTime();
        $type = $request->input('type');
        $price = $request->input('price');
        $created_at = $date->getTimestamp();

        if($type && $price){
            $gas = new Gas();
            $gas->type = $type;
            $gas->price = $price;
            $gas->created_at = $created_at;
            $gas->save();

            return $this->data['result'][] = [
                'id'=>$gas->id,
                'type'=>$gas->type,
                'price'=>$gas->price,
                'created_at'=>$gas->created_at
            ];
        }else{
            return $this->data['error'] = 'Campos não informados';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\gas  $gas
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gas = Gas::find($id);
        if($gas){
            $this->data['result'][] = [
                'id'=>$gas->id,
                'type'=>$gas->type,
                'price'=>$gas->price,
                'created_at'=>$gas->created_at,
                'updated_at'=>$gas->updated_at
            ];
            return $this->data;
        }else{
            return $this->data['error'] = 'ID não encontrado';
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\gas  $gas
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request , $id)
    {   $date = new DateTime();
        $updated_at = $date->getTimestamp();
        $gas_data = $request->only(['type','price']);
        $gas = Gas::find($id);
        if($gas){
            if(isset($gas_data['type'])){
                $gas->type = $gas_data['type'];
            };

            if(isset($gas_data['price'])){
                $gas->price = $gas_data['price'];
            };
            $gas->updated_at = $updated_at;
            $gas->save();

            return $this->data['result'][] = [
                'id'=>$gas->id,
                'type'=>$gas->type,
                'price'=>$gas->price,
                'updated_at'=>$gas->updated_at
            ];


        }else{
            return $this->data['error'] = 'Campos não informados';
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\gas  $gas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, gas $gas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\gas  $gas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $gas = Gas::find($id);
        $gas->delete();
    }
}
