document.addEventListener('DOMContentLoaded', function() {
    var btnConfirmDeleteStudent = document.getElementById('confirmDeleteStudent');
    var btnConfirmDeleteTeacher = document.getElementById('confirmDeleteTeacher');

    btnConfirmDeleteStudent.onclick = function(event) {
        var modal = document.getElementById('deleteStudentConfirmationModal');
        var studentId = modal.getAttribute('data-student-id');

        $.get("../users/delete-student.php", { ID: studentId }, function(data) {
            loadCurrentView();
            modal.style.display = 'none';
        }).fail(function() {
            alert('Error al eliminar estudiante');
        });
    };

    btnConfirmDeleteTeacher.onclick = function(event) {

        var modal = document.getElementById('deleteTeacherConfirmationModal');
        var teacherId = modal.getAttribute('data-teacher-id');

        $.get("../users/delete-teacher.php", { ID: teacherId }, function(data) {
            loadCurrentView();
            modal.style.display = 'none';
        }).fail(function() {
            alert('Error al eliminar maestro');
        });

    };
});

function openDeleteTeacherConfirmation(idTeacher) {
    var modal = document.getElementById('deleteTeacherConfirmationModal');
    modal.style.display = "block";
    modal.setAttribute('data-teacher-id', idTeacher);
}

function openDeleteStudentConfirmation(idStudent) {
    var modal = document.getElementById('deleteStudentConfirmationModal');
    modal.style.display = "block";
    modal.setAttribute('data-student-id', idStudent);
}

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

    fetch('/TC2005B_602_01/IngeniaLab/src/users/update_teacher.php', {
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
