<?php
ini_set('session.cookie_secure', 1); // Only send cookies over HTTPS
ini_set('session.cookie_httponly', 1); // Prevent JavaScript access to session cookies
ini_set('session.cookie_samesite', 'Strict'); // Protect against CSRF attacks
session_start();
// Remember me
if (isset($_COOKIE['user_id'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    $_SESSION['user_name'] = $_COOKIE['user_name'];
    $_SESSION['user_photo'] = $_COOKIE['user_photo'];
}

require 'vendor/autoload.php';
require 'config/db.php';
require 'app/helpers/UploadImageHelper.php';
require 'app/helpers/SessionHelper.php';
// Models
require 'app/models/UserModel.php';
require 'app/models/PostModel.php';
// Controllers
require 'app/controllers/AuthController.php';
require 'app/controllers/HomeController.php';
require 'app/controllers/PostController.php';
require 'app/controllers/UserController.php';


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
    case 'home':
        $homeController->index();
        break;
    // Auth
    case 'login':
        checkLoginInside();
        $authController->login();
        break;
    case 'register':
        checkLoginInside();
        $authController->register();
        break;
    case 'forgot-password':
        checkLoginInside();
        $authController->forgotPassword();
        break;
    case 'reset-password':
        checkLoginInside();
        $authController->resetPassword();
        break;
    case 'logout':
        $authController->logout();
        break;
    // Post
    case 'post':
        $PostController->PostPage();
        break;
    case 'add-post':
        checkLoginOutSide();
        $PostController->handleNewPost();
        break;
    case 'topic':
        $PostController->topicPage();
        // include "app/views/topics.php";
        break;
    case 'search':
        $PostController->searchPage();
        break;
    case 'for-you':
        checkLoginOutSide();
        $PostController->ForYouPage();
        break;
    // User
    case 'user':
        $userController->user();
        break;
    case 'settings':
        checkLoginOutSide();
        $userController->settings();
        break;
    case 'my-profile':
        checkLoginOutSide();
        $userController->myProfile();
        break;
    case 'edit-post':
        checkLoginOutSide();
        $PostController->editPost();
        break;
    default:
        // http_response_code(404);
        // echo "Page not found";
        header("location: ?action=home");
}
?>