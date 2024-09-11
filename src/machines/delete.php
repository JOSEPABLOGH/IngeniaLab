<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/TC2005B_602_01/IngeniaLab/config/database.php';
    $pdo = Database::connect();

    $idMaquina = isset($_GET['ID']) ? (int) $_GET['ID'] : 0;

    $sql = "DELETE FROM Maquinas WHERE ID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idMaquina]);

    Database::disconnect();
