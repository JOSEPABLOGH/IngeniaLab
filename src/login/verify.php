<?php
session_start();
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['username'];

    $conn = Database::connect();

    try {
        $query = $conn->prepare("SELECT * FROM Usuarios WHERE correo = :username");
        $query->bindParam(':username', $username);
        $query->execute();

        if ($query->rowCount() > 0) {
            header('Location: /TC2005B_602_01/IngeniaLab/src/views/change-pass.html');
            exit();
        } else {
            header('Location: /TC2005B_602_01/IngeniaLab/src/login/verify.php?error=Usernotfound');
            exit();
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        exit();
    } finally {
        Database::disconnect();
    }

    header('Location: /TC2005B_602_01/IngeniaLab/src/login/verify.php?error=InvalidAccess');
    exit();
}