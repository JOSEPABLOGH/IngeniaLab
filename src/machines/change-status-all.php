<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/TC2005B_602_01/IngeniaLab/config/database.php';
    $pdo = Database::connect();

    // Obtener el nuevo estado de la URL, asegurando que es un entero
    $newStatus = isset($_GET['newStatus']) ? (int)$_GET['newStatus'] : 0;

    // Preparar la sentencia SQL para actualizar el estado
    $stmt = $pdo->prepare("UPDATE Maquinas SET estado = ?");

    // Ejecutar la sentencia con el nuevo estado proporcionado
    if ($stmt->execute([$newStatus])) {
        echo "El estado de todas las máquinas ha sido actualizado a " . $newStatus;
    } else {
        echo "Error al actualizar el estado de las máquinas.";
    }

    // Desconectar de la base de datos
    Database::disconnect();
    
?>
