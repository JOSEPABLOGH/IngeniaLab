<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/TC2005B_602_01/IngeniaLab/config/database.php';

// Obtener conexión a la base de datos
$pdo = Database::connect();

// Verificar si la solicitud es de tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos de la solicitud
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Verificar si se recibieron los datos necesarios
    if (isset($data['day'], $data['month'], $data['year'], $data['motivo'])) {
        $day = intval($data['day']);
        $month = intval($data['month']);
        $year = intval($data['year']);
        $motivo = $data['motivo'];

        // Preparar la sentencia SQL
        $sql = "DELETE FROM Reservas_maquina WHERE DAY(fechaInicio) = ? AND MONTH(fechaInicio) = ? AND YEAR(fechaInicio) = ? AND motivo_uso = ?";

        try {
            // Preparar la sentencia
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$day, $month, $year, $motivo]);

            echo "Evento eliminado correctamente";
        } catch (PDOException $e) {
            echo "Error al eliminar evento: " . $e->getMessage();
        }
    } else {
        echo "Faltan datos necesarios para eliminar el evento.";
    }
}

// Cerrar la conexión
$pdo = null;
?>
