<?php
class UserController {
    private $userModel;
    private $isAdmin=false;
    public function __construct($userModel) {
        $this->userModel = $userModel;
    }
    // User Details
    public function user() {
        $this->isAdmin=false;
        $admin=$this->isAdmin;
        if (isset($_GET['action']) && $_GET['action'] === 'user' && isset($_GET['id'])) {
            $user = $this->userModel->getUserByID($_GET['id']);
            $posts = $this->userModel->getUserPostsByID($_GET['id']);
            $followingUsers = $this->userModel->followingUsers($_GET['id']);
            if(isset($_SESSION['user_id'])){
                $isFollow = $this->userModel->checkFollow($_SESSION["user_id"],$_GET['id']);
            }
            if ($user) {
                include '../app/views/user.php';
            } else {
                header("location: ../public/");
            }
        } else {
            http_response_code(400);
            echo "Invalid request";
        }
    }
    // My Profile Page
    public function myProfile() {
        $this->isAdmin=true;
        $admin=$this->isAdmin;
        $user = $this->userModel->getUserByID($_SESSION['user_id']);
        $posts = $this->userModel->getUserPostsByID($_SESSION['user_id']);
        $followingUsers = $this->userModel->followingUsers($_SESSION['user_id']);
        // echo $_SESSION['user_id'];
        include '../app/views/user.php';
    }
    // Settings Page
    public function settings() {
        // Get Previous Data
        $user = $this->userModel->getUserByID($_SESSION['user_id']);
        // Handle new data
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $prevPhoto = $_POST['prev-photo'];
            $username = $_POST['username'];
            $prevUsername = $_POST['prev-username'];
            $bio = $_POST['bio'];
            $prevBio = $_POST['prev-bio'];
            $email = $_POST['email'];
            $prevEmail = $_POST['prev-email'];
            $currentPassword = $_POST['current-password'];
            $newPassword = $_POST['new-password'];
            $confirmPassword = $_POST['confirm-password'];
            $errors = [];

            $userDetails = $this->userModel->getUserByEmail($prevEmail,$prevEmail);
            
            $changes = [
                'photo' => false,
                'username' => false,
                'bio' => false,
                'email' => false,
                'password' => false,
                'photoLink' => "",
                'photoID' => ""
            ];
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0){
                $deleteFile = deleteImage($prevPhoto);
                if ($deleteFile->error&&!empty($prevPhoto)) {
                    // echo "Error deleting file: " . $deleteFile->error->message;
                    array_push($errors,$deleteFile->error);
                } else {
                    $file = $_FILES['photo']['tmp_name'];
                    $resultUpload = uploadImage($file);
                    $img_url = $resultUpload->result->url;
                    $img_id = $resultUpload->result->fileId;
                    if(empty($img_url)){
                        array_push($errors,"There is problem in Changed Photo");
                    } else {
                        $changes["photo"]=true;
                        $changes["photoLink"]=$img_url;
                        $changes["photoID"]=$img_id;
                    }
                }
                
                // $uploadInfo = uploadImage($file);
                // if(!empty($up)){
                    
                // } else {
                //     array_push($errors,"There is problem in Changed Photo");
                //     echo "user photo changed"."<br>";
                // }
                // echo uploadImage($file)."<br>";
                // echo $_FILES["photo"]["name"]."<br>";
                // echo $file."<br>";
            }
            if($username!=$prevUsername){
                if($this->userModel->checkUsernameExist($username,$userDetails["id"])){
                    array_push($errors,"Username is exist");
                } else {
                    $changes["username"]=true;
                }
            }
            if(!empty($bio)&&$bio!=$prevBio){
                $changes["bio"]=true;
            }
            if(!empty($email)&&$email!=$prevEmail){
                if($this->userModel->checkEmailExist($email)){
                    array_push($errors,"Email is exist");
                } else {
                    $changes["email"]=true;
                }
            }
            if(!empty($currentPassword)){
                if(password_verify($currentPassword, $userDetails['password'])){
                    if(!empty($newPassword)&&!empty($confirmPassword)){
                        if($newPassword==$confirmPassword){
                            $changes["password"]=true;
                        } else {
                            array_push($errors, "You'r password confirm is wrong");
                        }
                    }
                } else {
                    array_push($errors,"You're password is wrong");
                }
            }
            if(!empty($errors)){
                include '../app/views/settings.php';
                exit();
            } else {
                if($changes["photo"]||$changes["username"]||$changes["bio"]||$changes["email"]||$changes["password"]){
                    // array_push($errors,"Data is valid i will changed");
                    if(!empty($changes["photoLink"])){
                        $this->userModel->changePhoto($changes["photoLink"],$changes["photoID"],$userDetails["id"]);
                        $_SESSION['user_photo'] = $this->userModel->getUserPhoto($userDetails["id"]);
                    }
                    if($changes["username"]){
                        $this->userModel->changeUsername($username,$userDetails["id"]);
                    }
                    if($changes["bio"]){
                        $this->userModel->changeBio($bio,$userDetails["id"]);
                    }
                    if($changes["email"]){
                        $this->userModel->changeEmail($email,$userDetails["id"]);
                    }
                    if($changes["password"]){
                        $pwd = password_hash($newPassword, PASSWORD_BCRYPT);
                        $this->userModel->changePassword($pwd,$userDetails["id"]);
                    }
                }
                header("Location: ?action=settings");
            }
        } else {
            include '../app/views/settings.php';
        }
    }
}
?>