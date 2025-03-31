<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar Identidad - KaaxClub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #222750; /* Azul oscuro */
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .form-container {
            color: white;
            padding: 2rem;
        }
        .form-control {
            background-color: transparent;
            border: 1px solid rgba(255, 255, 255, 0.5);
            color: white;
            margin-bottom: 1rem;
        }
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-color: white;
            box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.25);
        }
        .btn-validar {
            background-color: white;
            color: #222750;
            border: none;
            padding: 0.5rem 2rem;
            font-weight: 500;
            width: 100%;
        }
        .btn-validar:hover {
            background-color: #e0e0e0;
            color: #222750;
        }
        /* Para cambiar el color del texto del input date cuando está seleccionado */
        input[type="date"] {
            color-scheme: dark;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://unpkg.com/rfc-facil"></script>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4 mt-4">
                <div class="form-container">
                    <div class="text-center mb-4">
                        <img class="logo-dark logo-img logo-img-lg" style="width: 150px;" src="{{ asset('images/logokaax.png') }}" alt="logo-dark">
                        <hr>
                        <p class="text-white-50 small">
                            Estamos validando tu información.
                            <br>
                            Te enviaremos un mensaje  de WhatsApp en unos segundos.
                        </p>
                        <div class="d-grid">
                            <a href="/" class="btn btn-validar">Salir</a>
                        </div>
                    </div>

                    
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto">Éxito</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/manychat.js') }}"></script>
</body>
</html> 