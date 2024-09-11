<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TC2005B_602_01/IngeniaLab/config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['ID'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $carrera = $_POST['carrera'];

    $pdo = Database::connect();
    $sql = "UPDATE Alumnos SET nombre = ?, correo = ?, carrera = ? WHERE ID = ?";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$nombre, $correo, $carrera, $id])) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "No se pudo actualizar el estudiante."]);
    }

    Database::disconnect();
}
?>
