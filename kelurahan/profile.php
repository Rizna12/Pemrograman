<?php
// profil.php
$pageTitle = "Profil Kelurahan - Kelurahan Jatiwangi";
require_once 'includes/header.php';
require_once 'config/database.php';

// Data struktur menggunakan array
$visiMisi = [
    'visi' => 'Mewujudkan Pelayanan Terbaik Kepada Masyarakat Dan Peningkatan Manajemen Pelayanan Prima Dan Pembangunan Partisipatif',
    'misi' => [
        'Meningkatkan Kapabilitas dan Kompetensi Aparatur',
        'Memberikan Pelayanan Prima Kepada Masyarakat',
        'Penguatan Kelembagaan Organisasi Kemasyarakatan',
        'Meningkatkan Peran Serta Masyarakat Dalam Pembangunan'
    ]
];

// Contoh data pegawai menggunakan array
$strukturPegawai = [
    'Lurah' => [
        [
            'nama' => 'Jumardin, S.Sos.',
            'nip' => '19791010 200701 1 018',
            'pangkat' => 'Penata / III-c',
            'foto' => 'assets/image/lurah.png'
        ]
    ],
    'Sekretaris' => [
        [
            'nama' => 'SARIFUDIN,SH',
            'nip' => '19500509 280632 1 002',
            'pangkat' => 'Penata Muda / III-a',
            'foto' => 'assets/image/berita1.jpg'
        ]
    ],
    'Kepala Seksi' => [
        [
            'title' => 'KASI PEMERINTAHAN',
            'nama' => 'ULLY ANDRIYANI,ST',
            'nip' => '19810709 20004 2 025',
            'pangkat' => 'Penata Muda / III-a',
            'foto' => 'assets/image/berita1.jpg'
        ],
        [
            'title' => 'KASI PEMBAGUNAN',
            'nama' => 'SRYWAHYUNINGSIH,SH',
            'nip' => '19800413 200604 2 026',
            'pangkat' => 'Penata Muda / III-a',
            'foto' => 'assets/image/berita1.jpg'
        ],
        [
            'title' => 'KASI EKONOMI',
            'nama' => 'HJ.FARIDAH,SE',
            'nip' => '19810709 20004 2 027',
            'pangkat' => 'Penata Muda / III-a',
            'foto' => 'assets/image/berita1.jpg'
        ]
    ],
    'Staf' => [
        [
            'nama' => 'M.SALAHUDDIN',
            'nip' => '19661231 200604 2 023',
            'pangkat' => 'Penata Muda / III-a',
            'foto' => 'assets/image/berita1.jpg'
        ],
        [
            'nama' => 'M.SALEH',
            'nip' => '19750705 200701 1 027',
            'pangkat' => 'Penata Muda / III-a',
            'foto' => 'assets/image/berita1.jpg'
        ] 
    ]
];
?>

<!-- Visi & Misi Section -->
<section class="visi-misi">
    <div class="container">
        <h2 class="section-title">Visi & Misi</h2>
        <div class="visi-misi-content">
            <div class="visi-box">
                <h3>Visi</h3>
                <p><?php echo htmlspecialchars($visiMisi['visi']); ?></p>
            </div>
            <div class="misi-box">
                <h3>Misi</h3>
                <ul>
                    <?php foreach($visiMisi['misi'] as $misi): ?>
                        <li><?php echo htmlspecialchars($misi); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Struktur Organisasi Section -->
<section class="struktur-organisasi">
    <div class="container">
        <h2 class="section-title">Struktur Organisasi</h2>
        <div class="org-chart">
            <?php foreach($strukturPegawai as $jabatan => $pegawaiList): ?>
            <div class="org-level">
                <h3 class="jabatan-title"><?php echo htmlspecialchars($jabatan); ?></h3>
                <div class="pegawai-cards">
                    <?php foreach($pegawaiList as $pegawai): ?>
                    <div class="pegawai-card">
                        <div class="pegawai-photo">
                            <img src="<?php echo htmlspecialchars($pegawai['foto']); ?>" 
                                 alt="<?php echo htmlspecialchars($pegawai['nama']); ?>"
                                 loading="lazy">
                        </div>
                        <div class="pegawai-info">
                            <h4><?php echo htmlspecialchars($pegawai['nama']); ?></h4>
                            <p class="nip">NIP: <?php echo htmlspecialchars($pegawai['nip']); ?></p>
                            <p class="pangkat"><?php echo htmlspecialchars($pegawai['pangkat']); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>