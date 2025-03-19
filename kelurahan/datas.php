<?php
$pageTitle = "Data & Statistik - Kelurahan Jatiwangi";
require_once 'includes/header.php';

// Data structures for statistics
$populationData = array(
    'total' => 15789,
    'male' => 7945,
    'female' => 7844,
    'age_groups' => array(
        '0-14' => 3500,
        '15-24' => 2789,
        '25-54' => 6500,
        '55+' => 3000
    ),
    'education' => array(
        'SD' => 2500,
        'SMP' => 3000,
        'SMA' => 5000,
        'D3/S1' => 3500,
        'S2/S3' => 500
    )
);

$householdData = array(
    'total_households' => 4256,
    'average_size' => 3.7,
    'income_groups' => array(
        'low' => 1200,
        'middle' => 2556,
        'high' => 500
    )
);
?>

<!-- Page Header -->
<section class="page-header bg-light">
    <div class="container">
        <h1><i class="fas fa-chart-bar"></i> Data & Statistik</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                <li class="breadcrumb-item active">Data & Statistik</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Population Statistics -->
<section class="statistics-section">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Statistik Penduduk</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="chart-container">
                            <canvas id="genderChart"></canvas>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="stats-summary">
                            <div class="stat-item">
                                <h4>Total Penduduk</h4>
                                <p class="number"><?php echo number_format($populationData['total']); ?></p>
                            </div>
                            <div class="stat-grid">
                                <div class="stat-item">
                                    <h4>Laki-laki</h4>
                                    <p class="number"><?php echo number_format($populationData['male']); ?></p>
                                </div>
                                <div class="stat-item">
                                    <h4>Perempuan</h4>
                                    <p class="number"><?php echo number_format($populationData['female']); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Age Distribution -->
<section class="statistics-section">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Distribusi Usia</h2>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="ageChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Education Level -->
<section class="statistics-section">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Tingkat Pendidikan</h2>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="educationChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Household Statistics -->
<section class="statistics-section">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Statistik Rumah Tangga</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="stats-summary">
                            <div class="stat-item">
                                <h4>Total Kepala Keluarga</h4>
                                <p class="number"><?php echo number_format($householdData['total_households']); ?></p>
                            </div>
                            <div class="stat-item">
                                <h4>Rata-rata Anggota Keluarga</h4>
                                <p class="number"><?php echo number_format($householdData['average_size'], 1); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="chart-container">
                            <canvas id="incomeChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Initialize charts
document.addEventListener('DOMContentLoaded', function() {
    // Gender Distribution Chart
    const genderCtx = document.getElementById('genderChart').getContext('2d');
    new Chart(genderCtx, {
        type: 'pie',
        data: {
            labels: ['Laki-laki', 'Perempuan'],
            datasets: [{
                data: [<?php echo $populationData['male']; ?>, <?php echo $populationData['female']; ?>],
                backgroundColor: ['#36A2EB', '#FF6384']
            }]
        }
    });

    // Age Distribution Chart
    const ageCtx = document.getElementById('ageChart').getContext('2d');
    new Chart(ageCtx, {
        type: 'bar',
        data: {
            labels: ['0-14', '15-24', '25-54', '55+'],
            datasets: [{
                label: 'Jumlah Penduduk',
                data: <?php echo json_encode(array_values($populationData['age_groups'])); ?>,
                backgroundColor: '#36A2EB'
            }]
        }
    });

    // Education Level Chart
    const educationCtx = document.getElementById('educationChart').getContext('2d');
    new Chart(educationCtx, {
        type: 'bar',
        data: {
            labels: ['SD', 'SMP', 'SMA', 'D3/S1', 'S2/S3'],
            datasets: [{
                label: 'Jumlah Penduduk',
                data: <?php echo json_encode(array_values($populationData['education'])); ?>,
                backgroundColor: '#4BC0C0'
            }]
        }
    });

    // Income Distribution Chart
    const incomeCtx = document.getElementById('incomeChart').getContext('2d');
    new Chart(incomeCtx, {
        type: 'doughnut',
        data: {
            labels: ['Rendah', 'Menengah', 'Tinggi'],
            datasets: [{
                data: <?php echo json_encode(array_values($householdData['income_groups'])); ?>,
                backgroundColor: ['#FF6384', '#36A2EB', '#4BC0C0']
            }]
        }
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>