<?php
$pageTitle = "Kontak - Kelurahan Jatiwangi";
require_once 'includes/header.php';

// Contact information array
$contactInfo = array(
    'address' => 'Jl. Kelurahan Jatiwangi No. 123, Kota X',
    'phone' => '(021) 1234-5678',
    'whatsapp' => '+62 812-3456-7890',
    'email' => 'info@kelurahan-jatiwangi.go.id',
    'operating_hours' => 'Senin - Jumat: 08.00 - 16.00 WIB'
);

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
    
    // Here you would typically process the form data (e.g., send email, save to database)
    // For this example, we'll just set a success message
    $success_message = "Terima kasih! Pesan Anda telah terkirim.";
}
?>

<!-- Page Header -->
<section class="page-header bg-light">
    <div class="container">
        <h1>Hubungi Kami</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kontak</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Contact Information Section -->
<section class="contact-info py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="contact-details">
                    <h2>Informasi Kontak</h2>
                    <p>Silakan hubungi kami melalui informasi kontak di bawah ini atau mengisi formulir yang tersedia.</p>
                    
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h3>Alamat</h3>
                            <p><?php echo htmlspecialchars($contactInfo['address']); ?></p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <h3>Telepon</h3>
                            <p><?php echo htmlspecialchars($contactInfo['phone']); ?></p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <i class="fab fa-whatsapp"></i>
                        <div>
                            <h3>WhatsApp</h3>
                            <p><?php echo htmlspecialchars($contactInfo['whatsapp']); ?></p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h3>Email</h3>
                            <p><?php echo htmlspecialchars($contactInfo['email']); ?></p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <h3>Jam Operasional</h3>
                            <p><?php echo htmlspecialchars($contactInfo['operating_hours']); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="contact-form">
                    <h2>Kirim Pesan</h2>
                    <?php if (isset($success_message)): ?>
                        <div class="alert alert-success">
                            <?php echo htmlspecialchars($success_message); ?>
                        </div>
                    <?php endif; ?>

                    <form action="kontak.php" method="POST">
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="form-group">
                            <label for="subject">Subjek</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>

                        <div class="form-group">
                            <label for="message">Pesan</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="map-section">
    <div class="container">
        <div class="map-container">
            <!-- Replace the src with your actual Google Maps embed URL -->
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31573.862232850784!2d118.70922480618769!3d-8.427882010528178!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2db58bc03a0efa39%3A0x50afee6f4fcaaab8!2sKantor%20Kelurahan%20Jatiwangi!5e0!3m2!1sid!2sus!4v1735483143324!5m2!1sid!2sus"
                width="100%"
                height="450"
                style="border:0;"
                allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</section>

<!-- CSS styles -->
<style>
.contact-info {
    background-color: #fff;
}

.contact-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 2rem;
}

.contact-item i {
    font-size: 1.5rem;
    color: #007bff;
    margin-right: 1rem;
    width: 30px;
    text-align: center;
}

.contact-item h3 {
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
}

.contact-form {
    background: #f8f9fa;
    padding: 2rem;
    border-radius: 8px;
}

.form-group {
    margin-bottom: 1.5rem;
}

.map-container {
    margin: 2rem 0;
    border-radius: 8px;
    overflow: hidden;
}

.page-header {
    padding: 3rem 0;
    background-color: #f8f9fa;
    margin-bottom: 2rem;
}

.page-header h1 {
    margin-bottom: 1rem;
}

.breadcrumb {
    background: transparent;
    padding: 0;
}
</style>

<?php require_once 'includes/footer.php'; ?>