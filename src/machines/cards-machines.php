<?php
echo "<div class='machine-grid'>";
    require_once $_SERVER['DOCUMENT_ROOT'].'/TC2005B_602_01/IngeniaLab/config/database.php';
    $pdo = Database::connect();
    $sql = 'SELECT * FROM Maquinas';
    foreach ($pdo->query($sql) as $row) {
        $iconStatus = $row['estado'] ? '<i class="far fa-lightbulb"></i>' : '<i class="fas fa-lightbulb"></i>';
        $status = $row['estado'] ? 'Encendido' : 'Apagado';
        $buttonStatus = $row['estado'] ? 'Apagar' : 'Encender';
        $buttonClass = $row['estado'] ? 'power-off-button' : 'power-on-button';
        $imagePath = "/TC2005B_602_01/IngeniaLab/src/machines/uploads/" . htmlspecialchars($row['imagen']);

        echo "<div class='machine-card'>";
        echo "<h3>" . htmlspecialchars($row['nombre']) . "</h3>";
        echo "<img src='" . $imagePath . "' alt='Imagen de la máquina' class='machine-image'>";
        echo "<div id='statusIcon{$row['ID']}'> $iconStatus $status </div>";
        echo "<div class='card-buttons'>";
            echo "<button class='$buttonClass' id='boton{$row['ID']}' onclick='changeStatus({$row['ID']})'><i class='fas fa-power-off'></i> {$buttonStatus}</button>";
            echo "<button class='edit-button' onclick='event.preventDefault(); showDetailsModal({$row['ID']});'><i class='fas fa-info-circle'></i> Detalles</button>";
            echo "<button class='details-button' onclick='event.preventDefault(); editModal({$row['ID']});'><i class='far fa-edit'></i> Editar</button>";
            echo "<button class='delete-button' onclick='openDeleteConfirmation({$row['ID']})'><i class='fas fa-trash'></i> Eliminar</button>";
        echo "</div>";
        echo "</div>";
    }
    Database::disconnect();

echo "</div>";


?>

    <?php include '../machines/details.php'; ?>