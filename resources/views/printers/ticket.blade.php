<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <style>
        @page {
            size: 80mm auto;
            margin: 0;
        }

        body {
            font-family: 'Arial', monospace;
            font-size: 11px;
            color: #000;
            padding: 4mm;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .small {
            font-size: 10px;
        }

        .logo img {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }

        hr {
            border: none;
            border-top: 1px solid #000;
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 2px 0;
        }

        .qty {
            width: 15mm;
            text-align: center;
        }

        .unit,
        .imp {
            width: 18mm;
            text-align: right;
        }

        .totales {
            margin-top: 8px;
            font-size: 10.5px;
        }

        .totales .line {
            display: flex;
            justify-content: space-between;
            text-align: right;
        }

        .footer {
            text-align: center;
            margin-top: 8px;
            font-size: 10px;
        }
    </style>
</head>

<body>

    <div class="center logo">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents($img)) }}" alt="logo">
    </div>

    <div class="center bold">{{ $empresa['name'] }}</div>
    <div class="center small">
        RFC {{ $empresa['fiscal_rfc'] }}<br>
        {{ $empresa['address'] }}<br>
        Telf: {{ $empresa['phone'] }}
    </div>

    <div class="center bold" style="margin-top:5px;">{{ $empresa['document_type'] == 'document' ? 'Presupuesto' : 'Ticket de pago' }}</div>
    <div class="center">{{ $sale['serie'] }}</div>

    <hr>

    <div class="small">
        <div>F. Emisión: {{ $sale['saledate'] }}</div>
        <div>Cliente: {{ $sale['cliente'] }}</div>
    </div>

    <hr>

    <table>
        <thead>
            <tr class="small">
                <th>DESCRIPCIÓN</th>
                <th class="qty">CANT</th>
                <th class="unit">P.UNIT</th>
                <th class="imp">IMP.</th>
            </tr>
        </thead>
        <tbody>
            @foreach($saleDetails as $item)
            <tr>
                <td>{{ $item['product']['name'] }}</td>
                <td class="qty">{{ number_format($item['quantity'], 0) }}</td>
                <td class="unit">{{ number_format($item['total'], 2) }}</td>
                <td class="imp">{{ number_format($item['total'] * $item['quantity'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totales">
        <div class="line bold text-right"><span>TOTAL:</span><span>$ {{ number_format($sale['total'], 2) }}</span></div>
    </div>

   



    <div class="footer">
        <div>T. Pago: {{ "efectivo" }}</div>
        <div>Vendedor: {{ $sale['user']['name'] }}</div>
        <div class="bold" style="margin-top:4px;">GRACIAS POR SU COMPRA</div>
    </div>

</body>

</html>