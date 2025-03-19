<?php
// news-functions.php
class NewsManager {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllNews() {
        try {
            $query = "SELECT * FROM news ORDER BY created_at DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching news: " . $e->getMessage());
            return false;
        }
    }

    public function addNews($title, $category, $content, $image, $author_id) {
        try {
            $query = "INSERT INTO news (title, category, content, image_url, author_id, created_at) 
                     VALUES (:title, :category, :content, :image_url, :author_id, NOW())";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':image_url', $image);
            $stmt->bindParam(':author_id', $author_id);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error adding news: " . $e->getMessage());
            return false;
        }
    }

    public function deleteNews($id) {
        try {
            // First get the image URL to delete the file
            $query = "SELECT image_url FROM news WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $news = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Delete the database record
            $query = "DELETE FROM news WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            
            if ($stmt->execute()) {
                // If database deletion successful, delete the image file
                if ($news && $news['image_url']) {
                    $image_path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/news/' . $news['image_url'];
                    if (file_exists($image_path)) {
                        unlink($image_path);
                    }
                }
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Error deleting news: " . $e->getMessage());
            return false;
        }
    }
}

?>