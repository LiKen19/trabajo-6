<!doctype html>
<html lang="es">
<head>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('/img/fondo.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .login-card {
            display: flex;
            flex-direction: row;
            max-width: 950px;
            width: 100%;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            background: linear-gradient(180deg, #153052 60%, #A7AAA6 100%);
        }

        /* --- LADO IZQUIERDO --- */
        .login-left {
            color: white;
            padding: 3rem 2.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-left h2 {
            font-size: 2rem;
            text-align: center;
            margin-bottom: 1.5rem;
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

        /* --- BOTONES SOCIALES --- */
        .btn-google,
        .btn-github {
            border-radius: 10px;
            font-weight: 500;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            padding: 0.6rem;
        }

        .btn-google img,
        .btn-github img {
            width: 22px;
            margin-right: 10px;
        }

        /* --- LADO DERECHO --- */
        .login-right {
            flex: 1;
            padding: 3rem 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #ffffff10;
        }

        .login-right img {
            max-width: 85%;
            height: auto;
            filter: drop-shadow(0 0 10px rgba(255,255,255,0.3));
        }

        /* --- RESPONSIVO --- */
        @media (max-width: 992px) {
            .login-left {
                padding: 2.5rem 2rem;
            }
        }

        @media (max-width: 768px) {
            body {
                background-attachment: scroll;
            }

            .vh-100 {
                height: auto !important;
                min-height: 100vh;
                padding: 2rem 0;
            }

            .login-card {
                flex-direction: column;
                max-width: 90%;
            }

            .login-left, .login-right {
                width: 100%;
                padding: 2rem 1.5rem;
            }

            .login-left {
                border-radius: 20px 20px 0 0;
            }

            .login-right {
                border-radius: 0 0 20px 20px;
                background: rgba(255, 255, 255, 0.1);
            }

            .login-right img {
                max-width: 60%;
            }

            .login-left h2 {
                font-size: 1.8rem;
                margin-top: 0;
            }
        }

        @media (max-width: 480px) {
            .login-left {
                padding: 1.8rem 1rem;
            }

            .btn-google,
            .btn-github {
                font-size: 0.9rem;
                padding: 0.5rem;
            }

            .login-right img {
                max-width: 70%;
            }
        }
    </style>
</head>
<body>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="login-card shadow-lg">

        <!-- LADO IZQUIERDO -->
        <div class="login-left">
            <h2 class="fw-bold">Iniciar Sesión</h2>

            @if ($errors->any())
                <div class="alert alert-danger py-2 mt-2">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="mt-3">
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
        <div class="login-right">
            <img src="/img/logo.png" alt="Logo TECSELIMA">
        </div>

    </div>
</div>

</body>
</html>
