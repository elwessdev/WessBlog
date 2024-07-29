<?php
session_start();
require '../config/db.php';
// Models
require '../app/helpers/session_helper.php';
require '../app/models/UserModel.php';
require '../app/models/PostModel.php';
// Controllers
require '../app/controllers/AuthController.php';
require '../app/controllers/HomeController.php';
require '../app/controllers/PostController.php';
require '../app/controllers/UserController.php';

$userModel = new User($db);
$authController = new authController($userModel);
$userController = new UserController($userModel);

$postModel = new Post($db);
$homeController = new HomeController($postModel);
$PostController = new PostController($postModel);


$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? null;


// echo "action".$action."<br>";
// echo "id".$id."<br>";
// echo $_SESSION["user_id"];
// Route based on the path
switch ($action) {
    case '':
        $homeController->index();
        break;
    case 'login':
        $authController->login();
        break;
    case 'register':
        $authController->register();
        break;
    case 'logout':
        $authController->logout();
        break;
    case 'add-post':
        $PostController->handleNewPost();
        // include '../app/views/add-post.php';
        break;
    case 'profile':
        $userController->profile();
        break;
    case 'settings':
        include '../app/views/settings.php';
        break;
    case 'post':
        include '../app/views/post.php';
        break;
    default:
        http_response_code(404);
        echo "Page not found";
}
?>