document.addEventListener('DOMContentLoaded', function() {
// Recuperar datos del localStorage
const savedData = localStorage.getItem('formData');

if (savedData) {
    const formData = JSON.parse(savedData);
    const displayDiv = document.getElementById('formDataDisplay');
    
    // Limpiar localStorage después de usarlo
    localStorage.removeItem('formData');
    
    // Mostrar los datos del formulario
    displayDiv.innerHTML = `
        <div class="data-item">
            <span class="data-label">Nombre:</span> ${formData.name}
        </div>
        <div class="data-item">
            <span class="data-label">Email:</span> ${formData.email}
        </div>
        <div class="data-item">
            <span class="data-label">Teléfono:</span> ${formData.phone || 'No proporcionado'}
        </div>
        <div class="data-item">
            <span class="data-label">Método de contacto preferido:</span> ${formData.contactMethod}
        </div>
        <div class="data-item">
            <span class="data-label">Mensaje:</span> ${formData.message}
        </div>
    `;
} else {
    window.location.href = 'index.html';
}
});
// Menú móvil
document.querySelector('.mobile-menu').addEventListener('click', function() {
    document.querySelector('nav').classList.toggle('active');
});