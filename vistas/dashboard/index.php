<h2>Panel de Control</h2>

<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Proyectos Totales</div>
                        <div class="h5 mb-0 font-weight-bold"><?php echo $total_proyectos; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-list-task fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Actividades Pendientes</div>
                        <div class="h5 mb-0 font-weight-bold"><?php echo $actividades_pendientes; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Proyectos Atrasados</div>
                        <div class="h5 mb-0 font-weight-bold"><?php echo $proyectos_atrasados; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-exclamation-triangle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Más cards -->
</div>

<!-- Gráficos (Chart.js) -->
<div class="row">
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Proyectos por Estado</h6>
            </div>
            <div class="card-body">
                <canvas id="proyectosChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Gráfico proyectos
const ctx = document.getElementById('proyectosChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: [<?php foreach($proyectos_por_estado as $estado) { echo '"' . $estado['estado'] . '",'; } ?>],
        datasets: [{
            data: [<?php foreach($proyectos_por_estado as $estado) { echo $estado['total'] . ','; } ?>],
            backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796']
        }]
    },
    options: { responsive: true }
});
</script>
