<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
</head>
<body>
    <h2><strong>NutriFit</strong> !</h2>
    <p>Recuperar tu correo.</p>
    <p>Para ello simplemente debes hacer click en el siguiente enlace:</p>

    <a href="{{ url('/user/password/' . $token) }}">
        Click para confirmar tu email
    </a>
</body>
</html>
