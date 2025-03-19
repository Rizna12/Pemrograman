<?php
// pengajuan-surat.php
require_once 'includes/db.php';
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jenis_surat = clean($_POST['jenis_surat']);
    $nama = clean($_POST['nama']);
    $nik = clean($_POST['nik']);
    $alamat = clean($_POST['alamat']);
    $keperluan = clean($_POST['keperluan']);
    
    // Generate nomor surat
    $tahun = date('Y');
    $bulan = date('m');
    $nomor_surat = generateNomorSurat($jenis_surat, $bulan, $tahun);
    
    $conn = connectDB();
    $stmt = $conn->prepare("INSERT INTO surat_keterangan (jenis_surat, nomor_surat, nama_pemohon, nik, alamat, keperluan) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $jenis_surat, $nomor_surat, $nama, $nik, $alamat, $keperluan);
    
    if ($stmt->execute()) {
        $success = "Pengajuan surat berhasil! Nomor surat: " . $nomor_surat;
    } else {
        $error = "Gagal mengajukan surat";
    }
}

function generateNomorSurat($jenis, $bulan, $tahun) {
    return sprintf("%s/%03d/%s/%s", $jenis, getLastNumber() + 1, $bulan, $tahun);
}

$pageTitle = "Pengajuan Surat Online - Kelurahan";
require_once 'includes/header.php';
?>

<div class="container">
    <h2>Pengajuan Surat Online</h2>
    
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form method="POST" class="form-pengajuan">
        <div class="form-group">
            <label>Jenis Surat</label>
            <select name="jenis_surat" required>
                <option value="">Pilih Jenis Surat</option>
                <option value="SKU">Surat Keterangan Usaha</option>
                <option value="SKTM">Surat Keterangan Tidak Mampu</option>
                <option value="SKD">Surat Keterangan Domisili</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" required>
        </div>
        
        <div class="form-group">
            <label>NIK</label>
            <input type="text" name="nik" minlength="16" maxlength="16" required>
        </div>
        
        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" required></textarea>
        </div>
        
        <div class="form-group">
            <label>Keperluan</label>
            <textarea name="keperluan" required></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Ajukan Surat</button>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>