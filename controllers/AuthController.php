<?php
class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new AdminModel();
    }

    public function loginPage(): void
    {
        require_once 'views/login.php';
    }

    public function login(): void
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->userModel->getUserByUsername($username);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['admin'] = $user;
                header('Location: index.php?action=');
            } else {
                $errors[] = 'Invalid username or password';
                exit;
            }
        } else {
            $errors[] = 'Invalid username or password';
        }
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
        header('Location: index.php?action=');
        exit;
    }
}
