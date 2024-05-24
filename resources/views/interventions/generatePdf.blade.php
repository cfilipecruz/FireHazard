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
    Relatório da Empresa
</div>
<div class="container">
    <h2>Relatório de Intervenção</h2>
    <table style="  margin-top: 30px;">
        <tbody>
        <tr>
            <td>ID</td>
            <td>{{ $intervention->id }}</td>
        </tr>
        <tr>
            <td>Data de Criação</td>
            <td>{{ $intervention->created_at ? date('d/m/Y', strtotime($intervention->created_at)) : 'N/A' }}
                ás
                {{ $intervention->created_at ? date('H:i:s', strtotime($intervention->created_at)) : 'N/A' }}</td>
        </tr>
        <tr>
            <td>Local</td>
            <td>{{ $intervention->place == 1 ? 'Loja' : 'Cliente' }}</td>
        </tr>
        <tr>
            <td>ID do Carro</td>
            <td>
                @if(($intervention->car_id))
                    {{ ($intervention->car)->brand }} - {{ ($intervention->car)->licensePlate }}
                @else
                    Avaliação realizada em loja
                @endif
            </td>
        </tr>

        <tr>
            <td>Técnico</td>
            <td>{{ $intervention->user_id }} - {{ ($intervention->user)->name }}</td>
        </tr>
        <tr>
            <td>Número Interno</td>
            <td>{{ $intervention->internalNumber }}</td>
        </tr>
        <tr>
            <td>Número de Série</td>
            <td>{{ $intervention->serialNumber }}</td>
        </tr>
        <tr>
            <td>Tipo de Fluido</td>
            <td>{{ ($intervention->fluidType)->name}}</td>
        </tr>
        <tr>
            <td>Capacidade em (kg)</td>
            <td>{{ $intervention->capacity }}</td>
        </tr>
        <tr>
            <td>Pressão</td>
            <td>{{ $intervention->pressure == 1 ? 'Sim' : 'Não' }}</td>
        </tr>
        <tr>
            <td>Nome da Fábrica</td>
            <td>{{ $intervention->factoryName }}</td>
        </tr>
        <tr>
            <td>Data da Fábrica</td>
            <td>{{ $intervention->factoryDate ? date('d/m/Y', strtotime($intervention->factoryDate)) : 'N/A' }}</td>
        </tr>
        <tr>
            <td>Marca CE</td>
            <td>{{ $intervention->ceMarking == 1 ? 'Sim' : 'Não' }}</td>
        </tr>
        <tr>
            <td>Localização</td>
            <td>{{ $intervention->localization }}</td>
        </tr>
        <tr>
            <td>Última Carga</td>
            <td>{{ $intervention->lastCharged ? date('d/m/Y', strtotime($intervention->lastCharged)) : 'N/A' }}</td>
        </tr>
        <tr>
            <td>Último Teste Hidráulico</td>
            <td>{{ $intervention->lastHydraulicTest ? date('d/m/Y', strtotime($intervention->lastHydraulicTest)) : 'N/A' }}</td>
        </tr>
        <tr>
            <td>Manutenção MNT</td>
            <td>{{ $intervention->maintenanceMNT == 1 ? 'Sim' : 'Não' }}</td>
        </tr>
        <tr>
            <td>Carga MNTAD</td>
            <td>{{ $intervention->chargeMNTAD == 1 ? 'Sim' : 'Não' }}</td>
        </tr>
        <tr>
            <td>Tipo</td>
            <td>{{ $intervention->type == 1 ? 'C' : 'S' }}</td>
        </tr>
        <tr>
            <td>Peso CO2</td>
            <td>{{ $intervention->co2Weight }}</td>
        </tr>
        <tr>
            <td>Prova Hidráulica</td>
            <td>{{ $intervention->hydraulicProve == 1 ? 'Sim' : 'Não' }}</td>
        </tr>
        <tr>
            <td>Selo de Segurança</td>
            <td>{{ $intervention->securityStamp == 1 ? 'Sim' : 'Não' }}</td>
        </tr>
        <tr>
            <td>O-Ring</td>
            <td>{{ $intervention->oRing == 1 ? 'Sim' : 'Não' }}</td>
        </tr>
        <tr>
            <td>PEG</td>
            <td>{{ $intervention->peg == 1 ? 'Sim' : 'Não' }}</td>
        </tr>
        <tr>
            <td>Manômetro</td>
            <td>{{ $intervention->manometer == 1 ? 'Sim' : 'Não' }}</td>
        </tr>
        <tr>
            <td>Difusor</td>
            <td>{{ $intervention->diffuser == 1 ? 'Sim' : 'Não' }}</td>
        </tr>
        <tr>
            <td>Base de plástico</td>
            <td>{{ $intervention->plasticBase == 1 ? 'Sim' : 'Não' }}</td>
        </tr>
        <tr>
            <td>Etiqueta</td>
            <td>{{ $intervention->label == 1 ? 'Sim' : 'Não' }}</td>
        </tr>
        <tr>
            <td>Sparkles</td>
            <td>{{ $intervention->sparkles == 1 ? 'Sim' : 'Não' }}</td>
        </tr>
        <tr>
            <td>Aprovado</td>
            <td>{{ $intervention->approved == 1 ? 'Sim' : 'Não' }}</td>
        </tr>
        <tr>
            <td>Novo</td>
            <td>{{ $intervention->new == 1 ? 'Sim' : 'Não' }}</td>
        </tr>
        <tr>
            <td>Fora de Serviço</td>
            <td>{{ $intervention->outofservice == 1 ? 'Sim' : 'Não' }}</td>
        </tr>
        <tr>
            <td>Motivo de Rejeição</td>
            <td>{{ $intervention->rejectedMotive }}</td>
        </tr>
        <tr>
            <td>ID da Fatura</td>
            <td>{{ $intervention->invoice_id }}</td>
        </tr>
        </tbody>
    </table>
    <h2>Informações Legais</h2>
    <div class="legal-info">
        <p>De acordo com as leis em vigor em Portugal:</p>
        <p>A informação contida neste relatório é confidencial e destinada apenas ao uso da empresa indicada. Se você
            não é o destinatário, fique informado que qualquer divulgação, cópia ou distribuição deste documento é
            estritamente proibida. Se você recebeu este documento por engano, por favor, avise o remetente imediatamente
            e destrua todas as cópias.</p>
        <p>A informação contida neste relatório é fornecida sem garantia de qualquer tipo, expressa ou implícita,
            incluindo, mas não limitado a, as garantias implícitas de comercialização, adequação a uma finalidade
            específica ou não infração.</p>
    </div>
</div>
</body>
</html>
