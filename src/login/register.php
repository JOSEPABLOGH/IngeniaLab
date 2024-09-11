<?php 

session_start();
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $usuario = $_POST['usuario'];

    if(isset($usuario)){
        $usuarioSeleccionado = $usuario;

        if ($usuarioSeleccionado === 'administrador') {
            insertaradmin($id, $name, $email, $password);
        } elseif ($usuarioSeleccionado === 'maestro') {
            insertarmaestro($id, $name, $email, $password);
        } elseif ($usuarioSeleccionado === 'superadmin') {
            insertarsuperadmin($id, $name, $email, $password);
        }else {
            echo "Usuario no válido seleccionado.";
        }
    } else {
        echo "No se seleccionó ningún usuario.";
    }
}

function insertaradmin($id, $name, $email, $password){
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $conn = Database::connect();

    try{
        $query = $conn->prepare("SELECT * FROM Usuarios WHERE correo = :email OR id = :id");
        $query->bindParam(':email', $email);
        $query->bindParam(':id', $id);
        $query->execute();

        if ($query->rowCount() > 0){
            echo "Error: Usuario ya registrado.";
            exit();
        } 
        else{
            $query = $conn->prepare("INSERT INTO Usuarios (id, nombre, correo, clave, idType) VALUES (:id, :name, :email, :hashed_password, 3)");
            $query->bindParam(':id', $id);
            $query->bindParam(':name', $name);
            $query->bindParam(':email', $email);
            $query->bindParam(':hashed_password', $hashed_password);
            $query->execute();

            header('Location: /TC2005B_602_01/IngeniaLab/src/views/users.php');
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        Database::disconnect();
    }
}

function insertarmaestro($id, $name, $email, $password){
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $conn = Database::connect();

    try{
        $query = $conn->prepare("SELECT * FROM Usuarios WHERE correo = :email OR id = :id");
        $query->bindParam(':email', $email);
        $query->bindParam(':id', $id);
        $query->execute();

        if ($query->rowCount() > 0){
            echo "Error: Usuario ya registrado.";
            exit();
        } 
        else{
            $query = $conn->prepare("INSERT INTO Usuarios (id, nombre, correo, clave, idType) VALUES (:id, :name, :email, :hashed_password, 2)");
            $query->bindParam(':id', $id);
            $query->bindParam(':name', $name);
            $query->bindParam(':email', $email);
            $query->bindParam(':hashed_password', $hashed_password);
            $query->execute();

            header('Location: /TC2005B_602_01/IngeniaLab/src/views/users.php');
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        Database::disconnect();
    }
}

function insertarsuperadmin($id, $name, $email, $password){
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $conn = Database::connect();

    try{
        $query = $conn->prepare("SELECT * FROM Usuarios WHERE correo = :email OR id = :id");
        $query->bindParam(':email', $email);
        $query->bindParam(':id', $id);
        $query->execute();

        if ($query->rowCount() > 0){
            echo "Error: Usuario ya registrado.";
            exit();
        } 
        else{
            $query = $conn->prepare("INSERT INTO Usuarios (id, nombre, correo, clave, idType) VALUES (:id, :name, :email, :hashed_password, 1)");
            $query->bindParam(':id', $id);
            $query->bindParam(':name', $name);
            $query->bindParam(':email', $email);
            $query->bindParam(':hashed_password', $hashed_password);
            $query->execute();

            header('Location: /TC2005B_602_01/IngeniaLab/src/views/users.php');
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        Database::disconnect();
    }
}

?>
