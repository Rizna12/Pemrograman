<?php
$pageTitle = "Agenda Kegiatan - Kelurahan Jatiwangi";
require_once 'includes/header.php';

// Data structure for agenda items
$agendaItems = array(
    array(
        'id' => 1,
        'title' => 'Musyawarah Pembangunan Kelurahan',
        'description' => 'Rapat koordinasi pembangunan infrastruktur kelurahan',
        'date' => '2024-04-15',
        'time' => '09:00',
        'location' => 'Aula Kelurahan Jatiwangi',
        'organizer' => 'Lurah Jatiwangi',
        'status' => 'upcoming'
    ),
    array(
        'id' => 2,
        'title' => 'Posyandu Balita',
        'description' => 'Pemeriksaan kesehatan rutin untuk balita',
        'date' => '2024-04-10',
        'time' => '08:00',
        'location' => 'Pos RT 03',
        'organizer' => 'Kader Posyandu',
        'status' => 'upcoming'
    )
);

// Filter agenda items
$upcomingEvents = array_filter($agendaItems, function($item) {
    return strtotime($item['date']) >= strtotime('today');
});
?>

<!-- Page Header -->
<section class="page-header bg-light">
    <div class="container">
        <h1><i class="fas fa-calendar-alt"></i> Agenda Kegiatan</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                <li class="breadcrumb-item active">Agenda Kegiatan</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Calendar View -->
<section class="agenda-calendar">
    <div class="container">
        <div class="calendar-header">
            <h2>Kalender Kegiatan</h2>
            <div class="calendar-nav">
                <button class="btn btn-outline-primary" id="prevMonth"><i class="fas fa-chevron-left"></i></button>
                <h3 id="currentMonth"><?php echo date('F Y'); ?></h3>
                <button class="btn btn-outline-primary" id="nextMonth"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
        <div class="calendar-grid" id="calendarGrid">
            <!-- Calendar will be populated by JavaScript -->
        </div>
    </div>
</section>

<!-- Upcoming Events -->
<section class="upcoming-events">
    <div class="container">
        <h2>Kegiatan Mendatang</h2>
        <div class="events-list">
            <?php foreach($upcomingEvents as $event): ?>
            <div class="event-card">
                <div class="event-date">
                    <span class="date"><?php echo date('d', strtotime($event['date'])); ?></span>
                    <span class="month"><?php echo date('M', strtotime($event['date'])); ?></span>
                </div>
                <div class="event-details">
                    <h3><?php echo htmlspecialchars($event['title']); ?></h3>
                    <p><?php echo htmlspecialchars($event['description']); ?></p>
                    <div class="event-meta">
                        <span><i class="far fa-clock"></i> <?php echo $event['time']; ?></span>
                        <span><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($event['location']); ?></span>
                        <span><i class="far fa-user"></i> <?php echo htmlspecialchars($event['organizer']); ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>