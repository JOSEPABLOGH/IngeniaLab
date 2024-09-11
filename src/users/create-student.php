<div id="addStudentModal" class="modal">

    <div class="modalAdd-content">
        <span class="close" data-modal="addStudentModal">&times;</span>
        <h2>Agregar Usuario</h2>
        
        <form id="addStudentForm">
            <div class="form-group">
                <label for="firstname">Nombre</label>
                <input type="text" id="name" name="name" maxlength="60" required>
            </div>
            <div class="form-group">
                <label for="lastname">Matricula</label>
                <input type="text" id="matricula" name="matricula" pattern="^[Aa]\d{8}" maxlength="9" minlength="9" title="Matrícula debe tener 9 digitos y comenzar por A o L." required>
            </div>
            <div class="form-group">
                <label for="phone">Correo institucional</label>
                <input type="text" id="mail" name="mail" maxlength="16" minlength="16" required>
            </div>
            <div class="form-group">
                <label for="select">Carrera</label>
                <select id="carrera" name="carrera" required>
                    <option value="">Selecciona carrera</option>
                    <?php
                        require_once $_SERVER['DOCUMENT_ROOT'].'/TC2005B_602_01/IngeniaLab/config/database.php';

                        $pdo = Database::connect();
                        $query = 'SELECT * FROM Carreras';

                        foreach ($pdo->query($query) as $row) {
                            echo "<option value='" . $row['ID'] . "'>" . $row['ID'] . ' - ' . $row['carrera'] . "</option>";
                        }
                        Database::disconnect();
                    ?>
                </select>
            </div>
            <div class="form-buttons">
                <button type="submit" class="btn-accept">Aceptar</button>
                <button type="button" class="cancel-btn" data-modal="addStudentModal">Cerrar</button>
            </div>
        </form>
        <div id="message"></div>
    </div>
    
</div>

<script>

    document.addEventListener("DOMContentLoaded", function() {

        var modal = document.getElementById('addStudentModal');
        var form = document.getElementById('addStudentForm');
        var messageDiv = document.getElementById('message');

        form.onsubmit = function(event) {

            event.preventDefault();

            var matricula = document.getElementById('matricula').value;
            var correo = document.getElementById('mail').value;

            if (correo.substr(0, 9) !== matricula) {
                messageDiv.innerHTML = '<p style="color:red;">Los primeros 9 dígitos del correo deben ser iguales a la matrícula.</p>';
                return;
            }

            var formData = new FormData(form);

            fetch('/TC2005B_602_01/IngeniaLab/src/users/insert-estudiante.php', {
                method: 'POST',
                body: formData
            })  
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messageDiv.innerHTML = '<p style="color:green;">' + data.message + '</p>';
                    form.reset();
                    setTimeout(function() {
                        messageDiv.innerHTML = ''; // Limpiar el mensaje después de 3 segundos
                    }, 3000);
                    $('tbody').load('/TC2005B_602_01/IngeniaLab/src/users/students.php')
                } else {
                    messageDiv.innerHTML = '<p style="color:red;">' + data.message + '</p>';
                    setTimeout(function() {
                        messageDiv.innerHTML = ''; // Limpiar el mensaje después de 3 segundos
                    }, 3000);
                }
            })
            .catch(error => {
                messageDiv.innerHTML = '<p style="color:red;">Error al procesar la solicitud.</p>';
                setTimeout(function() {
                        messageDiv.innerHTML = ''; // Limpiar el mensaje después de 3 segundos
                    }, 3000);
            });
        };
    });

</script>
