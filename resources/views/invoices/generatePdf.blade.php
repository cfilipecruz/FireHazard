<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Relatório da Empresa</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }

        .header {
            background-color: #3c3c3c;
            color: #fff;
            padding: 20px;
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 4px;
        }

        .container {
            margin: 50px auto;
            width: 80%;
        }

        h2 {
            margin: 30px 0;
            font-size: 24px;
            font-weight: bold;
            color: #3c3c3c;
            text-transform: uppercase;
            letter-spacing: 2px;
            border-bottom: 2px solid #3c3c3c;
            padding-bottom: 10px;
        }

        table {

            margin-bottom: 30px;
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border-radius: 10px;
        }

        th, td {
            text-align: left;
            padding: 20px;
            border-bottom: 1px solid #eee;
            color: #3c3c3c;
        }

        th {
            background-color: #f9f9f9;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-top: 1px solid #eee;
        }

        .legal-info {
            font-size: 14px;
            color: #777;
            margin-top: 30px;
            text-align: justify;
            line-height: 1.6;
        }

        .legal-info p {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="header">
    Fatura
</div>
<div class="container">
    <h2>Invoice Details</h2>
    <table>
        <tr>
            <th>Data</th>
            <td>{{ $invoiceData['date'] }}</td>
        </tr>
        <tr>
            <th>Nome do Cliente</th>
            <td>{{ $invoiceData['client']['name'] }}</td>
        </tr>
        <tr>
            <th>Numero VAT</th>
            <td>{{ $invoiceData['client']['vatNumber'] }}</td>
        </tr>
        <tr>
            <th>Pais</th>
            <td>{{ $invoiceData['client']['country'] }}</td>
        </tr>
        <tr>
            <th>Desconto</th>
            <td>{{ $invoiceData['discount'] }}</td>
        </tr>
        <tr>
            <th>Observações</th>
            <td>{{ $invoiceData['observations'] }}</td>
        </tr>
        <tr>
            <th>Preço</th>
            <td>{{ $invoiceData['number'] }}</td>
        </tr>
        <tr>
            <th>Data de Expiração</th>
            <td>{{ $invoiceData['expiration'] }}</td>
        </tr>
        <!-- Add more fields as necessary -->
    </table>
    <!-- Additional content for the invoice -->
</div>
</body>
</html>
