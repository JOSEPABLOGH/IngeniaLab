<?php

    session_start();

    if (!isset($_SESSION['idType']) || $_SESSION['idType'] != 3) {
        header("Location: login.php");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Responsive Forms for Report</title>
  <link rel="stylesheet" href="/TC2005B_602_01/IngeniaLab/public/css/genReporte.css" />
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&display=swap" rel="stylesheet">
</head>


<body>

      
<?php include '../common/sideBar.html' ?>

  <section class="container">
    <header>Generar Reporte</header>
    <form action="reporte-generado.php" method="POST" class="form">
      <div class="input-box">
        <label>Nombre Completo</label>
        <input type="text" name="nombre_completo" placeholder="Ingresar nombre" required />
      </div>
      <div class="input-box">
        <label>Matrícula</label>
        <input type="text" name="matricula" placeholder="Ingresar matrícula" required />
      </div>
      <div class="input-box">
        <label>Correo</label>
        <input type="text" name="correo" placeholder="Ingresar correo" required />
      </div>
      <div>
        <h3>Incluír uso de profesores</h3>
        <div class="gender-option">
          <div class="gender"></div>
          <input type="radio" id="check-teach-yes" name="include_teachers" value="yes" checked />
          <label for="check-teach-yes">Si</label>
        </div>
        <div class="gender-option">
          <div class="gender"></div>
          <input type="radio" id="check-teach-no" name="include_teachers" value="no" />
          <label for="check-teach-no">No</label>
        </div>
      </div>
      <div>
        <h3>Incluír uso de administradores</h3>
        <div class="gender-option">
          <div class="gender"></div>
          <input type="radio" id="check-admin-yes" name="include_admins" value="yes" checked />
          <label for="check-admin-yes">Si</label>
        </div>
        <div class="gender-option">
          <div class="gender"></div>
          <input type="radio" id="check-admin-no" name="include_admins" value="no" />
          <label for="check-admin-no">No</label>
        </div>
      </div>
      <div>
        <h3>Incluír gráficas de uso</h3>
        <div class="gender-option">
          <div class="gender"></div>
          <input type="radio" id="check-graph-yes" name="include_graphs" value="yes" checked />
          <label for="check-graph-yes">Si</label>
        </div>
        <div class="gender-option">
          <div class="gender"></div>
          <input type="radio" id="check-graph-no" name="include_graphs" value="no" />
          <label for="check-graph-no">No</label>
        </div>
      </div>
      <div class="button-container">
        <button type="submit">Generar Reporte</button>
      </div>
    </form>
  </section>
</body>
</html>