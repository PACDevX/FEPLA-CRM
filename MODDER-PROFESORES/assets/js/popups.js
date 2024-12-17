/**
 * Muestra un popup en la pantalla.
 * @param {string} message - El mensaje a mostrar.
 * @param {string} type - El tipo de popup ('success' o 'error').
 */
function showPopup(message, type) {
    // Crear el contenedor del popup
    const popup = document.createElement("div");
    popup.className = `popup-message ${type}`;
    popup.textContent = message;
    document.body.appendChild(popup);

    // Añadir animación de desvanecimiento
    setTimeout(() => {
        popup.style.opacity = '0';
        setTimeout(() => popup.remove(), 500);
    }, 3000); // El popup desaparecerá después de 3 segundos
}

/**
 * Lee los parámetros de la URL y muestra un popup si corresponde.
 * Este método espera parámetros 'error' o 'message'.
 */
function initPopupsFromUrl() {
    const urlParams = new URLSearchParams(window.location.search);
    const errorMessage = urlParams.get("error");
    const successMessage = urlParams.get("message");

    if (errorMessage) {
        showPopup(decodeURIComponent(errorMessage), 'error');
    } else if (successMessage) {
        showPopup(decodeURIComponent(successMessage), 'success');
    }
}

// Ejecutar automáticamente al cargar el archivo
document.addEventListener("DOMContentLoaded", () => {
    initPopupsFromUrl();
});

// Agregar el CSS dinámicamente
(function addPopupCSS() {
    const style = document.createElement('style');
    style.innerHTML = `
        .popup-message {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 10px 20px;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            z-index: 1000;
            opacity: 1;
            transition: opacity 0.5s ease-in-out;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .popup-message.success {
            background-color: #4CAF50; /* Verde para éxito */
        }

        .popup-message.error {
            background-color: #f44336; /* Rojo para error */
        }
    `;
    document.head.appendChild(style);
})();
