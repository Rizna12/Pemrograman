<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

$pageTitle = "Manajemen Layanan - Kelurahan Jatiwangi";
require_once 'admin-header.php';
require_once '../config/database.php';

try {
    $database = new Database();
    $db = $database->getConnection();

    // Handle form submissions
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'update_status':
                    $query = "UPDATE service_requests 
                             SET status = :status, 
                                 notes = :notes,
                                 updated_at = NOW(),
                                 handled_by = :admin_id
                             WHERE id = :id";
                    $stmt = $db->prepare($query);
                    $stmt->execute([
                        ':status' => $_POST['status'],
                        ':notes' => $_POST['notes'],
                        ':admin_id' => $_SESSION['admin_id'],
                        ':id' => $_POST['id']
                    ]);
                    break;
            }
        }
    }

    // Fetch service requests with pagination
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    $query = "SELECT sr.*, u.name as requester_name 
              FROM service_requests sr 
              LEFT JOIN users u ON sr.user_id = u.id 
              ORDER BY sr.created_at DESC 
              LIMIT :limit OFFSET :offset";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $countQuery = "SELECT COUNT(*) FROM service_requests";
    $totalServices = $db->query($countQuery)->fetchColumn();
    $totalPages = ceil($totalServices / $limit);

} catch (Exception $e) {
    error_log($e->getMessage());
    $services = [];
    $totalPages = 0;
}
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manajemen Layanan</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="exportToExcel()">
                    <i class="fas fa-download"></i> Export Excel
                </button>
            </div>
        </div>
    </div>

    <!-- Service Requests List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Permintaan Layanan</h6>
                </div>
                <div class="col-auto">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown">
                            Filter Status
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                            <li><a class="dropdown-item" href="?status=all">Semua</a></li>
                            <li><a class="dropdown-item" href="?status=pending">Pending</a></li>
                            <li><a class="dropdown-item" href="?status=processing">Diproses</a></li>
                            <li><a class="dropdown-item" href="?status=completed">Selesai</a></li>
                            <li><a class="dropdown-item" href="?status=rejected">Ditolak</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="servicesTable">
                    <thead>
                        <tr>
                            <th>No. Layanan</th>
                            <th>Pemohon</th>
                            <th>Jenis Layanan</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                            </tr>
                    </thead>
                    <tbody>
                        <?php foreach($services as $service): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($service['service_number']); ?></td>
                            <td><?php echo htmlspecialchars($service['requester_name']); ?></td>
                            <td><?php echo htmlspecialchars($service['service_type']); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($service['created_at'])); ?></td>
                            <td>
                                <span class="badge bg-<?php 
                                    echo $service['status'] === 'pending' ? 'warning' : 
                                        ($service['status'] === 'processing' ? 'info' : 
                                        ($service['status'] === 'completed' ? 'success' : 'danger')); 
                                ?>">
                                    <?php echo ucfirst($service['status']); ?>
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info view-btn" data-id="<?php echo $service['id']; ?>">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-primary process-btn" data-id="<?php echo $service['id']; ?>">
                                    <i class="fas fa-cog"></i>
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

<!-- View Service Modal -->
<div class="modal fade" id="viewServiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Layanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="service-details">
                    <!-- Will be populated by JavaScript -->
                </div>
                <div class="service-documents mt-4">
                    <h6>Dokumen Pendukung</h6>
                    <div class="document-list">
                        <!-- Will be populated by JavaScript -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Process Service Modal -->
<div class="modal fade" id="processServiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Proses Layanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST">
                <input type="hidden" name="action" value="update_status">
                <input type="hidden" name="id" id="service-id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="pending">Pending</option>
                            <option value="processing">Sedang Diproses</option>
                            <option value="completed">Selesai</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
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
    const servicesTable = $('#servicesTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        },
        "order": [[3, "desc"]]
    });

    // View Service Details
    $('.view-btn').click(function() {
        const id = $(this).data('id');
        // Add AJAX call to fetch service details
        $.ajax({
            url: 'ajax/get_service_details.php',
            type: 'GET',
            data: { id: id },
            success: function(response) {
                $('.service-details').html(response.details);
                $('.document-list').html(response.documents);
                $('#viewServiceModal').modal('show');
            }
        });
    });

    // Process Service
    $('.process-btn').click(function() {
        const id = $(this).data('id');
        $('#service-id').val(id);
        $('#processServiceModal').modal('show');
    });
});

function exportToExcel() {
    window.location.href = 'export/services_export.php';
}
</script>

<?php require_once 'admin-footer.php'; ?>