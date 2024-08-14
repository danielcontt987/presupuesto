<!-- resources/views/ticket.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
        .ticket {
            width: 80mm; /* Ajusta al tamaño de tu ticket */
            padding: 10mm;
            font-family: Arial, sans-serif;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <h1>Nombre del Comercio</h1>
        <p>Item: {{ $item }}</p>
        <p>Price: ${{ $price }}</p>
        <p class="no-print">[Impresión Directa]</p>
        <script>
            window.onload = function() {
                window.print();
                setTimeout(function() {
                    window.close();
                }, 1000);
            }
        </script>
    </div>
</body>
</html>
