<?php
$pageTitle = "Berita - Kelurahan Jatiwangi";
require_once 'includes/header.php';

// Define news data array (In production, this would come from a database)
$newsData = array(
    array(
        'id' => 1,
        'title' => 'Berita 1',
        'excerpt' => 'Deskripsi berita 1',
        'content' => 'Konten lengkap berita 1 - Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        'image_url' => 'assets/image/berita1.jpg',
        'category' => 'Umum',
        'author' => 'Admin',
        'created_at' => '2024-03-21'
    ),
    array(
        'id' => 2,
        'title' => 'Berita 2',
        'excerpt' => 'Deskripsi berita 2',
        'content' => 'Konten lengkap berita 2 - Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        'image_url' => 'assets/image/berita2.jpg',
        'category' => 'Pengumuman',
        'author' => 'Staff',
        'created_at' => '2024-03-20'
    ),
    array(
        'id' => 3,
        'title' => 'Berita 3',
        'excerpt' => 'Deskripsi berita 3',
        'content' => 'Konten lengkap berita 3 - Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        'image_url' => 'assets/image/berita3.jpg',
        'category' => 'Umum',
        'author' => 'Admin',
        'created_at' => '2024-03-19'
    )
);

// Get specific news article if ID is provided
$selectedNews = null;
if (isset($_GET['id'])) {
    foreach ($newsData as $news) {
        if ($news['id'] == $_GET['id']) {
            $selectedNews = $news;
            break;
        }
    }
}
?>
<?php if ($selectedNews): ?>
<!-- Single News Article View -->
<section class="news-detail">
    <div class="container">
        <nav class="breadcrumb">
            <a href="index.php">Beranda</a> &gt; 
            <a href="berita.php">Berita</a> &gt; 
            <?php echo htmlspecialchars($selectedNews['title']); ?>
        </nav>
        
        <article class="news-content">
            <h1><?php echo htmlspecialchars($selectedNews['title']); ?></h1>
            
            <div class="meta-info">
                <span><i class="far fa-calendar"></i> <?php echo date('d M Y', strtotime($selectedNews['created_at'])); ?></span>
                <span><i class="far fa-user"></i> <?php echo htmlspecialchars($selectedNews['author']); ?></span>
                <span><i class="far fa-folder"></i> <?php echo htmlspecialchars($selectedNews['category']); ?></span>
            </div>
            
            <div class="featured-image">
                <img src="<?php echo htmlspecialchars($selectedNews['image_url']); ?>" 
                     alt="<?php echo htmlspecialchars($selectedNews['title']); ?>">
            </div>
            
            <div class="article-content">
                <?php echo nl2br(htmlspecialchars($selectedNews['content'])); ?>
            </div>
            
            <div class="share-buttons">
                <h4>Bagikan:</h4>
                <a href="#" class="btn btn-social facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="btn btn-social twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" class="btn btn-social whatsapp"><i class="fab fa-whatsapp"></i></a>
            </div>
        </article>
    </div>
</section>

<?php else: ?>
<!-- News Archive/List View -->
<section class="news-archive">
    <div class="container">
        <div class="page-header">
            <h1>Berita Terkini</h1>
        </div>
        
        <div class="filter-section">
            <form action="" method="get" class="news-filter">
                <select name="category" class="form-control">
                    <option value="">Semua Kategori</option>
                    <option value="Umum">Umum</option>
                    <option value="Pengumuman">Pengumuman</option>
                </select>
                <input type="text" name="search" class="form-control" placeholder="Cari berita...">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
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
                    <p><?php echo htmlspecialchars($news['content']); ?></p>
                    <a href="berita.php?id=<?php echo $news['id']; ?>" class="btn btn-outline">Baca selengkapnya</a>
                </div>
            </article>
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