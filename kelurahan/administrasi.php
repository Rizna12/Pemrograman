<?php
$pageTitle = "Pelayanan Administrasi - Kelurahan Jatiwangi";
require_once 'includes/header.php';

$jenis_dokumen = array(
    'surat_domisili' => 'Surat Keterangan Domisili',
    'surat_kelahiran' => 'Surat Keterangan Kelahiran',
    'surat_kematian' => 'Surat Keterangan Kematian',
    'surat_pindah' => 'Surat Keterangan Pindah',
    'surat_usaha' => 'Surat Keterangan Usaha',
    'surat_tidak_mampu' => 'Surat Keterangan Tidak Mampu',
    'surat_pengantar_nikah' => 'Surat Pengantar Nikah',
    'legalisir' => 'Legalisir Dokumen'
);

$persyaratan = array(
    'surat_domisili' => ['KTP', 'KK', 'Surat Pengantar RT/RW'],
    'surat_kelahiran' => ['KTP Orang Tua', 'KK', 'Surat Keterangan Lahir dari Bidan/RS'],
    'surat_kematian' => ['KTP Almarhum', 'KK', 'Surat Keterangan dari RS/Dokter'],
    'surat_pindah' => ['KTP', 'KK', 'Surat Pengantar RT/RW'],
    'surat_usaha' => ['KTP', 'KK', 'Foto Lokasi Usaha'],
    'surat_tidak_mampu' => ['KTP', 'KK', 'Surat Pengantar RT/RW'],
    'surat_pengantar_nikah' => ['KTP', 'KK', 'Foto 4x6'],
    'legalisir' => ['Dokumen Asli', 'KTP']
);
?>

<section class="page-header bg-light">
    <div class="container">
        <h1><i class="fas fa-file-alt"></i> Pelayanan Administrasi</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                <li class="breadcrumb-item active">Pelayanan Administrasi</li>
            </ol>
        </nav>
    </div>
</section>

<section class="service-steps">
    <div class="container">
        <div class="steps">
            <div class="step">
                <span class="step-number">1</span>
                <h3>Pilih Layanan</h3>
                <p>Pilih jenis dokumen yang ingin diurus</p>
            </div>
            <div class="step">
                <span class="step-number">2</span>
                <h3>Upload Berkas</h3>
                <p>Unggah dokumen persyaratan</p>
            </div>
            <div class="step">
                <span class="step-number">3</span>
                <h3>Verifikasi</h3>
                <p>Proses verifikasi oleh admin</p>
            </div>
            <div class="step">
                <span class="step-number">4</span>
                <h3>Selesai</h3>
                <p>Ambil dokumen di kantor kelurahan</p>
            </div>
        </div>
    </div>
</section>

<section class="document-requirements">
    <div class="container">
        <div class="requirements-wrapper">
            <h2>Persyaratan Dokumen</h2>
            <div class="accordion" id="requirementsAccordion">
                <?php foreach($jenis_dokumen as $key => $value): ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading<?php echo $key; ?>">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                data-bs-target="#collapse<?php echo $key; ?>">
                            <?php echo $value; ?>
                        </button>
                    </h2>
                    <div id="collapse<?php echo $key; ?>" class="accordion-collapse collapse" 
                         data-bs-parent="#requirementsAccordion">
                        <div class="accordion-body">
                            <ul class="requirements-list">
                                <?php foreach($persyaratan[$key] as $req): ?>
                                    <li><i class="fas fa-check-circle"></i> <?php echo $req; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<section class="document-form">
    <div class="container">
        <div class="form-wrapper">
            <h2>Form Pengajuan Dokumen</h2>
            <form action="process_dokumen.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="nik" name="nik" pattern="[0-9]{16}" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="jenis_dokumen" class="form-label">Jenis Dokumen</label>
                    <select class="form-control" id="jenis_dokumen" name="jenis_dokumen" required>
                        <option value="">Pilih Jenis Dokumen</option>
                        <?php foreach($jenis_dokumen as $key => $value): ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="keperluan" class="form-label">Keperluan</label>
                    <textarea class="form-control" id="keperluan" name="keperluan" rows="3" required></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nomor_hp" class="form-label">Nomor HP</label>
                            <input type="tel" class="form-control" id="nomor_hp" name="nomor_hp" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                    </div>
                </div>

                <div class="document-upload">
                    <h3>Upload Berkas</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="berkas_ktp" class="form-label">KTP</label>
                                <input type="file" class="form-control" id="berkas_ktp" name="berkas_ktp" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="berkas_kk" class="form-label">Kartu Keluarga</label>
                                <input type="file" class="form-control" id="berkas_kk" name="berkas_kk" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="berkas_pendukung" class="form-label">Berkas Pendukung Lainnya</label>
                        <input type="file" class="form-control" id="berkas_pendukung" name="berkas_pendukung">
                        <small class="text-muted">Format: PDF, JPG, PNG (max 2MB)</small>
                    </div>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="agreement" required>
                    <label class="form-check-label" for="agreement">
                        Saya menyatakan bahwa data yang saya masukkan adalah benar
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">Submit Pengajuan</button>
            </form>
        </div>
    </div>
</section>

<script>
document.getElementById('jenis_dokumen').addEventListener('change', function() {
    const selectedDoc = this.value;
    const requirements = <?php echo json_encode($persyaratan); ?>;
    const reqList = requirements[selectedDoc];
    
    // Update required documents list
    const reqContainer = document.querySelector('.document-upload');
    // Add logic to show/hide specific upload fields based on document type
});

// Form validation
(function () {
    'use strict'
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();
</script>

<?php require_once 'includes/footer.php'; ?>