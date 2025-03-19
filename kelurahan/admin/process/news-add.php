<?php
// process/news-add.php
session_start();
require_once '../../config/database.php';
require_once '../news-functions.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $newsManager = new NewsManager($db);
    
    $title = $_POST['title'];
    $category = $_POST['category'];
    $content = $_POST['content'];
    $author_id = $_SESSION['admin_id'];
    
    // Handle file upload
    $image_url = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/news/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $new_filename = uniqid() . '.' . $file_extension;
        $upload_path = $upload_dir . $new_filename;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
            $image_url = $new_filename;
        }
    }
    
    if ($newsManager->addNews($title, $category, $content, $image_url, $author_id)) {
        $_SESSION['success_message'] = "Berita berhasil ditambahkan!";
    } else {
        $_SESSION['error_message'] = "Gagal menambahkan berita.";
    }
    
    header('Location: ../admin.php?section=news');
    exit();
}

?>