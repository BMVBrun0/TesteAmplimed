<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Clima;
class ClimaController extends Controller
{
    public function getClima(Request $request)
    {
        $saveData = $request->input('saveData', false);
        $cidadeId = $request->input('cidade_id');
        $temCep = $request->input('temCep');
        $apiKey = "f10fedd97eafdf7b1c23bc38bdfc194f";
        $url = "http://api.weatherstack.com/current?access_key={$apiKey}&query=" . urlencode($request->cidade);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        
        $data = json_decode($response, true);
        
        if (isset($data['current'])) {
            $translations = [
                "Moderate or heavy snow in area with thunder" => "Neve moderada ou forte na área com trovoadas",
                "Patchy light snow in area with thunder" => "Neve fraca na área com trovoadas",
                "Moderate or heavy rain in area with thunder" => "Chuva moderada ou forte na área com trovoadas",
                "Light Rain With Thunderstorm, Patches Of Fog" => "Chuva fraca na área com trovoadas",
                "Moderate or heavy showers of ice pellets" => "Aguaceiros moderados ou fortes de granizo",
                "Light showers of ice pellets" => "Aguaceiros leves de granizo",
                "Moderate or heavy snow showers" => "Aguaceiros de neve moderados ou fortes",
                "Light snow showers" => "Aguaceiros de neve leves",
                "Moderate or heavy sleet showers" => "Aguaceiros de saraiva moderados ou fortes",
                "Light sleet showers" => "Aguaceiros de saraiva leves",
                "Torrential rain shower" => "Chuva torrencial",
                "Moderate or heavy rain shower" => "Chuva moderada ou forte",
                "Light rain shower" => "Chuva fraca",
                "Ice pellets" => "Granizo",
                "Heavy snow" => "Neve forte",
                "Patchy heavy snow" => "Neve forte intermitente",
                "Moderate snow" => "Neve moderada",
                "Patchy moderate snow" => "Neve moderada intermitente",
                "Light snow" => "Neve fraca",
                "Patchy light snow" => "Neve fraca intermitente",
                "Moderate or heavy sleet" => "Saraiva moderada ou forte",
                "Light sleet" => "Saraiva fraca",
                "Moderate or Heavy freezing rain" => "Chuva congelante moderada ou forte",
                "Light freezing rain" => "Chuva congelante leve",
                "Heavy rain" => "Chuva forte",
                "Heavy rain at times" => "Chuva forte em alguns momentos",
                "Moderate rain" => "Chuva moderada",
                "Moderate rain at times" => "Chuva moderada em alguns momentos",
                "Light rain" => "Chuva fraca",
                "Patchy light rain" => "Chuva fraca intermitente",
                "Heavy freezing drizzle" => "Garoa forte congelante",
                "Freezing drizzle" => "Garoa congelante",
                "Light drizzle" => "Garoa leve",
                "Patchy light drizzle" => "Garoa leve intermitente",
                "Freezing fog" => "Nevoeiro congelante",
                "Fog" => "Nevoeiro",
                "Blizzard" => "Tempestade de neve",
                "Blowing snow" => "Neve soprada",
                "Thundery outbreaks in nearby" => "Surtos trovoados próximos",
                "Patchy freezing drizzle nearby" => "Garoa congelante intermitente nas proximidades",
                "Patchy sleet nearby" => "Saraiva intermitente nas proximidades",
                "Patchy snow nearby" => "Neve intermitente nas proximidades",
                "Patchy rain nearby" => "Chuva intermitente nas proximidades",
                "Mist" => "Névoa",
                "Overcast" => "Nublado",
                "Cloudy" => "Nublado",
                "Partly cloudy" => "Parcialmente nublado",
                "Clear" => "Céu limpo",
                "Sunny" => "Ensolarado",
                "Clear/Sunny" => "Céu limpo/Ensolarado",
                "Shower In Vicinity" => "Chuva nas proximidades"
            ];
            
            $translated_descriptions = array_map(function ($desc) use ($translations) {
                return $translations[$desc] ?? $desc;
            }, $data['current']['weather_descriptions']);
            $data['current']['weather_descriptions'] = $translated_descriptions;
            if($saveData){
                $clima = new Clima();
                if($temCep == 1){
                    $clima->cidade_id = 0;
                }else{
                    $clima->cidade_id = $cidadeId;
                }
                $clima->clima_desc = implode(", ", $data['current']['weather_descriptions']);
                $clima->clima_temperatura = $data['current']['temperature'];
                $clima->clima_humidade = $data['current']['humidity'];
                $clima->clima_precipitacao = $data['current']['temperature'];
                $clima->save();
            }
            return response()->json($data);
        } else {
            return response()->json(['error' => 'Não foi possivel trazer o clima para a cidade desejada'], 404);
        }
    }
}


