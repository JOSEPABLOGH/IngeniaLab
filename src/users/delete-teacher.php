<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/TC2005B_602_01/IngeniaLab/config/database.php';
$pdo = Database::connect();

$idTeacher = isset($_GET['ID']) ? $_GET['ID'] : null;
error_log("ID recibido: " . $idTeacher); // Agregar log

if ($idTeacher) {
    $sql = "DELETE FROM Usuarios WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$idTeacher])) {
        echo "Profesor eliminado correctamente.";
    } else {
        echo "Error al eliminar profesor: " . implode(", ", $stmt->errorInfo());
    }
} else {
    echo "ID no proporcionado o inválido.";
}

Database::disconnect();

?>
