<?php
$pageTitle = "Beranda - Kelurahan Jatiwangi";
require_once 'includes/header.php';

// Define array types for data structures
$newsData = array(
    array(
        'id' => 1,
        'title' => 'Berita 1',
        'excerpt' => 'Deskripsi berita 1',
        'content' => 'Konten lengkap berita 1',
        'image_url' => 'assets/image/berita1.jpg',
        'category' => 'Umum',
        'author' => 'Admin',
        'created_at' => '2024-03-21'
    ),
    array(
        'id' => 2,
        'title' => 'Berita 2',
        'excerpt' => 'Deskripsi berita 2',
        'content' => 'Konten lengkap berita 2',
        'image_url' => 'assets/image/berita2.jpg',
        'category' => 'Pengumuman',
        'author' => 'Staff',
        'created_at' => '2024-03-20'
    )
);

$quickLinks = array(
    array(
        'id' => 1,
        'title' => 'Pelayanan Administrasi',
        'description' => 'Urus surat dan dokumen secara online',
        'icon' => 'fas fa-file-alt',
        'url' => 'administrasi.php'
    ),
    array(
        'id' => 2,
        'title' => 'Pengaduan',
        'description' => 'Sampaikan keluhan dan aspirasi',
        'icon' => 'fas fa-headset',
        'url' => 'pengaduan.php'
    ),
    array(
        'id' => 3,
        'title' => 'Agenda Kegiatan',
        'description' => 'Jadwal kegiatan kelurahan',
        'icon' => 'fas fa-calendar-alt',
        'url' => 'agenda.php'
    ),
    array(
        'id' => 4,
        'title' => 'Data & Statistik',
        'description' => 'Informasi demografis kelurahan',
        'icon' => 'fas fa-chart-bar',
        'url' => 'datas.php'
    )
);

$statistics = array(
    array(
        'id' => 1,
        'title' => 'Total Penduduk',
        'value' => 15789,
        'icon' => 'fas fa-users'
    ),
    array(
        'id' => 2,
        'title' => 'Jumlah KK',
        'value' => 4256,
        'icon' => 'fas fa-home'
    ),
    array(
        'id' => 3,
        'title' => 'RT/RW',
        'value' => 45,
        'icon' => 'fas fa-building'
    ),
    array(
        'id' => 4,
        'title' => 'Layanan per Bulan',
        'value' => 324,
        'icon' => 'fas fa-file-alt'
    )
);

$galleryImages = array(
    array(
        'id' => 1,
        'title' => 'Kegiatan 1',
        'description' => 'Deskripsi kegiatan 1',
        'url' => 'assets/image/gallery.jpg',
        'created_at' => '2024-03-21'
    ),
    array(
        'id' => 2,
        'title' => 'Kegiatan 2',
        'description' => 'Deskripsi kegiatan 2',
        'url' => 'assets/image/gallery.jpg',
        'created_at' => '2024-03-20'
    )
);

$announcements = array(
    array(
        'id' => 1,
        'title' => 'Pengumuman 1',
        'excerpt' => 'Ringkasan pengumuman 1',
        'content' => 'Konten lengkap pengumuman 1',
        'created_at' => '2024-03-21'
    ),
    array(
        'id' => 2,
        'title' => 'Pengumuman 2',
        'excerpt' => 'Ringkasan pengumuman 2',
        'content' => 'Konten lengkap pengumuman 2',
        'created_at' => '2024-03-20'
    )
);
?>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h1>Selamat Datang di Website Kelurahan Jatiwangi</h1>
        <p class="hero-text">Melayani masyarakat dengan sepenuh hati untuk kehidupan yang lebih baik.</p>
        <div class="hero-buttons">
            <a href="about.php" class="btn btn-primary">Telusuri lebih lanjut</a>
            <a href="layanan.php" class="btn btn-secondary">Layanan Online</a>
        </div>
    </div>
</section>

<!-- Quick Links Section -->
<section class="quick-links">
    <div class="container">
        <div class="quick-links-grid">
            <?php foreach($quickLinks as $link): ?>
            <a href="<?php echo $link['url']; ?>" class="quick-link-card">
                <i class="<?php echo $link['icon']; ?>"></i>
                <h3><?php echo htmlspecialchars($link['title']); ?></h3>
                <p><?php echo htmlspecialchars($link['description']); ?></p>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Announcements Section -->
<section class="announcements">
    <div class="container">
        <div class="section-header">
            <h2><i class="fas fa-bullhorn"></i> Pengumuman Terbaru</h2>
            <a href="pengumuman.php" class="view-all">Lihat Semua</a>
        </div>
        <div class="announcement-list">
            <?php foreach($announcements as $announcement): ?>
            <div class="announcement-item">
                <div class="announcement-date">
                    <span class="date"><?php echo date('d', strtotime($announcement['created_at'])); ?></span>
                    <span class="month"><?php echo date('M', strtotime($announcement['created_at'])); ?></span>
                </div>
                <div class="announcement-content">
                    <h3><?php echo htmlspecialchars($announcement['title']); ?></h3>
                    <p><?php echo htmlspecialchars($announcement['excerpt']); ?></p>
                    <a href="pengumuman.php?id=<?php echo $announcement['id']; ?>">Baca selengkapnya</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Latest News Section -->
<section class="berita">
    <div class="container">
        <div class="section-header">
            <h2>Berita Terkini</h2>
            <a href="berita.php" class="view-all">Lihat Semua Berita</a>
        </div>
        <div class="news-grid">
            <?php foreach($newsData as $news): ?>
            <article class="news-card">
                <div class="news-image">
                    <img src="<?php echo htmlspecialchars($news['image_url']); ?>" 
                         alt="<?php echo htmlspecialchars($news['title']); ?>"
                         loading="lazy">
                    <div class="news-category"><?php echo htmlspecialchars($news['category']); ?></div>
                </div>
                <div class="news-content">
                    <div class="news-meta">
                        <span><i class="far fa-calendar"></i> <?php echo date('d M Y', strtotime($news['created_at'])); ?></span>
                        <span><i class="far fa-user"></i> <?php echo htmlspecialchars($news['author']); ?></span>
                    </div>
                    <h3><?php echo htmlspecialchars($news['title']); ?></h3>
                    <p><?php echo htmlspecialchars($news['excerpt']); ?></p>
                    <a href="berita.php?id=<?php echo $news['id']; ?>" class="btn btn-outline">Baca selengkapnya</a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="statistics bg-light">
    <div class="container">
        <div class="stats-grid">
            <?php foreach($statistics as $stat): ?>
            <div class="stat-item">
                <i class="<?php echo $stat['icon']; ?>"></i>
                <h3><?php echo htmlspecialchars($stat['title']); ?></h3>
                <div class="counter" data-target="<?php echo $stat['value']; ?>">0</div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="gallery">
    <div class="container">
        <div class="section-header">
            <h2>Galeri Kegiatan</h2>
            <a href="galeri.php" class="view-all">Lihat Semua Galeri</a>
        </div>
        <div class="gallery-grid">
            <?php foreach($galleryImages as $image): ?>
            <div class="gallery-item">
                <img src="<?php echo htmlspecialchars($image['url']); ?>" 
                     alt="<?php echo htmlspecialchars($image['title']); ?>"
                     loading="lazy">
                <div class="gallery-overlay">
                    <h4><?php echo htmlspecialchars($image['title']); ?></h4>
                    <p><?php echo htmlspecialchars($image['description']); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
