<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;

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
        $qtd = $request->input('qtd');
        $created_at = $date->getTimestamp();

        $validator = Validator::make($request->all(), [
            'type' => 'required|string',
            'price' => 'required|numeric',
            'qtd' => 'required|numeric'
        ]);

        if(!$validator->fails()){
            $gas = new Gas();
            $gas->type = $type;
            $gas->price = $price;
            $gas->qtd = $qtd;
            $gas->created_at = $created_at;
            $gas->save();

            return $this->data['result'][] = [
                'id'=>$gas->id,
                'type'=>$gas->type,
                'price'=>$gas->price,
                'qtd'=>$gas->qtd,
                'created_at'=>$gas->created_at
            ];
        }else{
            return $this->data['error'] = $validator->errors()->first();
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
    {   
        $validator = Validator::make($request->all(), [
            'type' => 'string',
            'price' => 'numeric',
            'qtd' => 'numeric'
        ]);

        if(!$validator->fails()){
            $date = new DateTime();
            $updated_at = $date->getTimestamp();
            $gas_data = $request->only(['type','price','qtd']);
            $gas = Gas::find($id);    
    
            if($gas){
                if(isset($gas_data['type'])){
                    $gas->type = $gas_data['type'];
                };
    
                if(isset($gas_data['price'])){
                    $gas->price = $gas_data['price'];
                };
    
                if(isset($gas_data['qtd'])){
                    $gas->qtd = $gas_data['qtd'];
                };

                $gas->updated_at = $updated_at;
                $gas->save();
    
                return $this->data['result'][] = [
                    'id'=>$gas->id,
                    'type'=>$gas->type,
                    'price'=>$gas->price,
                    'qtd'=>$gas->qtd,
                    'updated_at'=>$gas->updated_at
                ];
            } else {
                return $this->data['error'] = 'ID não encontrado';
            }
        } else {
            return $this->data['error'] = $validator->errors()->first();
        }
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
        if($gas) {
            $gas->delete();
        } else {
            return $this->data['error'] = 'ID não encontrado';
        }
    }
// # iniciado depois
    public function sumQtd(Request $request, $id) {
        $gas = Gas::find($id);
        $validator = Validator::make($request->all(), [
            'qtd' => 'required|numeric'
        ]);
        $qtd = $request->only(['id','qtd']);
        //print_r($qtd);
        //print_r($request['id']);

        if(is_null($gas)) {
            return $this->data['error'] = 'ID não encontrado';
        }

        if(!$validator->fails()){
            $gas->qtd = $gas->qtd + $qtd['qtd'];
            $gas->save();
            $data = [
                'id'=>$gas->id,
                'type'=>$gas->type,
                'price'=>$gas->price,
                'qtd'=>$gas->qtd,
                'updated_at'=>$gas->updated_at 
            ];
            return response()->json($data);
        } else {
            return $this->data['error'] = $validator->errors()->first();
        }
    }

    public function subQtd(Request $request, $id) {
        $gas = Gas::find($id);
        $validator = Validator::make($request->all(), [
            'qtd' => 'required|numeric'
        ]);
        $qtd = $request->only(['id','qtd']);
        //print_r($qtd);
        //print_r($request['id']);
        if(is_null($gas)) {
            return $this->data['error'] = 'ID não encontrado';
        }

        if(!$validator->fails()){
            $gas->qtd = $gas->qtd - $qtd['qtd'];
            $gas->save();
            $data = [
                'id'=>$gas->id,
                'type'=>$gas->type,
                'price'=>$gas->price,
                'qtd'=>$gas->qtd,
                'updated_at'=>$gas->updated_at 
            ];
            return response()->json($data);
        } else {
            return $this->data['error'] = $validator->errors()->first();
        }
    }
}
