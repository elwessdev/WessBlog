<?php
class User {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }
    // Create new user
    public function createUser($id,$username,$email,$password,$profile_photo) {
        $q = "INSERT INTO users (id, username, email, password, photo, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $this->db->prepare($q);
        $stmt->bind_param("issss", $id,$username,$email,$password,$profile_photo);
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
        $q = "SELECT * FROM users WHERE email = ? OR username = ?";
        $stmt = $this->db->prepare($q);
        $stmt->bind_param("ss",$email,$email);
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
        $q = "SELECT 
            users.id,
            users.username,
            users.email,
            users.photo,
            users.bio,
            COUNT(following.user_id) AS followers
            FROM users
            LEFT JOIN following
            ON users.id = following.followed_id
            WHERE users.id = ?
            GROUP BY users.id, users.username, users.photo, users.bio
        ";
        $stmt = $this->db->prepare($q);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    // User Following
    public function followingUsers($id) {
        $q = "SELECT 
            users.id AS user_id,
            users.username AS user_name,
            users.photo AS user_photo
            FROM users
            LEFT JOIN following
            ON users.id = following.followed_id
            WHERE following.user_id = ?
        ";
        $stmt = $this->db->prepare($q);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }
    // Get User Posts by user ID
    public function getUserPostsByID($id) {
        $q="SELECT 
                posts.id AS post_id,
                posts.title,
                posts.content,
                posts.published_at,
                posts.likes,
                posts.img,
                users.id AS author_id,
                users.username AS author_name,
                users.photo AS author_img,
                GROUP_CONCAT(tags.name ORDER BY tags.name SEPARATOR ', ') AS topics
            FROM posts
            INNER JOIN users ON posts.author_id = users.id
            LEFT JOIN post_tags ON posts.id = post_tags.post_id
            LEFT JOIN tags ON post_tags.topic_id = tags.id
            WHERE author_id = ?
            GROUP BY posts.id, posts.title, posts.content, posts.published_at, posts.likes, posts.img, users.username, users.id, users.photo
            ORDER BY posts.published_at DESC
        ";
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
    // Get user photo
    public function getUserPhoto($id){
        $q = "SELECT users.photo AS photo FROM users WHERE id = ?";
        $stmt = $this->db->prepare($q);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['photo'];
        } else {
            return null;
        }
    }
    // Check Follow
    public function checkFollow($userID,$followID){
        $q = "SELECT id FROM following WHERE user_id = ? AND followed_id = ?";
        $stmt=$this->db->prepare($q);
        $stmt->bind_param("ii",$userID,$followID);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
}
?>