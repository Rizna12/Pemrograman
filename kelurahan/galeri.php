<?php
$pageTitle = "Galeri Kegiatan - Kelurahan Jatiwangi";
require_once 'includes/header.php';

// Sample gallery data
$galleryItems = array(
    array(
        'id' => 1,
        'title' => 'Kegiatan Posyandu',
        'description' => 'Kegiatan pemeriksaan kesehatan rutin',
        'image_url' => 'assets/image/berita1.jpg',
        'category' => 'Kesehatan',
        'event_date' => '2024-03-15'
    ),
    array(
        'id' => 1,
        'title' => 'Kegiatan Posyandu',
        'description' => 'Kegiatan pemeriksaan kesehatan rutin',
        'image_url' => 'assets/image/berita1.jpg',
        'category' => 'Kesehatan',
        'event_date' => '2024-03-15'
    ),
    array(
        'id' => 1,
        'title' => 'Kegiatan Posyandu',
        'description' => 'Kegiatan pemeriksaan kesehatan rutin',
        'image_url' => 'assets/image/berita1.jpg',
        'category' => 'Kesehatan',
        'event_date' => '2024-03-15'
    ),
    array(
        'id' => 1,
        'title' => 'Kegiatan Posyandu',
        'description' => 'Kegiatan pemeriksaan kesehatan rutin',
        'image_url' => 'assets/image/berita1.jpg',
        'category' => 'Kesehatan',
        'event_date' => '2024-03-15'
    ),
    array(
        'id' => 1,
        'title' => 'Kerja bakti sosial',
        'description' => 'Kegiatan pemeriksaan kesehatan rutin',
        'image_url' => 'assets/image/berita1.jpg',
        'category' => 'Kesehatan',
        'event_date' => '2024-03-15'
    ),
    array(
        'id' => 2,
        'title' => 'musyawarah bersama',
        'description' => 'Kegiatan bersih-bersih lingkungan',
        'image_url' => 'assets/image/berita1.jpg',
        'category' => 'Lingkungan',
        'event_date' => '2024-03-10'
    )
);

// Get unique categories for filter
$categories = array_unique(array_column($galleryItems, 'category'));
?>

<!-- Page Header -->
<section class="page-header bg-light">
    <div class="container">
        <h1><i class="fas fa-images"></i> Galeri Kegiatan</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                <li class="breadcrumb-item active">Galeri</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Gallery Filters -->
<section class="gallery-filters">
    <div class="container">
        <div class="filters-wrapper">
            <div class="filter-buttons">
                <button class="btn btn-primary active" data-filter="all">Semua</button>
                <?php foreach($categories as $category): ?>
                    <button class="btn btn-outline-primary" data-filter="<?php echo strtolower($category); ?>">
                        <?php echo htmlspecialchars($category); ?>
                    </button>
                <?php endforeach; ?>
            </div>
            <div class="search-box">
                <input type="text" id="gallerySearch" class="form-control" placeholder="Cari galeri...">
            </div>
        </div>
    </div>
</section>

<!-- Gallery Grid -->
<section class="gallery-grid">
    <div class="container">
        <div class="gallery-items">
            <?php foreach($galleryItems as $item): ?>
            <div class="gallery-item" data-category="<?php echo strtolower($item['category']); ?>">
                <div class="gallery-card">
                    <img src="<?php echo htmlspecialchars($item['image_url']); ?>" 
                         alt="<?php echo htmlspecialchars($item['title']); ?>"
                         loading="lazy">
                    <div class="gallery-info">
                        <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                        <p><?php echo htmlspecialchars($item['description']); ?></p>
                        <div class="gallery-meta">
                            <span class="category"><?php echo htmlspecialchars($item['category']); ?></span>
                            <span class="date"><?php echo date('d M Y', strtotime($item['event_date'])); ?></span>
                        </div>
                        <a href="#" class="btn btn-light btn-sm view-gallery" data-id="<?php echo $item['id']; ?>">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Gallery Modal -->
<div class="modal fade" id="galleryModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <img src="" alt="" class="img-fluid">
                <div class="gallery-details mt-3">
                    <p class="description"></p>
                    <div class="meta"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterButtons = document.querySelectorAll('.filter-buttons button');
    const galleryItems = document.querySelectorAll('.gallery-item');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            const filter = button.dataset.filter;
            
            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            
            galleryItems.forEach(item => {
                if (filter === 'all' || item.dataset.category === filter) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });

    // Search functionality
    const searchInput = document.getElementById('gallerySearch');
    searchInput.addEventListener('input', () => {
        const searchTerm = searchInput.value.toLowerCase();
        
        galleryItems.forEach(item => {
            const title = item.querySelector('h3').textContent.toLowerCase();
            const description = item.querySelector('p').textContent.toLowerCase();
            
            if (title.includes(searchTerm) || description.includes(searchTerm)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>