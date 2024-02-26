<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use App\Models\Cidade;
use App\Models\Clima;

class CidadeClimaController extends Controller
{
    public function index(Request $request)
    {
        $cidade_clima = [];
        $search = $request->input('search');
        
        $cidades = Cidade::take(20)->get();
        
        if ($search) {
            $cidades = Cidade::where('cidade_nome', 'like', "%{$search}%")->get();
        }
        
        Log::info(json_encode($cidades));
        
        foreach ($cidades as $cidade) {
            $climas = Clima::where('cidade_id', $cidade->id)->get();
            Log::info(json_encode($climas));
            foreach ($climas as $clima) {
                $cidade_clima[] = [
                    'cidade_nome' => $cidade->cidade_nome,
                    'cidade_localizacao' => $cidade->cidade_localizacao,
                    'cidade_cep' => $cidade->cidade_cep,
                    'cidade_ddd' => $cidade->cidade_ddd,
                    'cidade_ibge' => $cidade->cidade_ibge,
                    'clima_temperatura' => $clima->clima_temperatura,
                    'clima_humidade' => $clima->clima_humidade,
                    'clima_precipitacao' => $clima->clima_precipitacao,
                ];
            }
        }

        Log::info(json_encode($cidade_clima));
        return view('index', compact('cidade_clima', 'search'));
    }
}
