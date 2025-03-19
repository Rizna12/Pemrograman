<?php
// pengaduan.php
require_once 'includes/db.php';
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = clean($_POST['judul']);
    $isi = clean($_POST['isi']);
    $nama = clean($_POST['nama']);
    $email = clean($_POST['email']);
    $telepon = clean($_POST['telepon']);
    
    // Handle upload foto
    $foto = '';
    if (isset($_FILES['bukti']) && $_FILES['bukti']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png'];
        $filename = $_FILES['bukti']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $newname = uniqid() . '.' . $ext;
            if (move_uploaded_file($_FILES['bukti']['tmp_name'], 'uploads/pengaduan/' . $newname)) {
                $foto = $newname;
            }
        }
    }
    
    $conn = connectDB();
    $stmt = $conn->prepare("INSERT INTO pengaduan (judul, isi, nama_pengadu, email, telepon, bukti_foto) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $judul, $isi, $nama, $email, $telepon, $foto);
    
    if ($stmt->execute()) {
        $success = "Pengaduan berhasil dikirim!";
    } else {
        $error = "Gagal mengirim pengaduan";
    }
}

$pageTitle = "Pengaduan Masyarakat - Kelurahan";
require_once 'includes/header.php';
?>

<div class="containers">
    <h2>Form Pengaduan Masyarakat</h2>
    
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <form method="POST" enctype="multipart/form-data" class="form-pengaduan">
        <div class="form-group">
            <label>Judul Pengaduan</label>
            <input type="text" name="judul" required>
        </div>
        
        <div class="form-group">
            <label>Isi Pengaduan</label>
            <textarea name="isi" required></textarea>
        </div>
        
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" required>
        </div>
        
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email">
        </div>
        
        <div class="form-group">
            <label>Telepon</label>
            <input type="tel" name="telepon">
        </div>
        
        <div class="form-group">
            <label>Bukti Foto</label>
            <input type="file" name="bukti" accept="image/*">
        </div>
        
        <button type="submit" class="btn btn-primary">Kirim Pengaduan</button>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>