<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 650px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 10px;
            padding: 40px 30px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.12);
            text-align: center;
            border-top: 6px solid #c62828;
        }
        .logo {
            width: 130px;
            margin-bottom: 20px;
        }
        .title {
            font-size: 28px;
            font-weight: 700;
            color: #c62828;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .subtitle {
            font-size: 17px;
            color: #555;
            margin-bottom: 25px;
            line-height: 1.6;
        }
        .highlight {
            color: #c62828;
            font-weight: bold;
        }
        .message-box {
            background: #ffebee;
            padding: 18px 25px;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            color: #c62828;
            margin: 25px 0;
            box-shadow: inset 0 2px 6px rgba(0,0,0,0.05);
        }
        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 14px 28px;
            background: #c62828;
            color: #fff !important;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s ease;
        }
        .button:hover {
            background: #a81f1f;
        }
        .footer {
            font-size: 14px;
            color: #777;
            margin-top: 35px;
            line-height: 1.6;
        }
        .footer strong {
            color: #c62828;
        }
        .footer-img {
            margin-top: 20px;
            width: 160px;
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Logo -->
        <img src="{{ $message->embed(public_path('img/LOGOGRANDE.png')) }}" alt="Logo" class="logo">

        <!-- Título -->
        <h1 class="title">Postulación No Seleccionada</h1>

        <!-- Subtítulo -->
        <p class="subtitle">
            Estimado/a <span class="highlight">{{ $nombreUsuario }}</span>, <br><br>
            La empresa <span class="highlight">{{ $nombreEmpresa }}</span> 
            ha finalizado el proceso de selección y, en esta ocasión, tu postulación 
            para la oferta <span class="highlight">“{{ $nombreOferta }}”</span> no ha sido aceptada.
        </p>

        <!-- Mensaje destacado -->
        <div class="message-box">
            🙏 Agradecemos tu interés y esfuerzo. <br> ¡No te desanimes, más oportunidades te esperan!
        </div>

        <!-- Botón -->
        <a href="http://vinculacionconlasociedad.utelvt.edu.ec/b_e" class="button">Explorar Otras Ofertas</a>

        <!-- Footer -->
        <p class="footer">
            La UTLVTE promueve constantemente nuevas oportunidades de empleo para sus estudiantes. <br>
            Te invitamos a seguir postulando en otras ofertas que se ajusten a tu perfil. <br><br>
            Atentamente,<br>
            <strong>BOLSA DE EMPLEO UTLVTE</strong><br>
            <img src="{{ $message->embed(public_path('img/footer.png')) }}" alt="Footer" class="footer-img">
        </p>

        <!-- Imagen Footer -->
    </div>
</body>
</html>
