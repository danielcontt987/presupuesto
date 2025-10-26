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
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents($logo)) }}" alt="logo">
    </div>

    <div class="center bold">{{ $empresa['nombre'] }}</div>
    <div class="center small">
        RUC {{ $empresa['ruc'] }}<br>
        {{ $empresa['direccion'] }}<br>
        Telf: {{ $empresa['telefono'] }}
    </div>

    <div class="center bold" style="margin-top:5px;">Boleta de Venta Electrónica</div>
    <div class="center">{{ $boleta['serie'] }}</div>

    <hr>

    <div class="small">
        <div>F. Emisión: {{ $boleta['fecha'] }}</div>
        <div>Cliente: {{ $boleta['cliente'] }}</div>
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
            @foreach($items as $item)
            <tr>
                <td>{{ $item['descripcion'] }}</td>
                <td class="qty">{{ number_format($item['cantidad'], 0) }}</td>
                <td class="unit">{{ number_format($item['precio'], 2) }}</td>
                <td class="imp">{{ number_format($item['importe'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totales">
        <div class="line"><span>OP GRAVADAS:</span><span>S/. {{ number_format($totales['op_gravadas'], 2) }}</span></div>
        <div class="line"><span>IGV 18%:</span><span>S/. {{ number_format($totales['igv'], 2) }}</span></div>
        <div class="line bold"><span>TOTAL:</span><span>S/. {{ number_format($totales['total'], 2) }}</span></div>
    </div>

    <div style="margin-top:6px; font-size:10px;">
        SON: {{ $totales['total_letras'] }}
    </div>

    <div class="center" style="margin-top:8px;">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents($qr)) }}" alt="QR" width="70" height="70">
    </div>

    <div class="footer">
        <div>T. Pago: {{ $pago }}</div>
        <div>Vendedor: {{ $vendedor }}</div>
        <div class="bold" style="margin-top:4px;">GRACIAS POR SU COMPRA</div>
    </div>

</body>

</html>