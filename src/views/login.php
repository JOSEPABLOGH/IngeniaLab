<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistema de Laboratorios</title>
    <meta name="description" content="Sistema de gestión del material de laboratorio">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/login.css">
    
</head>
<body>
    <div class="container">
        <div class="bienvenido">
            <img src="../../public/assets/images/ITESM Logo SF.png" alt="ITESM Logo">
            <h1>Bienvenido</h1>
            <p>Laboratorio de Ingeniería</p>
        </div>
        <div class="login">
            <h2>Log in</h2>
            <form action="/TC2005B_602_01/IngeniaLab/src/login/login_process.php" method="POST">
                <input type="text" id="username" name="username" placeholder="Usuario" required>
                <input type="password" id="password" name="password" placeholder="Contraseña" required>
                <button type="submit">Log in</button>
                <a href="../../src/views/verify-email.html">¿Olvidó su contraseña?</a>
            </form>
        </div>
    </div>
</body>
</html>