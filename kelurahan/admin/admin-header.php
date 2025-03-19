<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pageTitle = $pageTitle ?? 'Website Kelurahan'; 
require_once '../includes/protect.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link href="path/to/admin.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/layanan.css">
    <link rel="stylesheet" href="../assets/css/administrasi.css">
    <link rel="stylesheet" href="../assets/css/galeri.css">
    <link rel="stylesheet" href="../assets/css/agenda.css">
    <link rel="stylesheet" href="../assets/css/profile.css">
    <link rel="stylesheet" href="../assets/css/pengaduan.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <div class="header-top">
            <div class="logo">
                <img src="../assets/image/kb-logo.png" alt="Logo Kelurahan">
                <div>
                    <h1>Kelurahan Jatiwangi</h1>
                    <p>Kecamatan Asakota, Kota Bima</p>
                </div>
            </div>
            
        </div>
    </header>
    <main>