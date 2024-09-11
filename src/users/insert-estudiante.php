<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/TC2005B_602_01/IngeniaLab/config/database.php';

    $response = array();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $pdo = Database::connect();

        $ID = $_POST['matricula'];
        $name = $_POST['name'];
        $correo = $_POST['mail'];
        $carrera = $_POST['carrera'];

        if (!empty($name) && !empty($ID) && !empty($correo) && !empty($carrera)) {

            $pdo = Database::connect();

            $sql_check = "SELECT COUNT(*) FROM Alumnos WHERE ID = ? OR correo = ?";
            $stmt_check = $pdo->prepare($sql_check);
            $stmt_check->execute([$ID, $correo]);
            $user_exists = $stmt_check->fetchColumn();

            if ($user_exists > 0) {
                $response['success'] = false;
                $response['message'] = "El usuario con esa matrícula o correo ya está registrado.";
            } else {
                
                $sql_insert = "INSERT INTO Alumnos (ID, nombre, correo, carrera) VALUES (?, ?, ?, ?)";
                $stmt_insert = $pdo->prepare($sql_insert);

                if ($stmt_insert->execute([$ID, $name, $correo, $carrera])) {
                    $response['success'] = true;
                    $response['message'] = "Usuario registrado exitosamente.";
                } else {
                    $response['success'] = false;
                    $response['message'] = "Error al registrar el usuario.";
                }
                
            }

            Database::disconnect();
        } else {
            $response['success'] = false;
            $response['message'] = "Todos los campos son obligatorios.";
        }
    }
    echo json_encode($response);