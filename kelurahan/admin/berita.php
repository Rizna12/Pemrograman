<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

$pageTitle = "Manajemen Berita - Kelurahan Jatiwangi";
require_once 'admin-header.php';
require_once '../config/database.php';

try {
    $database = new Database();
    $db = $database->getConnection();

    // Handle form submissions
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'add':
                    // Handle file upload
                    $target_dir = "../assets/images/news/";
                    $image_url = '';
                    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
                        $target_file = $target_dir . basename($_FILES["image"]["name"]);
                        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                            $image_url = 'assets/images/news/' . basename($_FILES["image"]["name"]);
                        }
                    }

                    $query = "INSERT INTO news (title, excerpt, content, image_url, category, author, created_at) 
                             VALUES (:title, :excerpt, :content, :image_url, :category, :author, NOW())";
                    $stmt = $db->prepare($query);
                    $stmt->execute([
                        ':title' => $_POST['title'],
                        ':excerpt' => $_POST['excerpt'],
                        ':content' => $_POST['content'],
                        ':image_url' => $image_url,
                        ':category' => $_POST['category'],
                        ':author' => $_SESSION['admin_id']
                    ]);
                    break;

                case 'edit':
                    $query = "UPDATE news SET 
                             title = :title, 
                             excerpt = :excerpt,
                             content = :content,
                             category = :category,
                             updated_at = NOW()
                             WHERE id = :id";
                    $stmt = $db->prepare($query);
                    $stmt->execute([
                        ':title' => $_POST['title'],
                        ':excerpt' => $_POST['excerpt'],
                        ':content' => $_POST['content'],
                        ':category' => $_POST['category'],
                        ':id' => $_POST['id']
                    ]);
                    break;

                case 'delete':
                    $query = "DELETE FROM news WHERE id = :id";
                    $stmt = $db->prepare($query);
                    $stmt->execute([':id' => $_POST['id']]);
                    break;
            }
        }
    }

    // Fetch all news
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    $query = "SELECT * FROM news ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $news = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get total count for pagination
    $countQuery = "SELECT COUNT(*) FROM news";
    $totalNews = $db->query($countQuery)->fetchColumn();
    $totalPages = ceil($totalNews / $limit);

} catch (Exception $e) {
    error_log($e->getMessage());
    $news = [];
    $totalPages = 0;
}
?>

<!-- Main Content -->
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manajemen Berita</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNewsModal">
            <i class="fas fa-plus"></i> Tambah Berita
        </button>
    </div>

    <!-- News List -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="newsTable">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Excerpt</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($news as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['title']); ?></td>
                            <td><?php echo htmlspecialchars($item['category']); ?></td>
                            <td><?php echo htmlspecialchars(substr($item['excerpt'], 0, 100)) . '...'; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($item['created_at'])); ?></td>
                            <td><span class="badge bg-success">Published</span></td>
                            <td>
                                <button class="btn btn-sm btn-info edit-btn" data-id="<?php echo $item['id']; ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete-btn" data-id="<?php echo $item['id']; ?>">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php for($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- Add News Modal -->
<div class="modal fade" id="addNewsModal" tabindex="-1" aria-labelledby="addNewsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewsModalLabel">Tambah Berita Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Kategori</label>
                        <select class="form-control" id="category" name="category" required>
                            <option value="Umum">Umum</option>
                            <option value="Pengumuman">Pengumuman</option>
                            <option value="Event">Event</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="excerpt" class="form-label">Ringkasan</label>
                        <textarea class="form-control" id="excerpt" name="excerpt" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Konten</label>
                        <textarea class="form-control" id="content" name="content" rows="6" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit News Modal -->
<div class="modal fade" id="editNewsModal" tabindex="-1" aria-labelledby="editNewsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editNewsModalLabel">Edit Berita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" id="edit-id">
                <div class="modal-body">
                    <!-- Same form fields as Add Modal -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTable
    $('#newsTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        }
    });

    // Handle Edit Button Click
    $('.edit-btn').click(function() {
        const id = $(this).data('id');
        // Fetch news data and populate modal
        // Add your AJAX call here
        $('#editNewsModal').modal('show');
    });

    // Handle Delete Button Click
    $('.delete-btn').click(function() {
        if (confirm('Apakah Anda yakin ingin menghapus berita ini?')) {
            const id = $(this).data('id');
            const form = document.createElement('form');
            form.method = 'POST';
            form.innerHTML = `
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="${id}">
            `;
            document.body.append(form);
            form.submit();
        }
    });
});
</script>

<?php require_once 'admin-footer.php'; ?>