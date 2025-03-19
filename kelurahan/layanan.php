<?php
$pageTitle = "Layanan Online - Kelurahan Jatiwangi";
require_once 'includes/header.php';

$jenis_layanan = array(
    'surat_pengantar' => 'Surat Pengantar',
    'skck' => 'Surat Keterangan Catatan Kepolisian',
    'sktm' => 'Surat Keterangan Tidak Mampu',
    'skd' => 'Surat Keterangan Domisili',
    'sku' => 'Surat Keterangan Usaha',
    'akta_kelahiran' => 'Akta Kelahiran',
    'kk' => 'Kartu Keluarga'
);
?>

<!-- Page Header -->
<section class="page-header bg-light">
    <div class="container">
        <h1><i class="fas fa-file-alt"></i> Layanan Online</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                <li class="breadcrumb-item active">Layanan Online</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Service Info -->
<section class="service-info">
    <div class="container">
        <div class="info-cards">
            <div class="info-card">
                <i class="fas fa-clock"></i>
                <h3>Waktu Pelayanan</h3>
                <p>Senin - Jumat<br>08:00 - 15:00 WIB</p>
            </div>
            <div class="info-card">
                <i class="fas fa-phone-alt"></i>
                <h3>Kontak</h3>
                <p>Tel: (021) 1234567<br>WhatsApp: 0812-3456-7890</p>
            </div>
            <div class="info-card">
                <i class="fas fa-file-download"></i>
                <h3>Unduh Formulir</h3>
                <p>Download formulir pendukung<br>dalam format PDF</p>
            </div>
        </div>
    </div>
</section>

<!-- Service Form -->
<section class="service-form">
    <div class="container">
        <div class="form-wrapper">
            <h2>Form Pengajuan Layanan</h2>
            <form action="process_layanan.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>

                <div class="form-group">
                    <label for="nik">NIK</label>
                    <input type="text" class="form-control" id="nik" name="nik" pattern="[0-9]{16}" required>
                    <small class="form-text text-muted">Masukkan 16 digit NIK sesuai KTP</small>
                </div>

                <div class="form-group">
                    <label for="jenis_layanan">Jenis Layanan</label>
                    <select class="form-control" id="jenis_layanan" name="jenis_layanan" required>
                        <option value="">Pilih Jenis Layanan</option>
                        <?php foreach($jenis_layanan as $key => $value): ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi Keperluan</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                </div>

                <div class="form-group">
                    <label for="nomor_hp">Nomor HP</label>
                    <input type="tel" class="form-control" id="nomor_hp" name="nomor_hp" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="berkas">Upload Berkas Pendukung</label>
                    <input type="file" class="form-control" id="berkas" name="berkas" required>
                    <small class="form-text text-muted">Format file: PDF, JPG, PNG (max 2MB)</small>
                </div>

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="agreement" required>
                    <label class="form-check-label" for="agreement">
                        Saya menyatakan bahwa data yang saya masukkan adalah benar
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
            </form>
        </div>
    </div>
</section>

<!-- Service Status -->
<section class="service-status">
    <div class="container">
        <h2>Cek Status Pengajuan</h2>
        <div class="status-checker">
            <form action="cek_status.php" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Masukkan Nomor Pengajuan" name="nomor_pengajuan">
                    <button class="btn btn-primary" type="submit">Cek Status</button>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>