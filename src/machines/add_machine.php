<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/TC2005B_602_01/IngeniaLab/config/database.php';

$numSerie = $_POST['numSerie'];
$nombre = $_POST['nombre'];
$tipoMaquina = $_POST['tipo_maquina'];
$imagen = $_FILES['imagen']['name'];

// Ruta donde se guardarán las imágenes subidas
$target_dir = $_SERVER['DOCUMENT_ROOT']."/TC2005B_602_01/IngeniaLab/src/machines/uploads/";
$target_file = $target_dir . basename($_FILES["imagen"]["name"]);

// Mover la imagen subida a la carpeta 'uploads'
if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
    
    $pdo = Database::connect();
    $sql = "INSERT INTO Maquinas (numSerie, nombre, tipoMaquina, fechaRegistro, tiempoUso, estado, funcionamiento, imagen)
            VALUES (:numSerie, :nombre, :tipoMaquina, CURDATE(), 0, 1, 1, :imagen)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':numSerie', $numSerie);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':tipoMaquina', $tipoMaquina);
    $stmt->bindParam(':imagen', $imagen);

    if ($stmt->execute()) {
        $response = array("success" => true, "message" => "Máquina agregada exitosamente");
    } else {
        $response = array("success" => false, "message" => "Error al agregar la máquina");
    }
    Database::disconnect();
} else {
    $response = array("success" => false, "message" => "Error al subir la imagen");
}

echo json_encode($response);
?>
