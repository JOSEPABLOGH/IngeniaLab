var currentView = "list";

$(document).ready(function() {
    loadCurrentView();
});

function loadCurrentView() {
    if (currentView === "list") {
        viewList();
    } else {
        viewCards();
    }
}

function changeStatusAll(newStatus) {
    $.get("../machines/change-status-all.php", {newStatus: newStatus}, function(data) {
        loadCurrentView();
    }).fail(function() {
        alert('Error al cambiar el estado de todas las máquinas');
    });
}

function changeStatus(idMaquina) {
    $.get("../machines/change-status.php", { ID: idMaquina }, function(data) {
        loadCurrentView();
    }).fail(function() {
        alert('Error al cambiar el estado de la máquina');
    });
}

function editModal(machineId) {
    
    $.ajax({
        url: '../machines/get_machine.php', // Ruta al archivo PHP que devolverá los detalles de la máquina
        type: 'GET',
        data: { id: machineId },
        success: function(response) {
            var machine = JSON.parse(response);
            $('#editID').val(machine.ID);
            $('#editNombre').val(machine.nombre);
            $('#editNumSerie').val(machine.numSerie);
            $('#editTipoMaquina').val(machine.tipoMaquina);
            $('#editModal').css('display', 'block');
        },
        error: function(error) {
            console.error('Error obteniendo los detalles de la máquina:', error);
        }
    });

}

function deleteMachine(idMaquina) {
    $.get("../machines/delete.php", { ID: idMaquina }, function(data) {
        loadCurrentView();
    }).fail(function() {
        alert('Error al eliminar maquina');
    });
}

function searchTable() {

    var input, filter, table, tr, td, i, j, txtValue, visible;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("user-table");
    tr = table.getElementsByTagName("tr");
    var tbody = table.querySelector("tbody");
    var noResultFound = true;

    // Remover fila de "No se encontraron resultados" si existe
    var noResultsRow = document.querySelector(".no-results");
    if (noResultsRow) {
        noResultsRow.remove();
    }

    // Ocultar todas las filas de datos y buscar coincidencias
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

    // Si no se encontraron resultados, agregar fila de "No se encontraron resultados"
    if (noResultFound) {
        var newRow = document.createElement("tr");
        newRow.className = "no-results";
        newRow.innerHTML = "<td colspan='4'>No se encontraron resultados</td>";
        tbody.appendChild(newRow);
    }

}

function toggleView() {
    if (currentView === "list") {
        currentView = "card";
        document.getElementById('toggleViewButton').innerHTML = '<i class="fas fa-list"></i>';
        viewCards();
    } else {
        currentView = "list";
        document.getElementById('toggleViewButton').innerHTML = '<i class="fas fa-th"></i>';
        viewList();
    }
}

function viewList() {
    $('#machines-table').load('/TC2005B_602_01/IngeniaLab/src/machines/list-machines.php', function(response, status, xhr) {
        if (status == "error") {
            alert("Error al cargar la lista de profesores: " + xhr.status + " " + xhr.statusText);
        }
    });
}

function viewCards() {
    $('#machines-table').load('/TC2005B_602_01/IngeniaLab/src/machines/cards-machines.php', function(response, status, xhr) {
        if (status == "error") {
            alert("Error al cargar la lista de estudiantes: " + xhr.status + " " + xhr.statusText);
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    var btnConfirmDelete = document.getElementById('confirmDelete');

    // Esto debería reemplazar cualquier onclick existente con este más específico
    btnConfirmDelete.onclick = function(event) {
        var modal = document.getElementById('deleteConfirmationModal');
        var studentId = modal.getAttribute('data-machine-id');

        $.get("../machines/delete.php", { ID: studentId }, function(data) {
            loadCurrentView();
            modal.style.display = 'none'; // Cierra la modal después de la acción
        }).fail(function() {
            alert('Error al eliminar maquina');
        });
    };
});

function openDeleteConfirmation(idMachine) {
    var modal = document.getElementById('deleteConfirmationModal');
    modal.style.display = "block";
    modal.setAttribute('data-machine-id', idMachine);
}