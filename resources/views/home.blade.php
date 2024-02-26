<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="{{ asset('assets/css/general.css') }}" rel="stylesheet">
</head>
<body>
    <div class="form-container">
        <form class="form">
            <div class="form-group">
                <div id="cardCidade" class="card">Comparar Clima</div>
            </div>
            <div class="form-group">
                <div id="cardClima" class="card">Consultar Clima</div>
            </div>
            <div class="form-group">
                <div id="cardGeral" class="card">Consultar Histórico</div>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('#cardCidade').click(function() {
                window.location.href = "/comparar";
            });
            
            $('#cardClima').click(function() {
                window.location.href = "/busca";
            });

            $('#cardGeral').click(function() {
                window.location.href = "/index";
            });

        });
    </script>
</body>
</html>
