<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

$pageTitle = "Manajemen Pengumuman - Kelurahan Jatiwangi";
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
                    $query = "INSERT INTO announcements (title, content, status, start_date, end_date, created_by) 
                             VALUES (:title, :content, :status, :start_date, :end_date, :created_by)";
                    $stmt = $db->prepare($query);
                    $stmt->execute([
                        ':title' => $_POST['title'],
                        ':content' => $_POST['content'],
                        ':status' => $_POST['status'],
                        ':start_date' => $_POST['start_date'],
                        ':end_date' => $_POST['end_date'],
                        ':created_by' => $_SESSION['admin_id']
                    ]);
                    break;

                case 'edit':
                    $query = "UPDATE announcements SET 
                             title = :title, 
                             content = :content,
                             status = :status,
                             start_date = :start_date,
                             end_date = :end_date,
                             updated_at = NOW()
                             WHERE id = :id";
                    $stmt = $db->prepare($query);
                    $stmt->execute([
                        ':title' => $_POST['title'],
                        ':content' => $_POST['content'],
                        ':status' => $_POST['status'],
                        ':start_date' => $_POST['start_date'],
                        ':end_date' => $_POST['end_date'],
                        ':id' => $_POST['id']
                    ]);
                    break;

                case 'delete':
                    $query = "DELETE FROM announcements WHERE id = :id";
                    $stmt = $db->prepare($query);
                    $stmt->execute([':id' => $_POST['id']]);
                    break;
            }
        }
    }

    // Fetch announcements with pagination
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    $query = "SELECT * FROM announcements ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $announcements = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $countQuery = "SELECT COUNT(*) FROM announcements";
    $totalAnnouncements = $db->query($countQuery)->fetchColumn();
    $totalPages = ceil($totalAnnouncements / $limit);

} catch (Exception $e) {
    error_log($e->getMessage());
    $announcements = [];
    $totalPages = 0;
}
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manajemen Pengumuman</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAnnouncementModal">
            <i class="fas fa-plus"></i> Tambah Pengumuman
        </button>
    </div>

    <!-- Announcements List -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="announcementsTable">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Status</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Berakhir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($announcements as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['title']); ?></td>
                            <td>
                                <span class="badge bg-<?php echo $item['status'] == 'active' ? 'success' : 'warning'; ?>">
                                    <?php echo ucfirst($item['status']); ?>
                                </span>
                            </td>
                            <td><?php echo date('d/m/Y', strtotime($item['start_date'])); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($item['end_date'])); ?></td>
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

<!-- Add Announcement Modal -->
<div class="modal fade" id="addAnnouncementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pengumuman Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST">
                <input type="hidden" name="action" value="add">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Isi Pengumuman</label>
                        <textarea class="form-control" id="content" name="content" rows="6" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="active">Aktif</option>
                            <option value="draft">Draft</option>
                            <option value="archived">Arsip</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">Tanggal Berakhir</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>
                        </div>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#announcementsTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        }
    });

    $('.edit-btn').click(function() {
        const id = $(this).data('id');
        // Add AJAX call to fetch and populate data
        $('#editAnnouncementModal').modal('show');
    });

    $('.delete-btn').click(function() {
        if (confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')) {
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