<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/TC2005B_602_01/IngeniaLab/config/database.php';
$pdo = Database::connect();

$idStudent = isset($_GET['ID']) ? $_GET['ID'] : null;
error_log("ID recibido: " . $idStudent); // Agregar log

if ($idStudent) {
    $sql = "DELETE FROM Alumnos WHERE ID = ?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$idStudent])) {
        echo "Usuario eliminado correctamente.";
    } else {
        echo "Error al eliminar usuario: " . implode(", ", $stmt->errorInfo());
    }
} else {
    echo "ID no proporcionado o inválido.";
}

Database::disconnect();

?>
