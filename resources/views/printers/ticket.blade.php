<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        .text {
            font-size: 12px;
            font-family: Arial, sans-serif;
        }

        .img-position {
            margin-top: 20px;
            margin-left: 15px;
        }

        .title {
            margin-top: -110px;
            margin-left: 400px;
        }

        .h1 {
            font-size: 20px;
            font-weight: bold;
            font-family: Arial, Helvetica, sans-serif
        }

        .p {
            font-size: 14px;
            font-family: Arial, Helvetica, sans-serif
        }

        .h1-not-bold {
            font-size: 16px;
            font-family: Arial, Helvetica, sans-serif
        }


        /* Estilo general del cuerpo */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }

        /* Estilos de la tabla UI */
        .ui-table {
            margin-top: 500px;
            width: 90%;
            margin: 20 auto;
            border-collapse: collapse;
            background-color: #dbdbdb;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .ui-table th,
        .ui-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        /* Estilo de los encabezados */
        .ui-table th {
            background-color: #00bcd5;
            color: white;
            font-size: 16px;
        }

        .ui-table thead {
            border-radius: 8px;
        }

        /* Estilo de las filas al pasar el mouse */
        .ui-table tr:hover {
            background-color: #f5f5f5;
        }

        /* Estilo de las celdas en columnas alternas */
        .ui-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Espaciado de la tabla */
        .ui-table {
            margin: 0 auto;
        }

        /* Estilo de la cabecera de la página */
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            
        }
    </style>
</head>
<header class="text">
    <img src="{{ $img }}" alt="Sin imagen" srcset="" width="160px" height="120px" class="img-position">
</header>

<body>
    <section class="title" style="margin-bottom: 50px;">
        <span class="h1">Presupuesto</span>
        <p class="h1-not-bold">Cliente: <span class="p"><b>Jose Daniel Contreras Perez</b></span></p>
        <p class="h1-not-bold">Fecha: <span class="p"><b>{{ $date }}</b></span></p>
        <p class="h1-not-bold">Usuario: <span class="p"><b>{{ $user }}</b></span></p>
        <p class="h1-not-bold">Folio: <span class="p"><b>{{ $folio }}</b></span></p>
    </section>
    <section>
        <table class="ui-table">
            <thead>
                <tr>
                    <th>Concepto</th>
                    <th>Cantidad / Medida</th>
                    <th>Precio unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($saleDetails as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->total, 2) }}</td>
                        <td>${{ number_format($item->total * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <td>Total</td>
                    <td>$ {{number_format($sale->total, 2)}}</td>
                </tr>
            </tbody>
        </table>
    </section>
    <footer style="position: fixed; bottom: 0; width: 100%; text-align: center;">
        <p class="text">Gracias por su preferencia</p>
    </footer>
    <script type="text/php">
        if (isset($pdf)) {
            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
            $size = 10;
            $pdf->page_text(270, 800, "Pág. {PAGE_NUM} de {PAGE_COUNT}", $font, $size, array(0,0,0,0.5));
        }

    </script>
</body>

</html>
