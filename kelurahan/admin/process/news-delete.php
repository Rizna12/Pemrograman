<?php
// process/news-delete.php
session_start();
require_once '../../config/database.php';
require_once '../news-functions.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['news_id'])) {
    $database = new Database();
    $db = $database->getConnection();
    $newsManager = new NewsManager($db);
    
    if ($newsManager->deleteNews($_POST['news_id'])) {
        $_SESSION['success_message'] = "Berita berhasil dihapus!";
    } else {
        $_SESSION['error_message'] = "Gagal menghapus berita.";
    }
    
    header('Location: ../admin.php?section=news');
    exit();
}
?>