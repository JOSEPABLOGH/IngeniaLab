<?php 

session_start();
require_once '../../config/database.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['username'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];

    if($password1 == $password2){
        $hashed_password = password_hash($password2, PASSWORD_DEFAULT);

        $conn = Database::connect();
        try {
            $query = $conn->prepare("UPDATE Usuarios SET clave = :hashed_password WHERE correo = :username");
            $query->bindParam(':hashed_password', $hashed_password);
            $query->bindParam(':username', $username);
            $query->execute();

            header('Location: /TC2005B_602_01/IngeniaLab/src/views/home.php');
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        } finally{
            Database::disconnect();
        }
    } else {
        echo "Passwords do not match.";
}
}

?>
