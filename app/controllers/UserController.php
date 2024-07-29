<?php
class UserController {
    private $userModel;
    public function __construct($userModel) {
        $this->userModel = $userModel;
    }
    // Get User Details
    public function profile() {
        if (isset($_GET['action']) && $_GET['action'] === 'profile' && isset($_GET['name'])) {
            $result = $this->userModel->getUserByName($_GET['name']);
            $user = $result->fetch_assoc();
            if ($user) {
                $data = ['user' => $user];
                extract($data);
                include '../app/views/profile.php';
            } else {
                // http_response_code(404);
                // echo "User not found";
                include '../app/views/index.php';
            }
        } else {
            http_response_code(400);
            echo "Invalid request";
        }
    }
}
?>