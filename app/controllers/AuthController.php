<?php
class AuthController {
    private $userModel;
    public function __construct($userModel) {
        $this->userModel = $userModel;
    }
    // Handle user login
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            function validate($data){
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
            $email = validate($_POST['email']);
            $password = validate($_POST['password']);
            $errors=[];
            if (empty($email)) {
                array_push($errors,"Username/Email is required");
            } else if (empty($password)) {
                array_push($errors,"Password is required");
            } 
            if(!empty($errors)){
                include '../app/views/auth/login.php';
                exit();
            } else {
                $user = $this->userModel->getUserByEmail($email);
                if ($user && password_verify($password, $user['password'])) {
                    // Set session variables
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['user_photo'] = $user['photo'];
                    header('Location: /blog/public/?action=profile');
                } else {
                    array_push($errors,"Invalid username or password");
                    include '../app/views/auth/login.php';
                    exit();
                }
            }
        } else {
            include '../app/views/auth/login.php';
        }
    }
    // Handle user registration
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];
            $errors = [];
            if (preg_match('/^\d+$/', $username)) {
                array_push($errors,"Username cannot be all numbers.");
            } else {
                if($this->userModel->userExist($email,$username)){
                    array_push($errors,"The user already exist UserName or Email");
                }
            }
            if ($password !== $confirmPassword) {
                array_push($errors,"Passwords do not match!");
                
            } else {
                if(!preg_match('/(?=.*[A-Za-z])(?=.*\d)/', $password)){
                    array_push($errors,$password);
                    array_push($errors,"Password must contain both letters and numbers.");
                }
            }
            if(!empty($errors)){
                include '../app/views/auth/register.php';
                exit();
            }else{
                $uid = rand(1000, 999999);
                $profile_photo = "https://api.dicebear.com/9.x/thumbs/svg?seed=$username";
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $result = $this->userModel->createUser($uid,$username,$email,$hashedPassword,$profile_photo);
                if ($result) {
                    header('Location: /blog/public/?action=login');
                } else {
                    array_push($errors,"Registration failed, Please Try again");
                    include '../app/views/auth/register.php';
                    exit();
                }
            }
        } else {
            include '../app/views/auth/register.php';
        }
    }
    // Handle user logout
    public function logout() {
        session_destroy();
        header('Location: /blog/public/?action=login');
    }
}
?>