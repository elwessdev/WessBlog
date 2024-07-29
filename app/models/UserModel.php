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
    public function getUserByName($username) {
        $q = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->db->prepare($q);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>