<?php
session_start();

if (!isset($_SESSION['idType']) || $_SESSION['idType'] != 3) {
    header("Location: /TC2005B_602_01/IngeniaLab/src/views/login.php");
    exit();
}
?>

<div id="addMachineTypeModal" class="modal">
    <div class="modalAdd-content">
        <span class="close" data-modal="addMachineTypeModal">&times;</span>
        <h2>Agregar nueva máquina</h2>
        <form id="addMachineTypeForm">
            <div class="form-group">
                <label for="nombre">Nombre de nueva maquinaria:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-buttons">
                <button type="submit" class="btn-accept">Aceptar</button>
                <button type="button" class="cancel-btn" data-modal="addMachineTypeModal">Cerrar</button>
            </div>
        </form>
        <div id="message"></div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var modal = document.getElementById('addMachineTypeModal');
        var closeModalBtns = document.querySelectorAll('.close, .cancel-btn');
        var form = document.getElementById('addMachineTypeForm');
        var messageDiv = document.getElementById('message');

        closeModalBtns.forEach(function(btn) {
            btn.onclick = function() {
                modal.style.display = 'none';
                window.location.reload();  // Recargar la página al cerrar la ventana modal
            };
        });

        form.onsubmit = function(event) {
            event.preventDefault();

            var formData = new FormData(form);

            fetch('/TC2005B_602_01/IngeniaLab/src/machines/add-machine-type.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messageDiv.innerHTML = '<p style="color:green;">' + data.message + '</p>';
                    form.reset();
                    setTimeout(function() {
                        modal.style.display = 'none';
                        window.location.reload();  // Recargar la página después de mostrar el mensaje de éxito
                    }, 1500);  // Espera 1.5 segundos antes de cerrar la ventana modal y recargar la página
                } else {
                    messageDiv.innerHTML = '<p style="color:red;">' + data.message + '</p>';
                }
            })
            .catch(error => {
                messageDiv.innerHTML = '<p style="color:red;">Error al procesar la solicitud.</p>';
                console.error('Error:', error); // Agregar detalles del error a la consola
            });
        };
    });
</script>
