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

    <title>Usuarios</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../../public/css/styles.css">
    <link rel="stylesheet" href="../../public/css/users.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

</head>
<body>
    
    <?php include '../common/sideBar.html' ?>

    <div class="main-content" id="main-content">

        <div class="header">

            <h1>Usuarios</h1>
            <button class="open-modal-btn add-button" data-modal="addStudentModal">Agregar Estudiante</button>
            <button type="button" onclick="location.href='/TC2005B_602_01/IngeniaLab/src/views/register.php'">Registrar Administrador o Maestro</button>

        </div>

        <div class="search-bar">

            <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Buscar por nombre, correo, etc.">
            <button type="button" class='add-button' id="toggleViewButton" onclick='toggleView()'> <i class='fas fa-chalkboard-teacher'></i> Ver maestros</button>

        </div>

        <div id="users-table"></div>

    </div>

    <?php require "../users/create-student.php"; ?>
    <?php require "../users/edit-student.php"; ?>
    <?php require "../users/edit-teacher.php"; ?>
    <?php require "../users/confirm-delete-student.php"; ?>
    <?php require "../users/confirm-delete-teacher.php"; ?>

    <script src="/TC2005B_602_01/IngeniaLab/public/js/modal.js"></script>
    <script src="/TC2005B_602_01/IngeniaLab/public/js/users.js"></script>

    <script>

        var currentView = "students"; // Variable para almacenar la vista actual

        $(document).ready(function() {
            loadCurrentView();
        });

        function loadCurrentView() {
            if (currentView === "teachers") {
                viewTeachers();
            } else {
                viewStudents();
            }
        }

        function searchTable() {
            var input, filter, table, tr, td, i, j, txtValue, visible;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("user-table");
            tr = table.getElementsByTagName("tr");
            var tbody = table.querySelector("tbody");
            var noResultFound = true;

            var noResultsRow = document.querySelector(".no-results");
            if (noResultsRow) {
                noResultsRow.remove();
            }

            for (i = 1; i < tr.length; i++) {
                tr[i].style.display = "none";
                td = tr[i].getElementsByTagName("td");
                visible = false;
                for (j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            visible = true;
                            break;
                        }
                    }
                }
                if (visible) {
                    tr[i].style.display = "";
                    noResultFound = false;
                }
            }

            if (noResultFound) {
                var newRow = document.createElement("tr");
                newRow.className = "no-results";
                newRow.innerHTML = "<td colspan='4'>No se encontraron resultados</td>";
                tbody.appendChild(newRow);
            }
        }

        function toggleView() {
            if (currentView === "students") {
                currentView = "teachers";
                document.getElementById('toggleViewButton').innerHTML = '<i class="fas fa-users"></i> Ver estudiantes';
                viewTeachers();
            } else {
                currentView = "students";
                document.getElementById('toggleViewButton').innerHTML = '<i class="fas fa-chalkboard-teacher"></i> Ver maestros';
                viewStudents();
            }
        }

        function viewTeachers() {
            $('#users-table').load('/TC2005B_602_01/IngeniaLab/src/users/teachers.php', function(response, status, xhr) {
                if (status == "error") {
                    alert("Error al cargar la lista de profesores: " + xhr.status + " " + xhr.statusText);
                }
            });
        }

        function viewStudents() {
            $('#users-table').load('/TC2005B_602_01/IngeniaLab/src/users/students.php', function(response, status, xhr) {
                if (status == "error") {
                    alert("Error al cargar la lista de estudiantes: " + xhr.status + " " + xhr.statusText);
                }
            });
        }
        
    </script>

</body>

</html>
