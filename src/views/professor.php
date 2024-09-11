<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Home - Admin</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="stylesheet" href="/TC2005B_602_01/IngeniaLab/public/css/navBar.css" />
        
        <script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    </head>
    <body>

    <div id="sidebar" class="sidebar">

        <button id="toggleButton" class="toggle-button">&#10095;</button>

        <ul class="sidebar-nav">
            <li class="nav-item">
                <a href="../views/home.php" class="nav-link">
                    <i class="fas fa-home"></i>
                    <span class="link-text">Inicio</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="../views/apartar.php" class="nav-link">
                    <i class="fas fa-calendar"></i>
                    <span class="link-text">Apartar equipo</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/TC2005B_602_01/IngeniaLab/src/common/logout.php" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="link-text">Cerrar Sesión</span>
                </a>
            </li>
        </ul>

    </div>

        <h1>Hello Teacher</h1>

    </body>

    <script>

        document.getElementById('toggleButton').addEventListener('click', function() {
            var sidebar = document.getElementById('sidebar');
            var content = document.getElementById('main-content');
            sidebar.classList.toggle('expanded');
            content.classList.toggle('expanded');
            this.innerHTML = sidebar.classList.contains('expanded') ? '&#10094;' : '&#10095;';
        });

    </script>

</html>