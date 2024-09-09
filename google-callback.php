<?php
session_start();
require_once 'vendor/autoload.php';
require_once './config/db.php';
require_once './config/google.php';
require 'app/models/UserModel.php';
$userModel = new User($db);

// &&isset($_GET["action"])&&$_GET["action"]=="signin-with-google"

if(!isset($_SESSION["user_id"])){
  $errors=[];
  if(isset($_GET['code'])){
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    // login DATA
    $google_id = substr($google_account_info->id,0,10);
    $email = $google_account_info->email;
    $name = $google_account_info->name;
    $picture = $google_account_info->picture;
    
    // echo $google_id."<br>";
    // echo $email."<br>";
    // echo $name."<br>";
    // echo $picture."<br>";

    function loginSaved($id,$name,$picture){
      // Encryption Cookie
      function encrypt_cookie($value, $key) {
        $cipher = 'AES-128-CTR'; // Cipher method
        $iv_length = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($iv_length); // Generate a random initialization vector
        $encrypted = openssl_encrypt($value, $cipher, $key, 0, $iv);
        return base64_encode($encrypted . '::' . $iv); // Encode to base64 for storage
      }
      // Set Session
      $_SESSION['user_id'] = $id;
      $_SESSION['user_name'] = $name;
      $_SESSION['user_photo'] = $picture;
      // Set Cookie
      $cookie_time = time()+(24*60*60); // For 1 day
      setcookie('user_id', encrypt_cookie($id,$_ENV["ENCRYPTION_KEY"]), $cookie_time, '/', '', true, true);
      setcookie('user_name', $name, $cookie_time, '/', '', true, true);
      setcookie('user_photo', $picture, $cookie_time, '/', '', true, true);
      header('Location: ./?action=home');
    }
    // !$userModel->userExistByGoogle($google_id)
    if(!$userModel->checkEmailExist($email)){
      $result = $userModel->createUser($google_id,$name,$email,"",$picture,"google");
      if($result){
        loginSaved($google_id,$name,$picture);
      } else {
        array_push($errors,"There is a problem, Try again");
        include 'app/views/auth/Login.php';
        exit();
      }
    } else {
      // $userData = $userModel->getUserByID($google_id);
      $userData = $userModel->getUserByEmail($email);
      loginSaved($userData["id"],$userData["username"],$userData["photo"]);
    }
  } else {
    array_push($errors,"There is a problem, Try again");
    include 'app/views/auth/Login.php';
    exit();
  }
} else {
  header("location: ?action=login");
}

?>