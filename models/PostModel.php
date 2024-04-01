<?php
class PostModel
{
    private $connection;

    public function __construct()
    {
        global $connection;
        $this->connection = $connection;
    }

    public function getPostById(int $postId): array
    {
        $stmt = $this->connection->prepare("SELECT * FROM posts WHERE id = :id");
        $stmt->execute([':id' => $postId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPostsByPage(int $page, int $perPage = 5): array
    {
        $offset = ($page - 1) * $perPage;

        $query = "SELECT p.*, a.username FROM posts AS p JOIN admins AS a ON p.admin_id = a.id ";
        $params = [];

        if (isset($_GET['action']) && $_GET['action'] === 'my_posts' && isset($_SESSION['admin'])) {
            $query .= " WHERE p.admin_id = :admin_id";
            $params[':admin_id'] = $_SESSION['admin']['id'];
        }

        $query .= " ORDER BY p.created_at DESC LIMIT :per_page OFFSET :offset";

        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(':per_page', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function createPost(string $title, string $text, int $adminId): void
    {
        $stmt = $this->connection->prepare("INSERT INTO posts (title, text, admin_id) VALUES (:title, :text, :adminId)");
        $stmt->execute([':title' => $title, ':text' => $text, ':adminId' => $adminId]);
    }

    public function deletePost(int $postId): void
    {
        $stmt = $this->connection->prepare("DELETE FROM posts WHERE id = :id AND admin_id = :admin_id");
        $stmt->execute([':id' => $postId, ':admin_id' => $_SESSION['admin']['id']]);
    }

    public function editPost(string $title, string $text, int $postId): void
    {
        $stmt = $this->connection->prepare("UPDATE posts SET title = :title, text = :text WHERE id = :id");
        $stmt->execute([':title' => $title, ':text' => $text, ':id' => $postId]);
    }

    public function getPostsCount()
    {
        $stmt = $this->connection->prepare("SELECT COUNT(id) FROM posts");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
