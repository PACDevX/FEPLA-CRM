/**
 * Función para mostrar mensajes emergentes.
 * @param {string} message - El mensaje a mostrar.
 * @param {string} type - El tipo de mensaje ('success' o 'error').
 */
function showPopup(message, type) {
    const popup = document.createElement("div");
    popup.className = `popup-message ${type}`;
    popup.textContent = message;
    document.body.appendChild(popup);

    setTimeout(() => {
        popup.style.opacity = '0';
        setTimeout(() => popup.remove(), 500);
    }, 3000);
}

/**
 * Validar el formulario antes de enviarlo.
 * @param {HTMLFormElement} form - El formulario a validar.
 * @returns {boolean} - Si el formulario es válido.
 */
function validateForm(form) {
    const inputs = form.querySelectorAll("input[required]");
    let isValid = true;

    inputs.forEach(input => {
        if (!input.value.trim()) {
            isValid = false;
            input.classList.add("error");
        } else {
            input.classList.remove("error");
        }
    });

    if (!isValid) {
        showPopup("Por favor, completa todos los campos obligatorios.", "error");
    }

    return isValid;
}

/**
 * Confirmar antes de realizar una acción destructiva.
 * @param {string} message - El mensaje de confirmación.
 * @returns {boolean} - Si el usuario confirma la acción.
 */
function confirmAction(message) {
    return window.confirm(message);
}

// Inicializar eventos en el DOM
document.addEventListener("DOMContentLoaded", () => {
    // Añadir validación a los formularios
    const forms = document.querySelectorAll("form.validate");
    forms.forEach(form => {
        form.addEventListener("submit", (event) => {
            if (!validateForm(form)) {
                event.preventDefault();
            }
        });
    });

    // Añadir confirmación a botones de eliminar
    const deleteButtons = document.querySelectorAll(".delete-button");
    deleteButtons.forEach(button => {
        button.addEventListener("click", (event) => {
            if (!confirmAction("¿Estás seguro de que deseas eliminar este registro?")) {
                event.preventDefault();
            }
        });
    });
});
