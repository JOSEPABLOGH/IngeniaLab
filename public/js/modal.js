var openModalBtns = document.querySelectorAll(".open-modal-btn");

  // Agregar el evento click a cada botón para abrir el modal correspondiente
openModalBtns.forEach(function(btn) {

    btn.onclick = function() {

        let modalId = this.getAttribute("data-modal");
        let modal = document.getElementById(modalId);
        modal.style.display = "block";
    }

});

// Obtener todos los elementos de cerrar (X) y los botones de cancelar
let closeBtns = document.querySelectorAll(".close, .cancel-btn");

// Agregar el evento click a cada uno para cerrar el modal correspondiente
closeBtns.forEach(function(btn) {

    btn.onclick = function() {

        let modalId = this.getAttribute("data-modal");
        let modal = document.getElementById(modalId);
        modal.style.display = "none";

        console.log("Preisonado")

    }
    
});

// Cerrar el modal si el usuario hace click fuera del modal
window.onclick = function(event) {

    if (event.target.classList.contains("modal")) {
        event.target.style.display = "none";
    }

}