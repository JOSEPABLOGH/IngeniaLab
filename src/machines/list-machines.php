<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/TC2005B_602_01/IngeniaLab/config/database.php';

try {
    $pdo = Database::connect();
    $sql = 'SELECT * FROM Maquinas';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<table class='user-table' id='user-table'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Nombre Máquina</th>";
    echo "<th>Estado</th>";
    echo "<th>Acción</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    if (count($result) > 0) {
        foreach ($result as $row) {
            $iconStatus = $row['estado'] ? '<i class="far fa-lightbulb"></i>' : '<i class="fas fa-lightbulb"></i>';
            $status = $row['estado'] ? 'Encendido' : 'Apagado';
            $buttonStatus = $row['estado'] ? 'Apagar' : 'Encender';
            $buttonClass = $row['estado'] ? 'power-off-button' : 'power-on-button';

            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
            echo "<td id='statusIcon{$row['ID']}'> $iconStatus $status </td>";
            echo "<td>";
            echo "<div class='button-container'>";
            echo "<button class='$buttonClass' id='boton{$row['ID']}' onclick='changeStatus({$row['ID']})' ><i class='fas fa-power-off'></i> {$buttonStatus}</button>";
            echo "<button class='edit-button' onclick='event.preventDefault(); showDetailsModal({$row['ID']});'><i class='fas fa-info-circle'></i> Detalles</button>";
            echo "<button class='details-button' onclick='event.preventDefault(); editModal({$row['ID']});'><i class='far fa-edit'></i> Editar</button>";
            echo "<button class='delete-button' onclick='openDeleteConfirmation({$row['ID']})'><i class='fas fa-trash'></i> Eliminar</button>";
            echo "</div>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No hay equipos para mostrar.</td></tr>";
    }

    echo "</tbody>";
    echo "</table>";

} catch (PDOException $e) {
    echo "<tr><td colspan='3'>Error al cargar los equipos: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
} finally {
    Database::disconnect();
}
?>


<?php include '../machines/details.php'; ?>