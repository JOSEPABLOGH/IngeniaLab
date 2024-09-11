<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/TC2005B_602_01/IngeniaLab/config/database.php';

// Obtener conexión a la base de datos
$pdo = Database::connect();

// Ruta para guardar eventos en la base de datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);

    $motivo_uso = $data['motivo'];
    $time_from = $data['time_from'];
    $time_to = $data['time_to'];
    $day = $data['day'];
    $month = $data['month'];
    $year = $data['year'];

    // Obtener el idUsuario de la sesión actual y el id de la máquina seleccionada
    $idUsuario = $_SESSION['idUsuario'] ?? null;  
    $maquina = $_SESSION['machine_id'] ?? null; 

    // Construir las fechas de inicio y final
    $fechaInicio = sprintf("%04d-%02d-%02d %s:00", $year, $month, $day, $time_from); // Fecha y hora de inicio del evento
    $fechaFinal = sprintf("%04d-%02d-%02d %s:00", $year, $month, $day, $time_to);   // Fecha y hora de fin del evento

    try {
        // Preparar la sentencia SQL
        $sql = "INSERT INTO Reservas_maquina (idUsuarios, fechaInicio, fechaFinal, maquina, motivo_uso)
                VALUES (?, ?, ?, ?, ?)";

        // Preparar la sentencia
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idUsuario, $fechaInicio, $fechaFinal, $maquina, $motivo_uso]);

        echo "Evento guardado correctamente";
    } catch (PDOException $e) {
        echo "Error al guardar evento: " . $e->getMessage();
    }
}

// Ruta para obtener eventos de la base de datos
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {
        $sql = "SELECT * FROM Reservas_maquina";
        $stmt = $pdo->query($sql);
        $eventsArr = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $event = array(
                'day' => (int) substr($row['fechaInicio'], 8, 2),
                'month' => (int) substr($row['fechaInicio'], 5, 2),
                'year' => (int) substr($row['fechaInicio'], 0, 4),
                'events' => array(
                    array(
                        'motivo' => $row['motivo_uso'],
                        'time_from' => substr($row['fechaInicio'], 11, 5),
                        'time_to' => substr($row['fechaFinal'], 11, 5)
                    )
                )
            );
            $eventsArr[] = $event;
        }

        echo json_encode($eventsArr);
    } catch (PDOException $e) {
        echo "Error al obtener eventos: " . $e->getMessage();
    }
}

$pdo = null;
?>
