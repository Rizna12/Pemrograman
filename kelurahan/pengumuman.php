<?php
$pageTitle = "Pengumuman - Kelurahan Jatiwangi";
require_once 'includes/header.php';

// Define announcements array (In production, this would come from a database)
$announcements = array(
    array(
        'id' => 1,
        'title' => 'Pengumuman 1',
        'excerpt' => 'Ringkasan pengumuman 1',
        'content' => 'Konten lengkap pengumuman 1 - Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        'created_at' => '2024-03-21',
        'end_date' => '2024-04-21',
        'status' => 'Aktif'
    ),
    array(
        'id' => 2,
        'title' => 'Pengumuman 2',
        'excerpt' => 'Ringkasan pengumuman 2',
        'content' => 'Konten lengkap pengumuman 2 - Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        'created_at' => '2024-03-20',
        'end_date' => '2024-04-20',
        'status' => 'Aktif'
    ),
    array(
        'id' => 3,
        'title' => 'Pengumuman 3',
        'excerpt' => 'Ringkasan pengumuman 3',
        'content' => 'Konten lengkap pengumuman 3 - Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        'created_at' => '2024-03-19',
        'end_date' => '2024-04-19',
        'status' => 'Aktif'
    )
);

// Get specific announcement if ID is provided
$selectedAnnouncement = null;
if (isset($_GET['id'])) {
    foreach ($announcements as $announcement) {
        if ($announcement['id'] == $_GET['id']) {
            $selectedAnnouncement = $announcement;
            break;
        }
    }
}
?>

<?php if ($selectedAnnouncement): ?>
<!-- Single Announcement View -->
<section class="announcement-detail">
    <div class="container">
        <nav class="breadcrumb">
            <a href="index.php">Beranda</a> &gt; 
            <a href="pengumuman.php">Pengumuman</a> &gt; 
            <?php echo htmlspecialchars($selectedAnnouncement['title']); ?>
        </nav>
        
        <article class="announcement-content">
            <div class="announcement-header">
                <h1><?php echo htmlspecialchars($selectedAnnouncement['title']); ?></h1>
                <div class="announcement-meta">
                    <span class="date"><i class="far fa-calendar"></i> Tanggal: <?php echo date('d M Y', strtotime($selectedAnnouncement['created_at'])); ?></span>
                    <span class="end-date"><i class="far fa-calendar-times"></i> Berakhir: <?php echo date('d M Y', strtotime($selectedAnnouncement['end_date'])); ?></span>
                    <span class="status <?php echo strtolower($selectedAnnouncement['status']); ?>">
                        <i class="far fa-check-circle"></i> <?php echo htmlspecialchars($selectedAnnouncement['status']); ?>
                    </span>
                </div>
            </div>
            
            <div class="announcement-body">
                <?php echo nl2br(htmlspecialchars($selectedAnnouncement['content'])); ?>
            </div>
            
            <div class="announcement-footer">
                <div class="share-buttons">
                    <h4>Bagikan:</h4>
                    <a href="#" class="btn btn-social facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="btn btn-social twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="btn btn-social whatsapp"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </article>
    </div>
</section>

<?php else: ?>
<!-- Announcements List View -->
<section class="announcements-archive">
    <div class="container">
        <div class="page-header">
            <h1>Pengumuman</h1>
        </div>
        
        <div class="filter-section">
            <form action="" method="get" class="announcement-filter">
                <select name="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="Aktif">Aktif</option>
                    <option value="Berakhir">Berakhir</option>
                </select>
                <input type="text" name="search" class="form-control" placeholder="Cari pengumuman...">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
        </div>

        <div class="announcements-list">
            <?php foreach($announcements as $announcement): ?>
            <div class="announcement-item">
                <div class="announcement-date">
                    <span class="date"><?php echo date('d', strtotime($announcement['created_at'])); ?></span>
                    <span class="month"><?php echo date('M', strtotime($announcement['created_at'])); ?></span>
                </div>
                <div class="announcement-content">
                    <h3><?php echo htmlspecialchars($announcement['title']); ?></h3>
                    <div class="meta-info">
                        <span class="end-date">Berakhir: <?php echo date('d M Y', strtotime($announcement['end_date'])); ?></span>
                        <span class="status <?php echo strtolower($announcement['status']); ?>"><?php echo htmlspecialchars($announcement['status']); ?></span>
                    </div>
                    <p><?php echo htmlspecialchars($announcement['content']); ?></p>
                    <a href="pengumuman.php?id=<?php echo $announcement['id']; ?>" class="btn btn-outline">Baca selengkapnya</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="pagination">
            <a href="#" class="prev">&laquo; Sebelumnya</a>
            <span class="current">1</span>
            <a href="#">2</a>
            <a href="#">3</a>
            <a href="#" class="next">Selanjutnya &raquo;</a>
        </div>
    </div>
</section>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>