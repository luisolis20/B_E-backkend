<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
        }
        .logo {
            width: 120px;
            margin-bottom: 20px;
        }
        .title {
            font-size: 26px;
            font-weight: bold;
            color: #2e7d32; /* Verde */
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .subtitle {
            font-size: 18px;
            color: #555555;
            margin-bottom: 25px;
        }
        .code-box {
            display: inline-block;
            padding: 15px 30px;
            background: #e8f5e9;
            color: #2e7d32;
            font-size: 24px;
            font-weight: bold;
            border-radius: 6px;
            letter-spacing: 2px;
            margin: 20px 0;
        }
        .footer {
            font-size: 14px;
            color: #777777;
            margin-top: 30px;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Logo -->
        <img src="{{ $message->embed(public_path('img/LOGOGRANDE.png')) }}" alt="Logo" class="logo">


        <!-- Título -->
        <h1 class="title">Verificación de Correo</h1>

        <!-- Subtítulo / Descripción -->
        <p class="subtitle">
            ¡Felicidades! Estás a un paso de completar tu registro.<br>
            Para garantizar la seguridad de tu cuenta, utiliza el siguiente código de verificación:
        </p>

        <!-- Código -->
        <div class="code-box">
            {{ $codigoVerificacion }}
        </div>

        <!-- Footer -->
        <p class="footer">
            Si no solicitaste este correo, por favor ignóralo.<br>
            Este código es válido solo por unos minutos para proteger tu información.<br><br>
            Atentamente,<br>
            <strong>BOLSA-EMPLEO UTLVTE</strong>
        </p>
    </div>
</body>
</html>
