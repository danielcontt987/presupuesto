<!DOCTYPE html>
<html>
<head>
    <title>QR del trabajador</title>
</head>
<body>
    <h2>QR del trabajador: {{ $numberWork }}</h2>

    {!! QrCode::size(200)->generate($numberWork) !!}
</body>
</html>
