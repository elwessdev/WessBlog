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
            $result = $this->userModel->getUserByID($_GET['id']);
            $user = $result->fetch_assoc();
            $posts = $this->userModel->getUserPostsByID($_GET['id']);
            if ($user) {
                // $data = ['user' => $user];
                // extract($data);
                include '../app/views/user.php';
            } else {
                // http_response_code(404);
                // echo "User not found";
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
        $result = $this->userModel->getUserByID($_SESSION['user_id']);
        $user = $result->fetch_assoc();
        $posts = $this->userModel->getUserPostsByID($_SESSION['user_id']);
        include '../app/views/user.php';
    }
    // Settings Page
    public function settings() {
        // Get Previous Data
        $result = $this->userModel->getUserByID($_SESSION['user_id']);
        $user = $result->fetch_assoc();
        // Handle new data
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
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
            

            $userDetails = $this->userModel->getUserByEmail($prevEmail);
            
            $changePhoto=false;
            $changeUsername=false;
            $changeBio=false;
            $changeEmail=false;
            $changePassword=false;
            $newImageLink="";
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0){
                $file = $_FILES['photo']['tmp_name'];
                $up = uploadImage($file);
                if(!empty($up)){
                    $newImageLink=$up;
                    $changePassword=true;
                } else {
                    array_push($errors,"There is problem in upload new Photo");
                    echo "user photo changed"."<br>";
                }
                // echo uploadImage($file)."<br>";
                // echo $_FILES["photo"]["name"]."<br>";
                // echo $file."<br>";
            }
            if($username!=$prevUsername){
                if($this->userModel->checkUsernameExist($username,$userDetails["id"])){
                    array_push($errors,"Username is exist");
                } else {
                    $changeUsername=true;
                }
            }
            if(!empty($bio)&&$bio!=$prevBio){
                $changeBio=true;
            }
            if(!empty($email)&&$email!=$prevEmail){
                if($this->userModel->checkEmailExist($email,$userDetails["id"])){
                    array_push($errors,"Email is exist");
                } else {
                    $changeEmail=true;
                }
            }
            if(!empty($currentPassword)){
                if(password_verify($currentPassword, $userDetails['password'])){
                    if(!empty($newPassword)&&!empty($confirmPassword)){
                        if($newPassword==$confirmPassword){
                            $changePassword=true;
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
                array_push($errors,"Data is valid i will changed");
                if(!empty($newImageLink)){
                    // array_push($errors, "new photo $newImageLink");
                    $this->userModel->changePhoto($newImageLink,$userDetails["id"]);
                }
                if($changeUsername){
                    // array_push($errors, "new username $username");
                    $this->userModel->changeUsername($username,$userDetails["id"]);
                }
                if($changeBio){
                    // array_push($errors, "new bio $bio");
                    $this->userModel->changeBio($bio,$userDetails["id"]);
                }
                if($changeEmail){
                    // array_push($errors, "new email $email");
                    $this->userModel->changeEmail($email,$userDetails["id"]);
                }
                if($changePassword){
                    // array_push($errors, "new password $newPassword");
                    $this->userModel->changePassword($newPassword,$userDetails["id"]);
                }
                // include '../app/views/settings.php';
                // exit();
                header("Location: ?action=settings");
            }
        } else {
            include '../app/views/settings.php';
        }
    }
}


// // Check if the form is submitted
// if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_photo'])) {
//     $file = $_FILES['profile_photo']['tmp_name'];

//     // Upload to Cloudinary
//     try {
//         $result = (new UploadApi())->upload($file, [
//             'folder' => 'profile_photos'
//         ]);

//         // Get the URL of the uploaded image
//         $imageUrl = $result['secure_url'];

//         // Store the image URL in the database
//         $userId = $_SESSION['user_id']; // Assume you have the user ID stored in the session
//         $query = "UPDATE users SET profile_photo = ? WHERE id = ?";
//         $stmt = $conn->prepare($query);
//         $stmt->bind_param("si", $imageUrl, $userId);

//         if ($stmt->execute()) {
//             echo "Profile photo uploaded successfully.";
//         } else {
//             echo "Sorry, there was an error updating your profile photo in the database.";
//         }

//         $stmt->close();
//     } catch (Exception $e) {
//         echo 'Upload error: ' . $e->getMessage();
//     }
// }

?>