// ./assets/js/popups.js

/**
 * Muestra un popup en la pantalla.
 * @param {string} message - El mensaje a mostrar.
 * @param {string} type - El tipo de popup ('success' o 'error').
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
