<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TC2005B_602_01/IngeniaLab/config/database.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    if ($id > 0) {
        $pdo = Database::connect();
        $sql = "SELECT * FROM Maquinas WHERE ID = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $machine = $stmt->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();

        if ($machine) {
            echo json_encode([
                'ID' => $machine['ID'],
                'numSerie' => $machine['numSerie'],
                'nombre' => $machine['nombre'],
                'tipoMaquina' => $machine['tipoMaquina']
            ]);
        } else {
            echo json_encode(['error' => 'No se encontraron detalles para esta máquina.']);
        }
    }
}
?>
