<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/TC2005B_602_01/IngeniaLab/config/database.php';
$pdo = Database::connect();

$idMaquina = isset($_GET['ID']) ? (int) $_GET['ID'] : 0;

// Preparar la consulta para seleccionar el estado
$stmt = $pdo->prepare("SELECT estado FROM Maquinas WHERE ID = ?");
$stmt->execute([$idMaquina]);
$row = $stmt->fetch();

if ($row) {
    $nuevoEstado = $row["estado"] == 1 ? 0 : 1;

    // Preparar la consulta para actualizar el estado
    $updateStmt = $pdo->prepare("UPDATE Maquinas SET estado = ? WHERE ID = ?");
    if ($updateStmt->execute([$nuevoEstado, $idMaquina])) {
        echo $nuevoEstado;  // Devuelve el nuevo estado para uso en JavaScript
    } else {
        echo "Error updating record: " . implode(", ", $updateStmt->errorInfo());
    }
}

Database::disconnect();
    