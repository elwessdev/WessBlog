<?php
session_start([
    'cookie_secure' => true,
    'cookie_httponly' => true,
    'use_strict_mode' => true,
    'use_cookies' => true,
    'use_only_cookies' => true,
    'cache_limiter' => 'nocache'
]);
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
// Env File
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$userModel = new User($db);
$authController = new authController($userModel);
$userController = new UserController($userModel);
$postModel = new Post($db);
$homeController = new HomeController($postModel);
$PostController = new PostController($postModel);

// Remember me
if (!isset($_SESSION["user_id"])&&(isset($_COOKIE['user_id'])&&isset($_COOKIE['user_name'])&&isset($_COOKIE['user_photo']))) {
    function decrypt_cookie($value, $key) {
        $cipher = 'AES-128-CTR'; // Cipher method
        list($encrypted_data, $iv) = explode('::', base64_decode($value), 2);
        return openssl_decrypt($encrypted_data, $cipher, $key, 0, $iv);
    }
    $decrypt = decrypt_cookie($_COOKIE['user_id'],$_ENV["ENCRYPTION_KEY"]);
    $_SESSION['user_id'] = $decrypt;
    $_SESSION['user_name'] = $_COOKIE['user_name'];
    $_SESSION['user_photo'] = $_COOKIE['user_photo'];
} 
// else {
//     setcookie('user_id', '', time() - 3600, '/');
//     setcookie('user_name', '', time() - 3600, '/');
//     setcookie('user_photo', '', time() - 3600, '/');
// }


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
    // case 'google-callback':
    //     $authController->loginWithGoogle();
    //     break;
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