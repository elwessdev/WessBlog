<?php
session_start();
require '../vendor/autoload.php';
require '../config/db.php';
require '../vendor/autoload.php';
require '../app/helpers/UploadImageHelper.php';
require '../app/helpers/SessionHelper.php';
// Models
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

// echo $id."<br>";


// echo "action".$action."<br>";
// echo "id".$id."<br>";
// echo $_SESSION["user_id"];
// Route based on the path
switch ($action) {
    case '':
        $homeController->index();
        break;
    // Auth
    case 'login':
        $authController->login();
        break;
    case 'register':
        $authController->register();
        break;
    case 'logout':
        $authController->logout();
        break;
    // Post
    case 'post':
        $PostController->PostPage();
        break;
    case 'add-post':
        $PostController->handleNewPost();
        break;
    case 'topic':
        $PostController->topicPage();
        // include "../app/views/topics.php";
        break;
    // User
    case 'user':
        $userController->user();
        break;
    case 'settings':
        $userController->settings();
        break;
    case 'my-profile':
        $userController->myProfile();
        break;
    default:
        // http_response_code(404);
        // echo "Page not found";
        header("location: ../public/");
}
?>