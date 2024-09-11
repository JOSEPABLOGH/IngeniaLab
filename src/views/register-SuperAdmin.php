<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Sistema de Laboratorios</title>
        <meta name="description" content="Sistema de gestion del material de laboratorio">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/TC2005B_602_01/IngeniaLab/public/css/register.css">
    </head>
    <script>
        function seleccionar(checkbox){
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(function (item) {
                if (item !== checkbox) item.checked = false;
            });
        }
    </script>
    <body>
        <table>
            <tr>
            <td>
              <img src="/TC2005B_602_01/IngeniaLab/public/assets/images/ITESM Logo SF.png" width="100" alt="ITESM Logo">
            </td>
            <td>
              <h1>Laboratorio de Ingenieria</h1>
            </td>
          </tr>
        </table>
        <form action="/TC2005B_602_01/IngeniaLab/src/login/register.php" method="POST">
            <div>
                <table align="center">
                    <tr align="center">
                        <td>
                            <h2>
                                Ingresa la matricula:
                            </h2>
                        </td>
                    </tr>
                    <tr align="center">
                        <td>
                            <input type="text" id="id" name="id" placeholder="Matricula" required>
                        </td>
                    </tr>
                    <tr align="center">
                        <td>
                            <h2>
                                Ingresa el nombre:
                            </h2>
                        </td>
                    </tr>
                    <tr align="center">
                        <td>
                            <input type="text" id="name" name="name" placeholder="Nombre" required>
                        </td>
                    </tr>
                    <tr align="center">
                        <td>
                            <h2>
                                Ingresa el correo:
                            </h2>
                        </td>
                    </tr>
                    <tr align="center">
                        <td>
                            <input type="text" id="email" name="email" placeholder="Correo" required>
                        </td>
                    </tr>
                    <tr align="center">
                        <td>
                            <h2>
                                Ingresa la contraseña:
                            </h2>
                        </td>
                    </tr>
                    <tr align="center">
                        <td>
                            <input type="password" id="password" name="password" placeholder="Contraseña" required>
                        </td>
                    </tr>
                    <tr align="center">
                        <td>
                            <h2>
                                Tipo de usuario:
                            </h2>
                            <label for="superadmin">
                                <input type="checkbox" id="superadmin" name="usuario" value="superadmin" onclick="seleccionar(this)">
                                Super Administrador
                            </label><br>
                            <label for="adminiastrador">
                                <input type="checkbox" id="administrador" name="usuario" value="administrador" onclick="seleccionar(this)">
                                Administrador
                            </label><br>
                            <label for="maestro">
                                <input type="checkbox" id="maestro" name="usuario" value="maestro" onclick="seleccionar(this)">
                                Maestro
                            </label><br>
                        </td>
                    </tr>
                </table>
                <table align="center">
                    <tr align="center">
                        <td>
                            <button type="submit" style="padding: 10px 20px; font-size: 16px" margin-top="30px">
                                Agregar
                             </button>
                        </td>
                    </tr>
                </table>
            </div>
        </form>
    </body>
</html>