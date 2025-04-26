// Configurar la fecha límite mínima como hoy
document.addEventListener('DOMContentLoaded', function() {
    const fechaLimiteInput = document.getElementById('fecha_limite');
    if (fechaLimiteInput) {
        const hoy = new Date().toISOString().split('T')[0];
        fechaLimiteInput.setAttribute('min', hoy);
    }
    
    // Confirmar eliminación de tarea
    const eliminarForm = document.querySelector('form[action="./procesos/eliminar_tarea.php"]');
    if (eliminarForm) {
        eliminarForm.addEventListener('submit', function(e) {
            const confirmacion = confirm('¿Estás seguro de eliminar esta tarea?');
            if (!confirmacion) {
                e.preventDefault();
            }
        });
    }
    
    // Cambiar color del borde según prioridad seleccionada
    const prioridadSelect = document.getElementById('prioridad');
    if (prioridadSelect) {
        prioridadSelect.addEventListener('change', function() {
            const valor = this.value;
            const borderColor = valor === 'alta' ? '#dc3545' : valor === 'media' ? '#ffc107' : '#28a745';
            this.style.borderColor = borderColor;
        });
        
        // Disparar el evento change para aplicar el color inicial
        const event = new Event('change');
        prioridadSelect.dispatchEvent(event);
    }
});