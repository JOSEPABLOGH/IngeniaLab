<!DOCTYPE html>
<?php
session_start();
if (isset($_POST['idUsuario'])) {
    $_SESSION['idUsuario'] = $_POST['idUsuario'];  
}


?>

<html>
<head>

    <meta charset="utf-8">
    <title>Admin Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../public/css/styles.css">
    <link rel="stylesheet" href="../../public/css/home.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="/TC2005B_602_01/IngeniaLab/public/css/navBar.css" />
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

</head>

<body>

    <?php //include '../common/sideBar.html'; ?>
    

    <div class="main-content">
    <div id="sidebar" class="sidebar">

    <button id="toggleButton" class="toggle-button">&#10095;</button>

        <ul class="sidebar-nav">
            <li class="nav-item">
                <a href="../views/apartar.php" class="nav-link">
                    <i class="fas fa-home"></i>
                    <span class="link-text">Inicio</span>
                </a>
                
            </li>
        
            <li class="nav-item">
                <a href="/TC2005B_602_01/IngeniaLab/src/common/logout.php" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="link-text">Cerrar Sesión</span>
                </a>
            </li>
        </ul>

    </div>
        <div class="header">
            <h1>Apartar Equipos</h1>
        </div>

        <div class="search-bar">

            <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Buscar por nombre, correo, etc.">


        </div>

        <script>
            function searchTable() {
                var input, filter, table, tr, td, i, j, txtValue, visible;
                input = document.getElementById("searchInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("user-table");
                tr = table.getElementsByTagName("tr");
                var tbody = table.querySelector("tbody");
                var noResultFound = true;

                var noResultsRow = document.querySelector(".no-results");
                if (noResultsRow) {
                    noResultsRow.remove();
                }

                for (i = 1; i < tr.length; i++) {
                    tr[i].style.display = "none";
                    td = tr[i].getElementsByTagName("td");
                    visible = false;
                    for (j = 0; j < td.length; j++) {
                        if (td[j]) {
                            txtValue = td[j].textContent || td[j].innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                visible = true;
                                break;
                            }
                        }
                    }
                    if (visible) {
                        tr[i].style.display = "";
                        noResultFound = false;
                    }
                }

                if (noResultFound) {
                    var newRow = document.createElement("tr");
                    newRow.className = "no-results";
                    newRow.innerHTML = "<td colspan='4'>No se encontraron resultados</td>";
                    tbody.appendChild(newRow);
                }
            }

        </script>



        <table class="user-table">
            <thead>
                <tr>
                    <th>Nombre Máquina</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once $_SERVER['DOCUMENT_ROOT'].'/TC2005B_602_01/IngeniaLab/config/database.php';
                $pdo = Database::connect();
                $sql = 'SELECT * FROM Maquinas';
                $result = $pdo->query($sql);
                if ($result->rowCount() > 0) {
                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                        if ($row['estado'] == 1) {
                            echo '<td> <i class="fas fa-lightbulb"></i> Encendido</td>';
                        } else if ($row['estado'] == 0) {
                            echo '<td> <i class="far fa-lightbulb"></i> Apagado</td>';
                        }
                        echo "<td>";
                        echo "<div class='button-container'>";
                        echo "<form method='POST' action='calendar.php'>";
                        echo "<button type='submit' class='reserve-button' data-id='" . ($row['ID']) . "'><i class='fas fa-calendar-alt'></i> Apartar</button>";
                        echo "<input type='hidden' name='machine_id' value='" . htmlspecialchars($row['ID']) . "'>";
                        echo "</form>";
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No hay equipos para mostrar.</td></tr>";
                }
                Database::disconnect();
                ?>
            </tbody>
        </table>

        <!-- Tabla de Mesas -->

        <table class="user-table">
            <thead>
                <tr>
                    <th>Nombre Mesa</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $pdo = Database::connect();
                $sql = 'SELECT * FROM Mesas';
                $result = $pdo->query($sql);
                if ($result->rowCount() > 0) {
                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
                        if ($row['estado'] == 1) {
                            echo '<td> <i class="fas fa-lightbulb"></i> Encendido</td>';
                        } else if ($row['estado'] == 0) {
                            echo '<td> <i class="far fa-lightbulb"></i> Apagado</td>';
                        }
                        echo "<td>";
                        echo "<div class='button-container'>";
                        echo "<form method='POST' action='calendar.php'>";
                        echo "<button type='submit' class='reserve-button' data-id='" . ($row['ID']) . "'><i class='fas fa-calendar-alt'></i> Apartar</button>";
                        echo "<input type='hidden' name='mesas_id' value='" . htmlspecialchars($row['ID']) . "'>";
                        echo "</form>";
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No hay mesas para mostrar.</td></tr>";
                }
                Database::disconnect();
                ?>
            </tbody>
        </table>
    </div>

    <script src="../../public/js/modal.js"></script>

</body>
</html>