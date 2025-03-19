<?php 
session_start(); 
$pageTitle = $pageTitle ?? 'Website Kelurahan'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/layanan.css">
    <link rel="stylesheet" href="assets/css/administrasi.css">
    <link rel="stylesheet" href="assets/css/galeri.css">
    <link rel="stylesheet" href="assets/css/agenda.css">
    <link rel="stylesheet" href="assets/css/profile.css">
    <link rel="stylesheet" href="assets/css/pengaduan.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Tambahan CSS untuk menu responsif */
        .menu-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
            padding: 10px;
            position: absolute;
            right: 20px;
            top: 20px;
            z-index: 1000;
        }

        .menu-toggle span {
            display: block;
            width: 25px;
            height: 3px;
            background-color: #333;
            margin: 2px 0;
            transition: 0.4s;
        }

        /* Animasi hamburger ke X */
        .menu-toggle.active span:nth-child(1) {
            transform: rotate(-45deg) translate(-5px, 6px);
        }

        .menu-toggle.active span:nth-child(2) {
            opacity: 0;
        }

        .menu-toggle.active span:nth-child(3) {
            transform: rotate(45deg) translate(-5px, -6px);
        }

        @media screen and (max-width: 768px) {
            .menu-toggle {
                display: flex;
            }

            nav ul {
                display: none;
                width: 100%;
                position: absolute;
                top: 100%;
                left: 0;
                background:var(--primary-color) ;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                padding: 0;
            }

            nav.active ul {
                display: block;
            }

            nav ul li {
                display: block;
                width: 100%;
                text-align: left;
            }

            nav ul li a {
                padding: 15px 20px;
                display: block;
                border-bottom: 1px solid #eee;
            }

            /* Handling dropdowns in mobile view */
            nav ul li .dropdown {
                position: static;
                width: 100%;
                display: none;
                box-shadow: none;
                padding-left: 20px;
            }

            nav ul li:hover .dropdown {
                display: none; /* Prevent hover showing dropdown on mobile */
            }

            nav ul li.show-dropdown .dropdown {
                display: block;
            }

            .header-top {
                padding: 10px;
                position: relative;
            }

            .logo {
                flex-direction: column;
                text-align: center;
            }

            .logo img {
                margin-right: 0;
                margin-bottom: 10px;
            }

            .logo h1 {
                font-size: 1.5em;
            }

            .logo p {
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-top">
            <div class="logo">
                <img src="assets/image/kb-logo.png" alt="Logo Kelurahan">
                <div>
                    <h1>Kelurahan Jatiwangi</h1>
                    <p>Kecamatan Asakota, Kota Bima</p>
                </div>
            </div>
            <div class="menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Beranda</a></li>
                <li><a href="profile.php">Profil</a></li>
                <li><a href="#berita">Informasi</a>
                    <ul class="dropdown">
                        <li><a href="berita.php">Berita</a></li>
                        <li><a href="pengumuman.php">Pengumuman</a></li>
                    </ul>
                </li>
                <li><a href="galeri.php">Galeri</a></li>
                <li><a href="kontak.php">Kontak</a></li>
                <li><a href="../kelurahan/admin/login.php">Admin</a></li>
            </ul>
        </nav>
    </header>
    <main>

    <!-- Tambahkan script di bawah tag main -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle menu
            const menuToggle = document.querySelector('.menu-toggle');
            const nav = document.querySelector('nav');
            
            menuToggle.addEventListener('click', function() {
                nav.classList.toggle('active');
                menuToggle.classList.toggle('active');
            });

            // Handle dropdown clicks on mobile
            const dropdownParents = document.querySelectorAll('nav ul li');
            
            dropdownParents.forEach(parent => {
                if (parent.querySelector('.dropdown')) {
                    parent.addEventListener('click', function(e) {
                        if (window.innerWidth <= 768) {
                            e.preventDefault();
                            this.classList.toggle('show-dropdown');
                        }
                    });
                }
            });

            // Close menu when clicking outside
            document.addEventListener('click', function(e) {
                if (!nav.contains(e.target) && !menuToggle.contains(e.target)) {
                    nav.classList.remove('active');
                    menuToggle.classList.remove('active');
                }
            });
        });
    </script>