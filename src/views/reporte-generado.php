<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Reporte Generado</title>
  <link rel="stylesheet" href="/TC2005B_602_01/IngeniaLab/public/css/genReporte.css" />
  <link rel="stylesheet" href="/TC2005B_602_01/IngeniaLab/public/css/navBar.css">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</head>

<body>
  
  <?php include '../common/sideBar.html' ?>

  <div class="heading-admin">
    <div style="width: 30%;">
      <p class="header">Reporte Generado</p>
    </div>
</div>

<div class="main-content">

  <section class="container" id="report-content">
    <header>Información del Reporte</header>
    <div class="report-content">
      <h2>Detalles del Usuario</h2>
      <p>Nombre Completo: <?php echo htmlspecialchars($_POST['nombre_completo']); ?></p>
      <p>Matrícula: <?php echo htmlspecialchars($_POST['matricula']); ?></p>
      <p>Correo: <?php echo htmlspecialchars($_POST['correo']); ?></p>

      <?php if ($_POST['include_teachers'] == 'yes'): ?>
          <h2>Información de Profesores</h2>

          <?php
          // Consulta SQL para obtener los datos
          require_once $_SERVER['DOCUMENT_ROOT'].'/TC2005B_602_01/IngeniaLab/config/database.php';
          $pdo = Database::connect();
          $sql = "SELECT r.idMaquina, r.idUsuario, r.tiempo, r.estado, m.nombre AS maquinaNombre 
                  FROM registro_uso_maquinas r
                  JOIN maquinas m ON r.idMaquina = m.ID
                  WHERE r.idUsuario LIKE 'L%'
                  ORDER BY r.idMaquina, r.idUsuario, r.tiempo";

          $result = $pdo->query($sql);
          $data = [];
          if ($result->rowCount() > 0) {
              while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                  $data[] = $row;
              }
          }

          // Procesar los datos en PHP
          $usageData = [];
          $currentUsage = [];
          foreach ($data as $row) {
              $idMaquina = $row['idMaquina'];
              $idUsuario = $row['idUsuario'];
              $tiempo = new DateTime($row['tiempo']);
              $estado = $row['estado'];

              if (!isset($usageData[$idMaquina])) {
                  $usageData[$idMaquina] = [];
              }

              if (!isset($usageData[$idMaquina][$idUsuario])) {
                  $usageData[$idMaquina][$idUsuario] = 0;
              }

              if ($estado == 1) { // Encendido
                  $currentUsage[$idUsuario] = $tiempo;
              } elseif ($estado == 0 && isset($currentUsage[$idUsuario])) { // Apagado
                  $interval = $tiempo->diff($currentUsage[$idUsuario]);
                  $hours = $interval->h + ($interval->days * 24) + ($interval->i / 60);
                  $usageData[$idMaquina][$idUsuario] += $hours;
                  unset($currentUsage[$idUsuario]);
              }
          }
          ?>

          <script>
              const usageData = <?php echo json_encode($usageData); ?>;
          </script>

          <div>
            <?php foreach ($usageData as $idMaquina => $usuarios): ?>
              <h2>Máquina: <?php echo htmlspecialchars($data[array_search($idMaquina, array_column($data, 'idMaquina'))]['maquinaNombre']); ?></h2>
              <canvas id="chart-<?php echo $idMaquina; ?>"></canvas>
              <script>
                const ctx<?php echo $idMaquina; ?> = document.getElementById('chart-<?php echo $idMaquina; ?>').getContext('2d');
                new Chart(ctx<?php echo $idMaquina; ?>, {
                  type: 'bar',
                  data: {
                    labels: <?php echo json_encode(array_keys($usuarios)); ?>,
                    datasets: [{
                      label: 'Horas de Uso',
                      data: <?php echo json_encode(array_values($usuarios)); ?>,
                      backgroundColor: 'rgba(54, 162, 235, 0.2)',
                      borderColor: 'rgba(54, 162, 235, 1)',
                      borderWidth: 1
                    }]
                  },
                  options: {
                    scales: {
                      y: {
                        beginAtZero: true
                      }
                    }
                  }
                });
              </script>
            <?php endforeach; ?>
          </div>

          <table class="user-table">
            <thead>
              <tr>
                <th>Maquina</th>
                <th>Matricula</th>
                <th>Hora de encendido/apagado</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($data as $row): ?>
                <tr>
                  <td><?php echo htmlspecialchars($row['maquinaNombre']); ?></td>
                  <td><?php echo htmlspecialchars($row['idUsuario']); ?></td>
                  <td><?php echo htmlspecialchars($row['tiempo']); ?></td>
                  <td>
                    <?php if ($row['estado'] == 1): ?>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" viewBox="0 0 16 16">
                        <path d="M2 6a6 6 0 1 1 10.174 4.31c-.203.196-.359.4-.453.619l-.762 1.769A.5.5 0 0 1 10.5 13a.5.5 0 0 1 0 1 .5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1 0-1 .5.5 0 0 1 0-1 .5.5 0 0 1 0-1 .5.5 0 0 1-.46-.302l-.761-1.77a2 2 0 0 0-.453-.618A5.98 5.98 0 0 1 2 6m6-5a5 5 0 0 0-3.479 8.592c.263.254.514.564.676.941L5.83 12h4.342l.632-1.467c.162-.377.413-.687.676-.941A5 5 0 0 0 8 1"></path>
                      </svg><span> Encendido</span>
                    <?php else: ?>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" viewBox="0 0 16 16">
                        <path d="M2 6a6 6 0 1 1 10.174 4.31c-.203.196-.359.4-.453.619l-.762 1.769A.5.5 0 0 1 10.5 13a.5.5 0 0 1 0 1 .5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1 0-1 .5.5 0 0 1 0-1 .5.5 0 0 1 0-1 .5.5 0 0 1-.46-.302l-.761-1.77a2 2 0 0 0-.453-.618A5.98 5.98 0 0 1 2 6m6-5a5 5 0 0 0-3.479 8.592c.263.254.514.564.676.941L5.83 12h4.342l.632-1.467c.162-.377.413-.687.676-.941A5 5 0 0 0 8 1"></path>
                      </svg><span> Apagado</span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>

        <?php endif; ?>

      <?php if ($_POST['include_admins'] == 'yes'): ?>
        <h2>Información de Alumnos</h2>
        <?php
          // Consulta SQL para obtener los datos
          require_once $_SERVER['DOCUMENT_ROOT'].'/TC2005B_602_01/IngeniaLab/config/database.php';
          $pdo = Database::connect();
          $sql = "SELECT r.idMaquina, r.idUsuario, r.tiempo, r.estado, m.nombre AS maquinaNombre 
                  FROM registro_uso_maquinas r
                  JOIN maquinas m ON r.idMaquina = m.ID
                  WHERE r.idUsuario LIKE 'A%'
                  ORDER BY r.idMaquina, r.idUsuario, r.tiempo";

          $result = $pdo->query($sql);
          $data = [];
          if ($result->rowCount() > 0) {
              while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                  $data[] = $row;
              }
          }
          ?>
                    <table class="user-table">
            <thead>
              <tr>
                <th>Maquina</th>
                <th>Matricula</th>
                <th>Hora de encendido/apagado</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($data as $row): ?>
                <tr>
                  <td><?php echo htmlspecialchars($row['maquinaNombre']); ?></td>
                  <td><?php echo htmlspecialchars($row['idUsuario']); ?></td>
                  <td><?php echo htmlspecialchars($row['tiempo']); ?></td>
                  <td>
                    <?php if ($row['estado'] == 1): ?>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" viewBox="0 0 16 16">
                        <path d="M2 6a6 6 0 1 1 10.174 4.31c-.203.196-.359.4-.453.619l-.762 1.769A.5.5 0 0 1 10.5 13a.5.5 0 0 1 0 1 .5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1 0-1 .5.5 0 0 1 0-1 .5.5 0 0 1 0-1 .5.5 0 0 1-.46-.302l-.761-1.77a2 2 0 0 0-.453-.618A5.98 5.98 0 0 1 2 6m6-5a5 5 0 0 0-3.479 8.592c.263.254.514.564.676.941L5.83 12h4.342l.632-1.467c.162-.377.413-.687.676-.941A5 5 0 0 0 8 1"></path>
                      </svg><span> Encendido</span>
                    <?php else: ?>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" viewBox="0 0 16 16">
                        <path d="M2 6a6 6 0 1 1 10.174 4.31c-.203.196-.359.4-.453.619l-.762 1.769A.5.5 0 0 1 10.5 13a.5.5 0 0 1 0 1 .5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1 0-1 .5.5 0 0 1 0-1 .5.5 0 0 1 0-1 .5.5 0 0 1-.46-.302l-.761-1.77a2 2 0 0 0-.453-.618A5.98 5.98 0 0 1 2 6m6-5a5 5 0 0 0-3.479 8.592c.263.254.514.564.676.941L5.83 12h4.342l.632-1.467c.162-.377.413-.687.676-.941A5 5 0 0 0 8 1"></path>
                      </svg><span> Apagado</span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
      <?php endif; ?>

      <?php if ($_POST['include_graphs'] == 'yes'): ?>
        <h2>Gráfica de Uso Total de Máquinas</h2>
        <canvas id="usoTotalChart"></canvas>
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/TC2005B_602_01/IngeniaLab/config/database.php';
        $pdo = Database::connect();
        $sql = 'SELECT nombre, tiempoUso FROM Maquinas';
        $result = $pdo->query($sql);
        $maquinas = [];
        $tiempos = [];
        if ($result->rowCount() > 0) {
          foreach ($result as $row) {
            $maquinas[] = $row['nombre'];
            $tiempos[] = $row['tiempoUso'];
          }
        }
        Database::disconnect();
        ?>
        <script>
          const ctx = document.getElementById('usoTotalChart').getContext('2d');
          const usoTotalChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: <?php echo json_encode($maquinas); ?>,
              datasets: [{
                label: 'Tiempo de Uso Total (minutos)',
                data: <?php echo json_encode($tiempos); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
              }]
            },
            options: {
              scales: {
                y: {
                  beginAtZero: true
                }
              }
            }
          });
        </script>
      <?php endif; ?>
    </div>
  </section>
  <button class="btn" id="download-btn"><i class="fa fa-download"></i> Descargar</button>
</div>

<script>
    document.getElementById('download-btn').addEventListener('click', function () {
      const { jsPDF } = window.jspdf;
      const reportContent = document.getElementById('report-content');

      html2canvas(reportContent, { scale: 2 }).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const pdfWidth = canvas.width * 0.264583; 
        const pdfHeight = canvas.height * 0.264583;
        
        const pdf = new jsPDF('p', 'mm', [pdfWidth, pdfHeight]);
        pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
        pdf.save('Reporte IngeniaLab.pdf');
      });
    });
  </script>
</body>

</html>
