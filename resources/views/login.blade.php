<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('/img/fondo.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Poppins', sans-serif;
        }

        .login-card {
            max-width: 900px;
            width: 100%;
            background: linear-gradient(180deg, #0d274a 56%, #A7AAA6 100%);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .login-left {            
            color: white;
            padding: 3rem 2rem;
        }

        .login-right {
            padding: 3rem 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-right img {
            max-width: 80%;
            height: auto;
        }

        .form-control {
            border-radius: 10px;
        }

        .btn-custom {
            background-color: #153052;
            color: white;
            border-radius: 10px;
            font-weight: 500;
            transition: background 0.3s;
        }

        .btn-custom:hover {
            background-color: #0b5ed7;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #aaa;
        }

        .divider:not(:empty)::before {
            margin-right: .5em;
        }

        .divider:not(:empty)::after {
            margin-left: .5em;
        }

        .btn-google,
        .btn-github {
            border-radius: 10px;
            font-weight: 500;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
        }

        .btn-google img,
        .btn-github img {
            width: 22px;
            margin-right: 10px;
        }

        /* 🌐 Responsivo */
        @media (max-width: 768px) {
            .login-card {
                flex-direction: column;
                max-width: 90%;
            }
            .login-left {
                padding: 2rem 1.5rem;
                border-radius: 20px 20px 0 0;
            }
            .login-right {
                padding: 2rem 1rem;
                border-radius: 0 0 20px 20px;
            }
            .login-right img {
                max-width: 60%;
            }
        }
    </style>
</head>
<body>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="login-card d-flex flex-column flex-md-row shadow-lg">

        <!-- LADO IZQUIERDO -->
        <div class="login-left col-md-6 d-flex flex-column justify-content-center">
            <h2 class="fw-bold mb-4 text-center">Iniciar Sesión</h2>

            <!-- Mostrar errores -->
            @if ($errors->any())
                <div class="alert alert-danger py-2">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Formulario de login manual -->
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Correo</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Ingresar usuario" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Ingresar contraseña" required>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-custom">Entrar</button>
                </div>
            </form>

            <div class="divider text-white">o</div>

            <!-- Botones sociales -->
            <a href="{{ url('/auth/google') }}" class="btn btn-google d-flex align-items-center justify-content-center mb-2">
                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/google/google-original.svg" alt="Google">
                Continuar con Google
            </a>

            <a href="{{ url('/auth/github') }}" class="btn btn-github d-flex align-items-center justify-content-center">
                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/github/github-original.svg" alt="Github">
                Continuar con GitHub
            </a>
        </div>

        <!-- LADO DERECHO -->
        <div class="login-right col-md-6">
            <img src="/img/logo.png" alt="Logo TECSELIMA">
        </div>
    </div>
</div>

</body>
</html>
