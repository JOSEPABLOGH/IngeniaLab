<?php

    echo "<table class='user-table' id='user-table'>";
    echo "<thead>";
        echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Nombre</th>";
            echo "<th>Correo Electronico</th>";
            echo "<th>Acciones</th>";
        echo "</tr>";
    echo "</thead>";

    echo "<tbody>";

    require_once $_SERVER['DOCUMENT_ROOT'] . '/TC2005B_602_01/IngeniaLab/config/database.php';
    $pdo = Database::connect();
    $sql = 'SELECT id, nombre, correo FROM Usuarios WHERE idType = 2';
    $result = $pdo->query($sql);
    if ($result->rowCount() > 0) {
        foreach ($result as $row) {
            echo "<tr>";

                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                echo "<td>" . htmlspecialchars($row['correo']) . "</td>";
                echo "<td>";

                    echo "<div class='button-container'>";

                    echo "<button type='button' class='edit-button' onclick='openEditTeacherModal(" . json_encode($row) . ");'>Editar</button>";
                        echo "<button class='delete-button' onclick='openDeleteTeacherConfirmation(" . json_encode($row['id']) . ")'><i class='fas fa-trash'></i> Eliminar</button>";
                    
                    echo "</div>";
                    
                echo "</td>";

            echo "</tr>";
            
        }
    } else {
        echo "<tr><td colspan='4'>No hay maestros para mostrar.</td></tr>";
    }
    Database::disconnect();

    echo "</tbody>";
    echo "</table>"

?>
