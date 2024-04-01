<?php
class AdminModel
{
    private $connection;
    public function __construct()
    {
        global $connection;
        $this->connection = $connection;
    }

    public function getUserByUsername(string $username): array
    {
        $stmt = $this->connection->prepare("SELECT * FROM admins WHERE username = :username");
        $stmt->execute([':username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

