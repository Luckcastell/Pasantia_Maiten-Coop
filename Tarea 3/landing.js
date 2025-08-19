document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = {
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        contactMethod: document.querySelector('input[name="opcion"]:checked').value,
        message: document.getElementById('message').value
    };
    localStorage.setItem('formData', JSON.stringify(formData));
    window.location.href = 'gracias.html';
});
// Menú móvil
document.querySelector('.mobile-menu').addEventListener('click', function() {
    document.querySelector('nav').classList.toggle('active');
});