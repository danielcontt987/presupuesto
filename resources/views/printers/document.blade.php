<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ticket de Venta</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 14px;
        }

        .ticket {
            max-width: 300px;
            margin: 0 auto;
        }

        .center {
            text-align: center;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        table {
            width: 100%;
        }

        td {
            padding: 2px 0;
        }

        .total {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="ticket">
        <div class="center">
            <h3>{{ $empresa }}</h3>
            <p>{{ $direccion }}</p>
            <p>{{ $telefono }}</p>
        </div>

        <div class="line"></div>

        <p><strong>Ticket #:</strong> {{ $ticket_id }}</p>
        <p><strong>Fecha:</strong> {{ $fecha }}</p>

        <div class="line"></div>

        <table>
            @foreach ($productos as $producto)
            <tr>
                <td>{{ $producto['cantidad'] }} x {{ $producto['nombre'] }}</td>
                <td style="text-align: right;">${{ number_format($producto['precio'], 2) }}</td>
            </tr>
            @endforeach
        </table>

        <div class="line"></div>

        <table>
            <tr>
                <td class="total">TOTAL:</td>
                <td class="total" style="text-align: right;">${{ number_format($total, 2) }}</td>
            </tr>
        </table>

        <div class="line"></div>

        <div class="center">
            <p>¡Gracias por su compra!</p>
        </div>
    </div>
</body>

</html>