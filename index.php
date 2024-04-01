<?php
session_start();
require_once 'views/_nav.php';
require_once 'models/PostModel.php';
require_once 'models/AdminModel.php';
require_once 'connection.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/PostController.php';

$action = $_GET['action'] ?? null;
$page = $_GET['page'] ?? 1;

switch ($action) {
    case 'create':
        $controller = new PostController();
        $controller->create();
        break;
    case 'delete':
        $controller = new PostController();
        if(isset($_GET['id'])) {
            $postId = $_GET['id'];
            $controller->delete($postId);
        }
        break;
    case 'edit':
        $controller = new PostController();
        if(isset($_GET['id'])) {
            $postId = $_GET['id'];
            $controller->edit($postId);
        }
        break;
    case 'login':
        $controller = new AuthController();
        $controller->login();
        break;
    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;
    case 'view':
        $controller = new PostController();
        if(isset($_GET['id'])) {
            $postId = $_GET['id'];
            $controller->view($postId);
        }
        break;
    case 'loginPage':
        $controller = new AuthController();
        $controller->loginPage();
        break;
    default:
        $controller = new PostController();
        $controller->index($page);
        exit;
}
