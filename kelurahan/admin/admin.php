<?php
session_start();
// Basic authentication check
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Include database configuration
require_once '../config/database.php';


$pageTitle = "Dashboard Admin - Kelurahan Jatiwangi";

try {
    // Create database connection
    $database = new Database();
    $db = $database->getConnection();

    // Initialize active section from URL parameter
    $activeSection = isset($_GET['section']) ? $_GET['section'] : 'dashboard';

    // Basic stats for dashboard overview
    $stats = array(
        'total_news' => 0,
        'total_announcements' => 0,
        'total_gallery' => 0,
        'pending_services' => 0
    );

    // Get actual stats from database
    $statsQueries = [
        "SELECT COUNT(*) FROM news",
        "SELECT COUNT(*) FROM announcements",
        "SELECT COUNT(*) FROM gallery",
        "SELECT COUNT(*) FROM services WHERE status = 'pending'"
    ];

    foreach ($statsQueries as $index => $query) {
        try {
            $stmt = $db->query($query);
            $count = $stmt->fetchColumn();
            $stats[array_keys($stats)[$index]] = $count;
        } catch (Exception $e) {
            error_log("Error fetching stats: " . $e->getMessage());
        }
    }

} catch (Exception $e) {
    error_log("Database connection error: " . $e->getMessage());
    die("Terjadi kesalahan sistem. Silakan coba lagi nanti.");
}

require_once 'admin-header.php';
require_once 'news-functions.php';
// Rest of the admin page content remains the same
?>
<div class="admin-container">
    <!-- Sidebar Navigation -->
    <aside class="admin-sidebar">
        <div class="admin-profile">
            <img src="../assets/image/kb-logo.png" alt="Admin Profile" class="admin-avatar">
            <div class="admin-info">
                <h4><?php echo htmlspecialchars($_SESSION['admin_id']); ?></h4>
                <span>Administrator</span>
            </div>
        </div>

        <nav class="admin-nav">
            <ul>
                <li class="<?php echo $activeSection == 'dashboard' ? 'active' : ''; ?>">
                    <a href="admin.php?section=dashboard">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="<?php echo $activeSection == 'news' ? 'active' : ''; ?>">
                    <a href="admin.php?section=news">
                        <i class="fas fa-newspaper"></i> Berita
                    </a>
                </li>
                <li class="<?php echo $activeSection == 'announcements' ? 'active' : ''; ?>">
                    <a href="admin.php?section=announcements">
                        <i class="fas fa-bullhorn"></i> Pengumuman
                    </a>
                </li>
                <li class="<?php echo $activeSection == 'statistics' ? 'active' : ''; ?>">
                    <a href="admin.php?section=statistics">
                        <i class="fas fa-chart-bar"></i> Statistik
                    </a>
                </li>
                <li class="<?php echo $activeSection == 'gallery' ? 'active' : ''; ?>">
                    <a href="admin.php?section=gallery">
                        <i class="fas fa-images"></i> Galeri
                    </a>
                </li>
                <li class="<?php echo $activeSection == 'services' ? 'active' : ''; ?>">
                    <a href="admin.php?section=services">
                        <i class="fas fa-file-alt"></i> Layanan
                    </a>
                </li>
                <li class="<?php echo $activeSection == 'settings' ? 'active' : ''; ?>">
                    <a href="admin.php?section=settings">
                        <i class="fas fa-cog"></i> Pengaturan
                    </a>
                </li>
                <li>
                    <a href="logout.php">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content Area -->
    <main class="admin-main">
        <!-- Top Bar -->
        <div class="admin-topbar">
            <button id="sidebar-toggle" class="sidebar-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <div class="search-bar">
                <input type="text" placeholder="Cari...">
                <button><i class="fas fa-search"></i></button>
            </div>
            <div class="topbar-actions">
                <button class="notification-btn">
                    <i class="fas fa-bell"></i>
                    <span class="badge">3</span>
                </button>
                <button class="messages-btn">
                    <i class="fas fa-envelope"></i>
                    <span class="badge">5</span>
                </button>
            </div>
        </div>

        <!-- Dynamic Content Based on Section -->
        <div class="admin-content">
            <?php
            switch($activeSection):
                case 'dashboard':
            ?>
                <!-- Dashboard Overview -->
                <div class="dashboard-overview">
                    <div class="stats-cards">
                        <div class="stat-card">
                            <i class="fas fa-newspaper"></i>
                            <div class="stat-info">
                                <h4>Total Berita</h4>
                                <span><?php echo $stats['total_news']; ?></span>
                            </div>
                        </div>
                        <div class="stat-card">
                            <i class="fas fa-bullhorn"></i>
                            <div class="stat-info">
                                <h4>Pengumuman</h4>
                                <span><?php echo $stats['total_announcements']; ?></span>
                            </div>
                        </div>
                        <div class="stat-card">
                            <i class="fas fa-images"></i>
                            <div class="stat-info">
                                <h4>Galeri</h4>
                                <span><?php echo $stats['total_gallery']; ?></span>
                            </div>
                        </div>
                        <div class="stat-card">
                            <i class="fas fa-file-alt"></i>
                            <div class="stat-info">
                                <h4>Layanan Pending</h4>
                                <span><?php echo $stats['pending_services']; ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activities -->
                    <div class="recent-activities">
                        <h3>Aktivitas Terbaru</h3>
                        <div class="activity-list">
                            <!-- Activity items would be populated here -->
                        </div>
                    </div>
                </div>
                <?php
// Replace the existing news case in the switch statement with this code:
    break; 
    case 'news':
    $newsManager = new NewsManager($db);
    $allNews = $newsManager->getAllNews();
?>
    <!-- News Management -->
    <div class="section-header">
        <h2>Manajemen Berita</h2>
        <button class="btn btn-primary" data-modal="add-news">
            <i class="fas fa-plus"></i> Tambah Berita
        </button>
    </div>
    
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <?php 
                echo $_SESSION['success_message'];
                unset($_SESSION['success_message']);
            ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger">
            <?php 
                echo $_SESSION['error_message'];
                unset($_SESSION['error_message']);
            ?>
        </div>
    <?php endif; ?>

    <div class="content-table">
        <table>
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Penulis</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($allNews): foreach ($allNews as $news): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($news['title']); ?></td>
                        <td><?php echo htmlspecialchars($news['category']); ?></td>
                        <td><?php echo htmlspecialchars($news['author_id']); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($news['created_at'])); ?></td>
                        <td>
                            <button class="btn btn-sm btn-info" onclick="editNews(<?php echo $news['id']; ?>)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form method="POST" action="process/news-delete.php" style="display: inline;">
                                <input type="hidden" name="news_id" value="<?php echo $news['id']; ?>">
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada berita</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php
    break;
                endswitch;
?>
        </div>
    </main>
</div>

<!-- Modals -->
<div id="add-news-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Tambah Berita Baru</h3>
            <button class="close-modal">&times;</button>
        </div>
        <form id="add-news-form" method="POST" action="process/news-add.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="news-title">Judul Berita</label>
                <input type="text" id="news-title" name="title" required>
            </div>
            <div class="form-group">
                <label for="news-category">Kategori</label>
                <select id="news-category" name="category" required>
                    <option value="Umum">Umum</option>
                    <option value="Pengumuman">Pengumuman</option>
                    <option value="Kegiatan">Kegiatan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="news-content">Konten</label>
                <textarea id="news-content" name="content" required></textarea>
            </div>
            <div class="form-group">
                <label for="news-image">Gambar</label>
                <input type="file" id="news-image" name="image" accept="image/*" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary close-modal">Batal</button>
            </div>
        </form>
    </div>
</div>

<style>

</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sidebar Toggle
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const adminContainer = document.querySelector('.admin-container');
    
    sidebarToggle.addEventListener('click', function() {
        adminContainer.classList.toggle('sidebar-collapsed');
    });

    // Modal Handling
    const modals = document.querySelectorAll('.modal');
    const modalTriggers = document.querySelectorAll('[data-modal]');
    const closeButtons = document.querySelectorAll('.close-modal');

    modalTriggers.forEach(trigger => {
        trigger.addEventListener('click', function() {
            const modalId = this.dataset.modal + '-modal';
            document.getElementById(modalId).style.display = 'block';
        });
    });

    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const modal = this.closest('.modal');
            modal.style.display = 'none';
        });
    });

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    });
});

// For mobile toggle
const toggleMobileMenu = () => {
  document.querySelector('.admin-sidebar').classList.toggle('mobile-show');
  document.querySelector('.mobile-backdrop').classList.toggle('show');
}

// Add backdrop div to your HTML
<div class="mobile-backdrop" onclick="toggleMobileMenu()"></div>

</script>

<?php require_once 'admin-footer.php'; ?>