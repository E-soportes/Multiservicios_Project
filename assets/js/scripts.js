// Scripts personalizados Multiservicios

$(document).ready(function() {
    // Confirmaciones
    $('[onclick*="confirm"]').click(function(e) {
        if (!confirm('¿Está seguro?')) {
            e.preventDefault();
        }
    });

    // Tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Auto refresh métricas cada 5min
    setInterval(function() {
        // AJAX refresh dashboard si necesario
    }, 300000);
});

// Formularios CSRF (pendiente implementar)
function agregarCSRF(form) {
    // Helper para seguridad
}

// DataTables configuración global
$.extend( true, $.fn.dataTable.defaults, {
    language: {
        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
    },
    pageLength: 25,
    responsive: true,
    dom: 'Bfrtip',
    buttons: ['copy', 'excel']
});
