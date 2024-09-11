<div id="modalEditTeacher" class="modalEdit">
    <div class="modalEdit-content">
        <span class="close" data-modal="modalEditTeacher">&times;</span>
        <h2>Editar Maestro</h2>
        <form id="editTeacherForm">

            <div class="form-group">
                <label for="editTeacherID">ID</label>
                <input type="hidden" id="editTeacherID" name="id">
                <input type="text" id="editTeacherIDDisplay" name="idDisplay" readonly>
            </div>
            <div class="form-group">
                <label for="editTeacherNombre">Nombre</label>
                <input type="text" id="editTeacherNombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="editTeacherCorreo">Correo Electrónico</label>
                <input type="email" id="editTeacherCorreo" name="correo" required>
            </div>
            <div class="form-buttons">
                <button type="submit" class="btn-accept">Guardar Cambios</button>
                <button type="button" class="btn-cancel" data-modal="modalEditTeacher">Cerrar</button>
            </div>
            
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    const modal = document.getElementById("modalEditTeacher");
    const closeBtn = modal.querySelector(".close");

    closeBtn.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    document.querySelector('.btn-cancel').onclick = function() {
        modal.style.display = "none";
    }
});

function openEditTeacherModal(rowData) {
    const modal = document.getElementById("modalEditTeacher");
    modal.style.display = "block";

    document.getElementById("editTeacherID").value = rowData.id;
    document.getElementById("editTeacherIDDisplay").value = rowData.id;
    document.getElementById("editTeacherNombre").value = rowData.nombre;
    document.getElementById("editTeacherCorreo").value = rowData.correo;
}

document.getElementById('editTeacherForm').onsubmit = function(event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch('update_teacher.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Maestro actualizado correctamente.');
            // Aquí puedes agregar código para actualizar la tabla sin recargar la página
            const id = document.getElementById('editTeacherID').value;
            const nombre = document.getElementById('editTeacherNombre').value;
            const correo = document.getElementById('editTeacherCorreo').value;

            const row = document.querySelector(`button[onclick='openEditTeacherModal(${id})']`).closest('tr');
            row.children[1].textContent = nombre;
            row.children[2].textContent = correo;

            // Cerrar el modal
            const modal = document.getElementById("modalEditTeacher");
            modal.style.display = "none";
        } else {
            alert('Error al actualizar el maestro: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
};
</script>
