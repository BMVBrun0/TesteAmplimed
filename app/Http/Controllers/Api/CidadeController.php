<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\Cidade;
class CidadeController extends Controller
{

    function getCityByCep(Request $request)
    {
        $saveData = $request->input('saveData', false);
        $url = "https://viacep.com.br/ws/{$request->cep}/json/";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        $data = json_decode($response, true);
        
        if (isset($data['localidade'])) {
            if($saveData){
                $cidade = new Cidade();
                $cidade->cidade_nome = $data['localidade'];
                $cidade->cidade_localizacao = $data['logradouro'] . ' ' . $data['complemento'] . ' ' . $data['bairro'];
                $cidade->cidade_cep = $data['cep'];
                $cidade->cidade_ddd = $data['ddd'];
                $cidade->cidade_ibge = $data['ibge'];
                $cidade->save();

                $cidadeId = $cidade->id;
                return response()->json([
                    'data' => $data,
                    'cidade_id' => $cidadeId
                ]);
            }else{
                return response()->json($data);
            }
        } else {
            return response()->json(['error' => 'Não foi possivel encontrar a cidade'], 404);
        }
    }
    
}
