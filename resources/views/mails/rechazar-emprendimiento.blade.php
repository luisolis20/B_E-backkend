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
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
            text-align: center;
            border-top: 6px solid #c62828; /* Rojo para denotar rechazo */
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
            box-shadow: inset 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 14px 28px;
            background: #2e7d32;
            color: #fff !important;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s ease;
        }

        .button:hover {
            background: #256828;
        }

        .footer {
            font-size: 14px;
            color: #777;
            margin-top: 35px;
            line-height: 1.6;
        }

        .footer strong {
            color: #2e7d32;
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
        <h1 class="title">Emprendimiento No Aprobado</h1>
        
        <!-- Subtítulo / Descripción -->
        <p class="subtitle">
            Estimado/a <span class="highlight">{{ $nombreUsuario }}</span>, <br><br>
            Tras la revisión de tu emprendimiento denominado:<br><br>
            <span class="highlight">“{{ $nombreEmprendimiento }}”</span><br><br>
            Lamentamos informarte que en esta ocasión <strong>no ha sido aprobado</strong> para su publicación en la plataforma de la <strong>Bolsa de Empleo UTLVTE</strong>.
        </p>
        
        <!-- Mensaje destacado -->
        <div class="message-box">
            ❌ Te invitamos a revisar los requisitos y volver a intentarlo en el futuro.
        </div>
        
        <!-- Botón de acción -->
        <a href="http://vinculacionconlasociedad.utelvt.edu.ec/b_e" class="button">Ver requisitos</a>
        
        <!-- Footer -->
        <p class="footer">
            La UTLVTE apoya e impulsa los proyectos y emprendimientos de sus estudiantes, docentes y comunidad.<br>
            Si deseas más información sobre los criterios de aprobación, por favor contáctanos.<br><br>
            <em>Nota: No respondas a este correo, ya que ha sido generado automáticamente.</em><br><br>
            Atentamente,<br>
            <strong>BOLSA DE EMPLEO UTLVTE</strong><br>
            <img src="{{ $message->embed(public_path('img/footer.png')) }}" alt="Footer" class="footer-img">
        </p>
    </div>
</body>

</html>
