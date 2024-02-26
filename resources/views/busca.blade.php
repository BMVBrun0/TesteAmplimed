<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clima e Cidade</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="{{ asset('assets/css/general.css') }}" rel="stylesheet">
    <style>
    @media only screen and (max-width: 600px) {
        .container {
            color: white;
            font-family: sans-serif;
            position: absolute;
            left:30%;
            margin-top:950px !important;
        }
    }
    </style>
</head>
<body>
    <a href="/" class="voltar-button">Voltar</a>
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
            <button type="submit" class="form-submit-btn">Consultar e Salvar</button>
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
    </div>

    <script>
        $(document).ready(function() {
            $('#cityWeatherForm').submit(function(event) {
                event.preventDefault();
                var cidade = $('#cidade').val();
                var cep = $('#cep').val();

                if(!cidade && !cep){
                    alert("Ambos os campos da localização não podem ser vazios.");
                    return;
                }else if(!cidade && cep){
                    getCidadeWithCEP(cep, true)
                }else if(cidade && !cep){
                    getClima(cidade, true, 1);
                }else{
                    getCidadeWithCEP(cep, true)
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
                function getClima(cidade, saveData, temCep){
                    $.ajax({
                        type: 'GET',
                        url: '/getClima',
                        data: { cidade: cidade, saveData: saveData, temCep: temCep },
                        success: function(weatherResponse) {
                            $('#weatherData .city').text(weatherResponse.location.name);
                            $('#weatherData .weather').text(weatherResponse.current.weather_descriptions[0]);
                            $('#weatherData .temp').text(weatherResponse.current.temperature + "°C");
                            $('#weatherData .minTemp').text("humidade % " + weatherResponse.current.humidity);
                            $('#weatherData .maxTemp').text("precipitação " + weatherResponse.current.precip);
                            $('#weatherData').show();
                            $('.form-container').css('margin-bottom', '300px');
                            $('#weatherData').css('margin-top', '300px');
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

                function getClimaWithCEP(cidade, cidadeId, saveData) {
                    $.ajax({
                        type: 'GET',
                        url: '/getClima',
                        data: { cidade: cidade, cidade_id: cidadeId, saveData: saveData },
                        success: function(weatherResponse) {
                            $('#weatherData .city').text(weatherResponse.location.name);
                            $('#weatherData .weather').text(weatherResponse.current.weather_descriptions[0]);
                            $('#weatherData .temp').text(weatherResponse.current.temperature + "°C");
                            $('#weatherData .minTemp').text("humidade % " + weatherResponse.current.humidity);
                            $('#weatherData .maxTemp').text("precipitação " + weatherResponse.current.precip);
                            $('#weatherData').show();
                            $('.form-container').css('margin-bottom', '300px');
                            $('#weatherData').css('margin-top', '300px');
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

                function getCidadeWithCEP(cep, saveData) {
                    $.ajax({
                        type: 'GET',
                        url: '/getCityByCep',
                        data: { cep: cep, saveData: saveData },
                        success: function(response) {
                            if (saveData) {
                                var cityResponse = response.data;
                                $('#cityData .title').text(cityResponse.localidade + ' - ' + cityResponse.uf);
                                $('#logradouroComplementoBairro').text(cityResponse.logradouro + ' ' + cityResponse.complemento + ' ' + cityResponse.bairro);
                                $('#cepData').text(cityResponse.cep);
                                $('#ddd').text('DDD ' + cityResponse.ddd);
                                $('#ibge').text('IBGE' + cityResponse.ibge);
                                $('#cityData').show();
                                $('.form-container').css('margin-bottom', '300px');

                                var cidadeId = response.cidade_id;
                                getClimaWithCEP(cityResponse.localidade, cidadeId, true);
                            } else {
                                $('#cityData .title').text(response.localidade + ' - ' + response.uf);
                                $('#logradouroComplementoBairro').text(response.logradouro + ' ' + response.complemento + ' ' + response.bairro);
                                $('#cepData').text(response.cep);
                                $('#ddd').text('DDD ' + response.ddd);
                                $('#ibge').text('IBGE' + response.ibge);
                                $('#cityData').show();
                                $('.form-container').css('margin-bottom', '300px');
                            }
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

            });
        });
    </script>
</body>
</html>
