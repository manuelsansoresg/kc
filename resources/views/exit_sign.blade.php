<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Salida</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="container text-center">
        <div class="row">
            <div class="col-12 mb-3">
                <img src="{{ asset('images/logo-dark.png') }}" alt="Logo">
            </div>
            <div class="col-12 mb-3">
                @if (isset($type) && $type == 1)
                    <h5>Contrato firmado correctamente</h5>
                    @else
                    <h5>Contrato no firmado</h5>
                @endif
            </div>
            <div class="col-12">
                <a href="#" class="btn btn-outline-primary">Salir</a>
            </div>
        </div>
    </div>
</body>
</html>