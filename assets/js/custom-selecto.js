/**
 * Filtra las opciones de un dropdown basado en el valor ingresado en un campo de texto asociado.
 * Requiere un contenedor con una estructura de `<input>` y `<select>` donde `select` tenga la clase `custom-select`.
 */
document.addEventListener("DOMContentLoaded", () => {
    const customSelectContainers = document.querySelectorAll(".custom-select-container");

    customSelectContainers.forEach(container => {
        const searchInput = container.querySelector(".custom-select-search");
        const selectElement = container.querySelector(".custom-select");

        if (searchInput && selectElement) {
            searchInput.addEventListener("input", () => {
                const filter = searchInput.value.toLowerCase();
                Array.from(selectElement.options).forEach(option => {
                    const text = option.textContent.toLowerCase();
                    option.style.display = text.includes(filter) ? "block" : "none";
                });

                // Seleccionar automáticamente el primer elemento visible
                const visibleOptions = Array.from(selectElement.options).filter(option => option.style.display !== "none");
                if (visibleOptions.length > 0) {
                    selectElement.value = visibleOptions[0].value;
                } else {
                    selectElement.value = "";
                }
            });
        }
    });
});
