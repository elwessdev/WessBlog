<?php
class User {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }
    // Create new user
    public function createUser($username,$email,$password,$profile_photo) {
        $q = "INSERT INTO users (username, email, password, photo, created_at) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $this->db->prepare($q);
        $stmt->bind_param("ssss", $username,$email,$password,$profile_photo);
        return $stmt->execute();
    }
    // Check user exist with mail or username
    public function userExist($email,$username){
        $q = "SELECT * FROM users WHERE email = ? OR username = ?";
        $stmt=$this->db->prepare($q);
        $stmt->bind_param("ss", $email,$username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
    // Get user data with email when login
    public function getUserByEmail($email) {
        $q = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->prepare($q);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }
    // Get user details by Name
    public function getUserByID($id) {
        $q = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db->prepare($q);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }
    // Get User Posts by user ID
    public function getUserPostsByID($id) {
        $q="SELECT * FROM posts WHERE author_id = ?";
        $stmt=$this->db->prepare($q);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        return $stmt->get_result();
    }
    // check username exist
    public function checkUsernameExist($username,$id){
        $q = "SELECT username FROM users WHERE username = ? AND id != ?";
        $stmt=$this->db->prepare($q);
        $stmt->bind_param("si",$username,$id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    } 
    // check user password
    public function checkEmailExist($email,$id){
        $q = "SELECT email FROM users WHERE email = ? AND id != ?";
        $stmt=$this->db->prepare($q);
        $stmt->bind_param("si",$email,$id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
    // Settings
    public function changePhoto($photo,$id){
        $q = "UPDATE users SET photo = ? WHERE id = ?";
        $stmt=$this->db->prepare($q);
        $stmt->bind_param("si",$photo,$id);
        $stmt->execute();
    }
    public function changeUsername($username,$id){
        $q = "UPDATE users SET username = ? WHERE id = ?";
        $stmt=$this->db->prepare($q);
        $stmt->bind_param("si",$username,$id);
        $stmt->execute();
    }
    public function changeBio($bio,$id){
        $q = "UPDATE users SET bio = ? WHERE id = ?";
        $stmt=$this->db->prepare($q);
        $stmt->bind_param("si",$bio,$id);
        $stmt->execute();
    }
    public function changeEmail($email,$id){
        $q = "UPDATE users SET email = ? WHERE id = ?";
        $stmt=$this->db->prepare($q);
        $stmt->bind_param("si",$email,$id);
        $stmt->execute();
    }
    public function changePassword($password,$id){
        $q = "UPDATE users SET password = ? WHERE id = ?";
        $stmt=$this->db->prepare($q);
        $stmt->bind_param("si",$password,$id);
        $stmt->execute();
    }
}
?>