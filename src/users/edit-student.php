<div id="modalEdit" class="modal">
    <div class="modalEdit-content">
        <span class="close" data-modal="modalEdit">&times;</span>
        <h2>Editar Estudiante</h2>
        <form id="editForm">

            <div class="form-group">
                <label for="editNombre">Nombre</label>
                <input type="hidden" id="editID" name="ID">
                <input type="text" id="editNombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="editMatricula">Matricula</label>
                <input type="text" id="editMatricula" name="matricula" required>
            </div>
            <div class="form-group">
                <label for="editCorreo">Correo electrónico</label>
                <input type="email" id="editCorreo" name="correo" required>
            </div>
            <div class="form-group">
                <label for="editCarrera">Carrera</label>
                <select id="editCarrera" name="carrera" required>
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
                <button type="submit" class="btn-accept">Guardar Cambios</button>
                <button type="button" class="cancel-btn" data-modal="modalEdit">Cerrar</button>
            </div>
            
        </form>
    </div>
</div>

<script>
document.getElementById('editForm').onsubmit = function(event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch('/TC2005B_602_01/IngeniaLab/src/users/update-student.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            loadCurrentView()
        } else {
            alert('Error al actualizar el estudiante: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
};
</script>
