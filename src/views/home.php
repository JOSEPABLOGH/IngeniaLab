<?php

    session_start();

    if (!isset($_SESSION['idType']) || $_SESSION['idType'] != 3) {
        header("Location: login.php");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="es">

    <head>

        <title>Admin Home</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        
        
        <link rel="stylesheet" href="/TC2005B_602_01/IngeniaLab/public/css/styles.css">
        <link rel="stylesheet" href="/TC2005B_602_01/IngeniaLab/public/css/home.css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

    </head>

    <body>

        <?php include '../common/sideBar.html'; ?>

        <div class="main-content" id="main-content">

            <div class="header">
                <h1>Tablero</h1>
                <div class='button-container'>
                <button onclick='changeStatusAll(1)' class='power-on-button'><i class='fas fa-power-off'></i> Encender Todo</button>
                <button onclick='changeStatusAll(0)' class='power-off-button'><i class='fas fa-power-off'></i> Apagar Todo</button>
                <button class="open-modal-btn add-button" data-modal="addMachineModal">Añadir nueva maquina</button>
                </div>
            </div>

            <div class="search-bar">
                <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Buscar por nombre, numero de serie, estado, etc.">
                <button class="open-modal-btn add-button" data-modal="addMachineTypeModal"><i class="fas fa-plus-square"></i> Añadir maquinaria</button>
                <button type="button" class='add-button' id="toggleViewButton" onclick='toggleView()'> <i class="fas fa-th"></i></button>
            </div>

            <div id="machines-table"></div>

        </div>

        <?php include '../machines/create.php'; ?>
        <?php include '../machines/edit.php'; ?>
        <?php include '../machines/confirm-delete-machine.php'; ?>
        <?php include '../machines/create-machine-type.php'; ?>

        <script src="/TC2005B_602_01/IngeniaLab/public/js/home.js"></script>
        <script src="/TC2005B_602_01/IngeniaLab/public/js/modal.js"></script>


    </body>

</html>
