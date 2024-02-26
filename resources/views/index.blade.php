<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historico</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: rgb(255, 255, 255);
            color: #343a40;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 36px;
            color: #cb1ede;
        }
        form {
            text-align: center;
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 12px;
            border-radius: 25px;
            border: 2px solid #cb1ede;
            margin-right: 10px;
            font-size: 16px;
            outline: none;
        }
        input[type="text"]:focus {
            border-color: #cb1ede;
        }
        button[type="submit"] {
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            background-color: #cb1ede;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
            outline: none;
            transition: background-color 0.3s ease;
        }
        button[type="submit"]:hover {
            background-color: #cb1ede;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #cb1ede;
            color: #fff;
            text-transform: uppercase;
            font-weight: bold;
        }
        tr:nth-child(odd) {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #ff4ebe;
        }
        .voltar-button {
            position: fixed;
            top: 20px;
            left: 20px;
            padding: 10px 20px;
            border: none;
            border-radius: 25px;
            background-color: #cb1ede;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
            outline: none;
            z-index: 1000;
        }
        @media only screen and (max-width: 600px) {
            h1{
                margin-top: 20%
            }
        }

        
    </style>
</head>
<body>
    <a href="/" class="voltar-button">Voltar</a>

    <h1>Historico</h1>

    <form action="{{ route('index') }}" method="GET">
        <input type="text" name="search" placeholder="Filtre por cidade" value="{{ $search }}">
        <button type="submit">Filtrar</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Cidade</th>
                <th>Localização</th>
                <th>CEP</th>
                <th>DDD</th>
                <th>IBGE</th>
                <th>Temperatura</th>
                <th>Humidade</th>
                <th>Precipitação</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cidade_clima as $data)
            <tr>
                <td>{{ $data['cidade_nome'] }}</td>
                <td>{{ $data['cidade_localizacao'] }}</td>
                <td>{{ $data['cidade_cep'] }}</td>
                <td>{{ $data['cidade_ddd'] }}</td>
                <td>{{ $data['cidade_ibge'] }}</td>
                <td>{{ $data['clima_temperatura'] }}</td>
                <td>{{ $data['clima_humidade'] }}</td>
                <td>{{ $data['clima_precipitacao'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
