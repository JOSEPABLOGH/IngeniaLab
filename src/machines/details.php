<div id="machineDetailsModal" class="modal">
    
    <div class="modalDetails-content">
        <span class="close" data-modal="machineDetailsModal">&times;</span>
        <h2>Detalles de la Máquina</h2>
        <div id="machineDetails"></div>
        <div class="form-buttons">
            <button type="button" class="cancel-btn" data-modal="machineDetailsModal">Cerrar</button>
        </div>
    </div>
    
</div>

<script>
    function showDetailsModal(machineId) {
        // Hacer una petición AJAX para obtener los detalles de la máquina
        $.ajax({
            url: '../machines/details.php', // Ajusta la ruta al archivo PHP que devolverá los detalles de la máquina
            type: 'GET',
            data: { id: machineId },
            success: function(response) {
                // Poner la respuesta en el contenido del modal
                $('#machineDetails').html(response);
                // Mostrar el modal
                $('#machineDetailsModal').css('display', 'block');
            },
            error: function(error) {
                console.error('Error obteniendo los detalles de la máquina:', error);
            }
        });
    }

    document.querySelectorAll('.close, .cancel-btn').forEach(function(element) {
        element.onclick = function() {
            document.getElementById('machineDetailsModal').style.display = 'none';
        };
    });
</script>

<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/TC2005B_602_01/IngeniaLab/config/database.php';

if (isset($_GET['id'])) {

    $id = intval($_GET['id']);

    if ($id > 0) {
        $pdo = Database::connect();
        $sql = "SELECT * FROM Maquinas WHERE ID = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $machine = $stmt->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();

        if ($machine) {
            $imagePath = "/TC2005B_602_01/IngeniaLab/src/machines/uploads/" . htmlspecialchars($machine['imagen']);
            echo "<div class='machine-details'>";
            echo "<img src='" . $imagePath . "' alt='Imagen de la máquina' class='machine-image-details'>";
            echo "<p><strong>Número de serie:</strong> " . htmlspecialchars($machine['numSerie']) . "</p>";
            echo "<p><strong>Nombre:</strong> " . htmlspecialchars($machine['nombre']) . "</p>";
            echo "<p><strong>Tipo de Máquina:</strong> " . htmlspecialchars($machine['tipoMaquina']) . "</p>";
            echo "<p><strong>Fecha de Registro:</strong> " . htmlspecialchars($machine['fechaRegistro']) . "</p>";
            echo "<p><strong>Tiempo de Uso:</strong> " . htmlspecialchars($machine['tiempoUso']) . "</p>";
            echo "<p><strong>Estado:</strong> " . htmlspecialchars($machine['estado']) . "</p>";
            echo "<p><strong>Funcionamiento:</strong> " . htmlspecialchars($machine['funcionamiento']) . "</p>";
            echo "</div>";
        } else {
            echo "<p>No se encontraron detalles para esta máquina.</p>";
        }
    } else {
        echo "<p>ID de máquina no válido.</p>";
    }
}
?>
