<div id="addMachineModal" class="modal">

    <div class="modalAdd-content">
        <span class="close" data-modal="addMachineModal">&times;</span>
        <h2>Agregar nueva máquina</h2>

        <form id="addMachineForm" enctype="multipart/form-data">
            <div class="form-group">
                <label for="numSerie">Número de serie: </label>
                <input type="text" id="numSerie" name="numSerie" required>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="tipo_maquina">Tipo de máquina:</label>
                <select name="tipo_maquina" id="tipo_maquina" required>
                    <option value="">Selecciona tipo de maquinaria</option>
                    <?php
                        require_once $_SERVER['DOCUMENT_ROOT'].'/TC2005B_602_01/IngeniaLab/config/database.php';
                        $pdo = Database::connect();
                        $query = 'SELECT * FROM Tipos_maquina';
                        foreach ($pdo->query($query) as $row) {
                            echo "<option value='" . $row['idType'] . "'>" . $row['tipo'] . "</option>";
                        }
                        Database::disconnect();
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen de la Máquina:</label>
                <input type="file" id="imagen" name="imagen" accept="image/*" required>
            </div>
            <div class="form-buttons">
                <button type="submit" class="btn-accept">Aceptar</button>
                <button type="button" class="cancel-btn" data-modal="addMachineModal">Cerrar</button>
            </div>
        </form>
        <div id="message"></div>
    </div>
    
</div>

<script>
    
    document.addEventListener("DOMContentLoaded", function() {

        var modal = document.getElementById('addMachineModal');
        var form = document.getElementById('addMachineForm');
        var messageDiv = document.getElementById('message');

        form.onsubmit = function(event) {
            event.preventDefault();

            var formData = new FormData(form);

            fetch('/TC2005B_602_01/IngeniaLab/src/machines/add_machine.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messageDiv.innerHTML = '<p style="color:green;">' + data.message + '</p>';
                    form.reset();
                    loadCurrentView()
                    }
                    else {
                    messageDiv.innerHTML = '<p style="color:red;">' + data.message + '</p>';
                }
            })
            .catch(error => {
                messageDiv.innerHTML = '<p style="color:red;">Error al procesar la solicitud.</p>';
            });
        };
        
    });

</script>
