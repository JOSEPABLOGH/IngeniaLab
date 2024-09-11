<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/TC2005B_602_01/IngeniaLab/config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';

    if (empty($nombre)) {
        echo json_encode(array("success" => false, "message" => "El nombre no puede estar vacío"));
        exit();
    }

    try {
        $pdo = Database::connect();
        $sql = "INSERT INTO Tipos_maquina (tipo) VALUES (:nombre)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);

        if ($stmt->execute()) {
            $response = array("success" => true, "message" => "Máquina agregada exitosamente");
        } else {
            $errorInfo = $stmt->errorInfo();
            $response = array("success" => false, "message" => "Error al agregar la máquina: " . $errorInfo[2]);
        }
        Database::disconnect();
    } catch (PDOException $e) {
        $response = array("success" => false, "message" => "Error en la conexión a la base de datos: " . $e->getMessage());
    }
} else {
    $response = array("success" => false, "message" => "Solicitud no válida");
}

echo json_encode($response);
?>
