<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clima e Cidade</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="{{ asset('assets/css/general.css') }}" rel="stylesheet">
    <style>
        #loadingOverlay {
        display: none;
        position: fixed;
        z-index: 9999;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.7);
        }

        .loader {
        border: 8px solid #f3f3f3;
        border-radius: 50%;
        border-top: 8px solid #cb1ede;
        width: 60px;
        height: 60px;
        animation: spin 2s linear infinite;
        position: absolute;
        top: 50%;
        left: 50%;
        margin: -30px 0 0 -30px;
        }

        @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <a href="/" class="voltar-button">Voltar</a>
    <div id="loadingOverlay">
        <div class="loader"></div>
      </div>
      
    <div class="form-container">
        <form class="form" id="cityWeatherForm">
            <div class="form-group">
                <label for="cidade">Nome da Cidade:</label>
                <input type="text" id="cidade" name="cidade">
            </div>
            <div class="form-group">
                <label for="cep">CEP:</label>
                <input type="text" id="cep" name="cep" pattern="[0-9]{8}" title="Digite um CEP válido de 8 dígitos (Somente Números)">
            </div>

            <div class="form-group">
                <label for="cidade">Nome da Cidade 2:</label>
                <input type="text" id="cidade2" name="cidade">
            </div>
            <div class="form-group">
                <label for="cep">CEP 2:</label>
                <input type="text" id="cep2" name="cep" pattern="[0-9]{8}" title="Digite um CEP válido de 8 dígitos (Somente Números)">
            </div>
            <button type="submit" class="form-submit-btn">Consultar</button> 
        </form>
        
        <div class="cardContainerClima" id="weatherData" style="display: none;">
            <div class="cardClima">
                <p class="city"></p>
                <p class="weather"></p>
                <p class="temp"></p>
                <div class="minmaxContainer">
                    <div class="min">
                        <p class="minHeading"></p>
                        <p class="minTemp"></p>
                    </div>
                    <div class="max">
                        <p class="maxHeading"></p>
                        <p class="maxTemp"></p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container" id="cityData" style="display: none">
            <div class="box">
              <span class="title"></span>
              <div>
                <strong id="logradouroComplementoBairro"></strong>
                <p id="cepData"></p>
                <span id="ddd"></span> <span id="ibge"></span>
              </div>
            </div>
        </div>
        <div class="container" id="cityData2" style="display: none; margin-top:350px">
            <div class="box">
              <span class="title"></span>
              <div>
                <strong id="logradouroComplementoBairro2"></strong>
                <p id="cepData2"></p>
                <span id="ddd2"></span> <span id="ibge2"></span>
              </div>
            </div>
        </div>

        <div class="cardContainerClima" id="weatherData2" style="display: none;">
            <div class="cardClima">
                <p class="city" id="city2"></p>
                <p class="weather" id="weather2"></p>
                <p class="temp" id="temp2"></p>
                <div class="minmaxContainer">
                    <div class="min">
                        <p class="minHeading"></p>
                        <p class="minTemp" id="minTemp2"></p>
                    </div>
                    <div class="max">
                        <p class="maxHeading"></p>
                        <p class="maxTemp" id="maxTemp2"></p>
                    </div>
                </div>
            </div>
        </div>
        

    </div>

    <script>
        $(document).ready(function() {
            $('#cityWeatherForm').submit( function(event) {
                event.preventDefault();
                $('#loadingOverlay').show();
                var cidade = $('#cidade').val();
                var cep = $('#cep').val();
                var cidade2 = $('#cidade2').val();
                var cep2 = $('#cep2').val();
               
                if ((!cidade && !cep && cidade2 && cep2) || (cidade && cep && !cidade2 && !cep2) ||  (!cidade && !cep && !cidade2 && !cep2)) {
                    alert("Ambos os campos da mesma localização não podem ser vazios.");
                    return;
                }
                
               setTimeout(function() {
                    $('#loadingOverlay').hide();
                if ((!cidade && cep) && (!cidade2 && cep2)) {
                    getCidadeFromCep(cep).then(function(response) {
                        cidade = response.localidade;
                        getClima(cidade);
                        getCidade(cep);
                    }).catch(function(error) {
                        console.error('Error getting cidade for cep:', cep, error);
                    });
                    getCidadeFromCep(cep2).then(function(response2) {
                        cidade2 = response2.localidade;
                        getClima2(cidade2);
                        getCidade2(cep2);
                    }).catch(function(error) {
                        console.error('Error getting cidade for cep:', cep, error);
                    });
                }else if((cidade && cep) && (!cidade2 && cep2)){
                     getClima(cidade);
                     getCidade(cep);

                     getCidadeFromCep(cep2).then(function(response2) {
                            cidade2 = response2.localidade;
                            getClima2(cidade2);
                            getCidade2(cep2);
                    }).catch(function(error) {
                        console.error('Error getting cidade for cep:', cep, error);
                    });
                }else if((!cidade && cep) && (cidade2 && cep2)){
                    getCidadeFromCep(cep).then(function(response) {
                        cidade = response.localidade;
                        getClima(cidade);
                        getCidade(cep);
                    }).catch(function(error) {
                        console.error('Error getting cidade for cep:', cep, error);
                    });
                     getClima2(cidade2);
                     getCidade2(cep2);
                }else if((cidade && !cep) && (cidade2 && !cep2)){
                    getClima(cidade);
                    getClima2(cidade2);
                }else{
                     getClima(cidade);
                     getClima2(cidade2);
                     getCidade(cep);
                     getCidade2(cep2);
                }

                 function getClima(cidade){

                    $.ajax({
                        type: 'GET',
                        url: '/getClima',
                        data: { cidade: cidade },
                        success: function(weatherResponse) {
                            $('#weatherData .city').text(weatherResponse.location.name);
                            $('#weatherData .weather').text(weatherResponse.current.weather_descriptions[0]);
                            $('#weatherData .temp').text(weatherResponse.current.temperature + "°C");
                            $('#weatherData .minTemp').text("humidity% " + weatherResponse.current.humidity);
                            $('#weatherData .maxTemp').text("precipitação " + weatherResponse.current.precip);
                            $('#weatherData').show();
                            $('.form-container').css('margin-bottom', '300px');
                            $('#weatherData').css('margin-top', '350px');
                        },
                        error: function(xhr, status, error) {
                            var errorMessage = xhr.responseJSON.error || 'An error occurred';
                            $('#weatherData .city').text(errorMessage);
                            $('#weatherData .weather').empty();
                            $('#weatherData').show();
                            $('.form-container').css('margin-bottom', '300px');
                            $('#weatherData').css('margin-top', '350px');
                        }
                    });
                }

                 function getCidade(cep){
                    $.ajax({
                        type: 'GET',
                        url: '/getCityByCep',
                        data: { cep: cep },
                        success: function(cityResponse) {
                            $('#cityData .title').text(cityResponse.localidade + ' - ' + cityResponse.uf);
                            $('#logradouroComplementoBairro').text(cityResponse.logradouro + ' ' + cityResponse.complemento + ' ' + cityResponse.bairro);
                            $('#cepData').text(cityResponse.cep);
                            $('#ddd').text('DDD ' + cityResponse.ddd);
                            $('#ibge').text('IBGE' + cityResponse.ibge);
                            $('#cityData').show();
                            $('.form-container').css('margin-bottom', '300px');

                        },
                        error: function(xhr, status, error) {
                            var errorMessage = xhr.responseJSON.error || 'An error occurred';
                            $('#cityData .title').text(errorMessage);
                            $('#logradouroComplementoBairro').empty();
                            $('#cepData').empty();
                            $('#ddd').empty();
                            $('#ibge').empty();
                            $('.form-container').css('margin-bottom', '300px');
                            $('#cityData').show();
                        }
                    });
                }

                 function getCidade2(cep2){
                    $.ajax({
                        type: 'GET',
                        url: '/getCityByCep',
                        data: { cep: cep2 },
                        success: function(cityResponse) {
                            $('#cityData2 .title').text(cityResponse.localidade + ' - ' + cityResponse.uf);
                            $('#logradouroComplementoBairro2').text(cityResponse.logradouro + ' ' + cityResponse.complemento + ' ' + cityResponse.bairro);
                            $('#cepData2').text(cityResponse.cep);
                            $('#ddd2').text('DDD ' + cityResponse.ddd);
                            $('#ibge2').text('IBGE' + cityResponse.ibge);
                            $('#cityData2').show();
                            $('.form-container').css('margin-bottom', '300px');
                            $('#cityData2').css('margin-top', '650px');
                        },
                        error: function(xhr, status, error) {
                            var errorMessage = xhr.responseJSON.error || 'An error occurred';
                            $('#cityData2 .title').text(errorMessage);
                            $('#logradouroComplementoBairro2').empty();
                            $('#cepData2').empty();
                            $('#ddd2').empty();
                            $('#ibge2').empty();
                            $('#cityData2').show();
                            $('.form-container').css('margin-bottom', '300px');
                            $('#cityData2').css('margin-top', '650px');
                        }
                    });
                }

                 function getClima2(cidade2){
                    $.ajax({
                        type: 'GET',
                        url: '/getClima',
                        data: { cidade: cidade2 },
                        success: function(response) {
                            $('#city2').text(response.location.name);
                            $('#weather2').text(response.current.weather_descriptions[0]);
                            $('#temp2').text(response.current.temperature + "°C");
                            $('#minTemp2').text(response.current.temperature + "°C");
                            $('#maxTemp2').text(response.current.temperature + "°C");
                            $('#weatherData2').show();
                            $('.form-container').css('margin-bottom', '300px');
                            $('#weatherData2').css('margin-top', '650px');
                        },
                        error: function(xhr, status, error) {
                            var errorMessage = xhr.responseJSON.error || 'An error occurred';
                            $('#weatherData2 .city').text(errorMessage);
                            $('#weatherData2 .weather').empty();
                            $('#weatherData2').show();
                            $('.form-container').css('margin-bottom', '300px');
                            $('#weatherData2').css('margin-top', '650px');
                            $('#cityData2').hide();
                        }
                    });
                }

                 function getCidadeFromCep(cep) {
                    return new Promise((resolve, reject) => {
                        $.ajax({
                            type: 'GET',
                            url: '/getCityByCep',
                            data: { cep: cep },
                            success: function(response) {
                                resolve(response);
                            },
                            error: function(xhr, status, error) {
                                console.error("Error getting cidade from cep:", error);
                                reject(error);
                            }
                        });
                    });
                }
            }, 2000);
            });
        });
    </script>
</body>
</html>
