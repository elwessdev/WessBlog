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
                include 'app/views/auth/Login.php';
                exit();
            } else {
                $user = $this->userModel->getUserByEmail($email);
                if ($user && password_verify($password, $user['password'])) {
                    // Set session variables
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['user_photo'] = $user['photo'];
                    header('Location: ./?action=home');
                } else {
                    array_push($errors,"Invalid username or password");
                    include 'app/views/auth/Login.php';
                    exit();
                }
            }
        } else {
            include 'app/views/auth/Login.php';
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

            if(!preg_match('/^[a-zA-Z0-9]+$/', $username)){
                array_push($errors,"Should username contains characters and numbers");
            } else {
                if($this->userModel->userNameExist($username)){
                    array_push($errors,"The username already exist");
                }
            }

            if(!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',$email)){
                array_push($errors,"Email is not valid");
            } else if($this->userModel->checkEmailExist($email)){
                array_push($errors,"Email is exist");
            }

            if ($password !== $confirmPassword) {
                array_push($errors,"Passwords do not match!");
                
            } else {
                if(!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/',$password)){
                    array_push($errors, "Password is weak (Minimum 6 characters, At least one uppercase letter/lowercase letter/one digit/one special character)");
                }
            }

            if(!empty($errors)){
                include 'app/views/auth/Register.php';
                exit();
            }else{
                $uid = rand(1000, 999999);
                $profile_photo = "https://api.dicebear.com/9.x/thumbs/svg?seed=$username";
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $result = $this->userModel->createUser($uid,$username,$email,$hashedPassword,$profile_photo);
                if ($result) {
                    header('Location: ?action=login');
                } else {
                    array_push($errors,"Registration failed, Please Try again");
                    include 'app/views/auth/Register.php';
                    exit();
                }
            }

        } else {
            include 'app/views/auth/Register.php';
        }
    }
    // Handle Reset password
    public function forgotPassword(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'&&$_GET["action"]=="forgot-password"){
            $email=$_POST["email"];
            $emailExist = $this->userModel->checkEmailExist($email);
            $errors = [];
            $done=false;
            if(!$emailExist){
                array_push($errors, "Email is not exist");
            }
            if(!empty($errors)){
                include 'app/views/auth/Forgot-password.php';
                exit();
            } else {
                // Prepare Token and expire date
                $token = bin2hex(random_bytes(16));
                $token_hash=hash("sha256",$token);
                date_default_timezone_set('UTC');
                $expiry=date("Y-m-d H:i:s",time()+60*30);
                $setToken = $this->userModel->TokenResetPassword($token_hash,$expiry,$email);
                if($setToken){
                    include "app/helpers/PHPMailer.php";
                    $mail->setFrom('noreply@wessblog.com',"WessBlog");
                    $mail->addAddress($email);
                    $mail->Subject="Reset Password";
                    $mail->Body = <<<END
                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="display: flex; padding: 15px; border: 1px solid rgba(204, 204, 204, 0.5411764706); border-radius: 5px; background-color: #eef5ff;">
                            <tr>
                                <td align="center" style="padding: 10px 20px;">
                                    <h1 style="font-size: 25px; color: #091651; margin: 0; font-weight: 500;">Password Reset</h1>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" style="padding: 0 20px 0 20px;">
                                    <p style="font-size: 17px; color: #8F9BAD; margin: 0; text-align: left;">Seems like you forgot your password for WessBlog. If this is true, click below to reset your password.</p>
                                    <p style="font-size: 17px; color: #8F9BAD; margin: 0; text-align: left;">The reset button is expire for 30 minutes</p>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" style="padding: 20px;">
                                    <a href="http://localhost/wessblog/?action=reset-password&token=$token" style="background-color: #5171ff; color: #ffffff; padding: 10px 30px; text-decoration: none; border-radius: 5px; display: inline-block; font-size: 16px;">Reset My Password</a>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" style="padding: 0 20px 40px 20px;">
                                    <p style="font-size: 17px; color: #8F9BAD; margin: 0; text-align: left;">If you did not forget your password you can safely ignore this email.</p>
                                </td>
                            </tr>
                        </table>
                    END;
                    try{
                        $mail->send();
                        $done=true;
                    } catch(Exception $error){
                        $done=false;
                        // echo "error ".$mail->ErrorInfo;
                    }
                    include 'app/views/auth/Forgot-password.php';
                }
            }
        } else {
            include 'app/views/auth/Forgot-password.php';
        }
    }
    // Handle Reset password
    public function resetPassword(){
        if($_GET["action"]=="reset-password"&&isset($_GET["token"])){
            $token=hash("sha256",$_GET["token"]);
            $user = $this->userModel->getTokenResetPassword($token);
            if(!$user){
                echo "<h3>Token not found, please try again</h3>";
                echo "<a href='?action=forgot-password'>Try again</a>";
                header("refresh:4;url=?action=forgot-password");
            } else{
                date_default_timezone_set('UTC');
                if(strtotime($user["token_expires_at"])<=time()){
                    echo "<h3>Token has expired, Please Try again</h3>";
                    echo "<a href='?action=forgot-password'>Try again</a>";
                    header("refresh:4;url=?action=forgot-password");
                    exit();
                } else {
                    // header("location: ?action=reset-password&token={$token}");
                    include "app/views/auth/Reset-password.php";
                }
            }
        }
        if($_GET["action"]=="reset-password"&&$_SERVER["REQUEST_METHOD"]=="POST"){
            // $token=hash("sha256",$_POST["token"]);
            $id=$_POST["user_id"];
            $pwd1=$_POST["pwd1"];
            $pwd2=$_POST["pwd2"];
            $errors=[];
            if ($pwd1 !== $pwd2) {
                array_push($errors,"Passwords do not match!");
            } else {
                if(!preg_match('/(?=.*[A-Za-z])(?=.*\d)/', $pwd1)){
                    // array_push($errors,$pwd1);
                    array_push($errors,"Password must contain both letters and numbers.");
                }
            }
            if(!empty($errors)){
                include "app/views/auth/Reset-password.php";
            } else {
                $hash_password = password_hash($pwd1, PASSWORD_DEFAULT);
                $changed = $this->userModel->resetSaveNewPassword($hash_password,$id);
                if($changed){
                    $done=true;
                    include "app/views/auth/Reset-password.php";
                }
            }
        }
    }
    // Handle user logout
    public function logout() {
        session_destroy();
        header('Location: ?action=login');
    }
}
?>