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
            include '../app/views/auth/Login.php';
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
            include '../app/views/auth/Register.php';
        }
    }
    // Handle Reset password
    public function forgotPassword(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'&&$_GET["action"]=="forgot-password"){
            $email=$_POST["email"];
            $emailExist = $this->userModel->checkEmailExist($email);
            $errors = [];
            if(!$emailExist){
                array_push($errors, "Email is not exist");
            }
            if(!empty($errors)){
                include '../app/views/Forgot-password.php';
                exit();
            } else {
                // Prepare Token and expire date
                $token = bin2hex(random_bytes(16));
                $token_hash=hash("sha256",$token);
                $expiry=date("y-m-d h:i:s",time()+60*30);
                $setToken = $this->userModel->ResetTokenPassword($token_hash,$expiry,$email);
                if($setToken){
                    include "../app/helpers/PHPMailer.php";
                    $mail->setFrom("noreply@WessBlog.com");
                    $mail->addAddress($email);
                    $mail->Subject="Password Reset";
                    $mail->Body = <<<END
                        Click <a href="http://localhost/blog/public/?action=reset-password&token=$token">HERE</a> to reset you password
                    END;
                    try{
                        $mail->send();
                    } catch(Exception $error){
                        echo "error ".$mail->ErrorInfo;
                    }
                }
                echo "Message sent, please check your inbox";
            }
        } else {
            include '../app/views/Forgot-password.php';
        }
    }
    // Handle Reset password
    public function resetPassword(){
        if($_GET["action"]=="reset-password"&&isset($_GET["token"])){
            $token=hash("sha256",$_GET["token"]);
            $user = $this->userModel->getTokenResetPassword($token);
            if(!$user){
                die("Token not found, please try again");
                // header("refresh:2;url=?action=reset-password");
            } else{
                if(strtotime($user["token_expires_at"])<=time()){
                    echo "Token has expired, Please Try again";
                    // header("refresh:2;url=?action=reset-password");
                    exit();
                } else {
                    // header("location: ?action=reset-password&token={$token}");
                    include "../app/views/reset-password.php";
                }
            }
        }
        if($_GET["action"]=="reset-password"&&isset($_GET["token"])&&$_SERVER["REQUEST_METHOD"]=="POST"){
            $token=hash("sha256",$_POST["token"]);
            $id=$_POST["user_id"];
            $pwd1=$_POST["pwd1"];
            $pwd2=$_POST["pwd2"];
            $error=[];
            if ($password !== $confirmPassword) {
                array_push($errors,"Passwords do not match!");
            } else {
                if(!preg_match('/(?=.*[A-Za-z])(?=.*\d)/', $password)){
                    array_push($errors,$password);
                    array_push($errors,"Password must contain both letters and numbers.");
                }
            }
            if(!empty($errors)){
                // foreach($errors as $err){
                //     echo $err."<br>";
                // }
                // include "../app/views/reset-password.php";
                die("dsqfsdf");
                header("location: ?action=reset-password&token={$token}");
            } else {
                $this->userModel->resetSaveNewPassword($pwd1,$id);
                header("location:?action=reset-password&token={$token}");
            }
        }
    }
    // Handle user logout
    public function logout() {
        session_destroy();
        header('Location: /blog/public/?action=login');
    }
}
?>