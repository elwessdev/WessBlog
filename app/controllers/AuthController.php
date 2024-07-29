<?php
class AuthController {
    private $userModel;
    public function __construct($userModel) {
        $this->userModel = $userModel;
    }
    // Handle user login
    public function login() {
        checkLogin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            function validate($data){
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
            $email = validate($_POST['email']);
            $password = validate($_POST['password']);
            if (empty($email)) {
                echo "<p class='error_msg'>Email is required</p>";
            } else if (empty($password)) {
                echo "<p class='error_msg'>Password is required</p>";
            } 
            // Get user Data with Email
            $user = $this->userModel->getUserByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header('Location: /blog/public/?action=profile');
            } else {
                echo "Invalid username or password";
                include '../app/views/auth/login.php';
            }
        } else {
            include '../app/views/auth/login.php';
        }
    }
    // Handle user registration
    public function register() {
        checkLogin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];
            if ($password !== $confirmPassword) {
                echo "Passwords do not match!";
                return;
            }
            if($this->userModel->userExist($email,$username)){
                echo "The user already exist";
            } else {
                $profile_photo = "https://api.dicebear.com/9.x/thumbs/svg?seed=$username";
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $result = $this->userModel->createUser($username,$email,$hashedPassword,$profile_photo);
                if ($result) {
                    header('Location: /blog/public/?action=login');
                } else {
                    echo "Registration failed, Please Try again :)";
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