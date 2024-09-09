<?php
class User {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }
    // Create new user
    public function createUser($id,$username,$email,$password,$profile_photo,$loginType) {
        $q = "INSERT INTO users (id, username, email, password, photo, loginType, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $this->db->prepare($q);
        $stmt->bind_param("isssss", $id,$username,$email,$password,$profile_photo,$loginType);
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
    // Check Google account
    // public function userExistByGoogle($googleID){
    //     $q = "SELECT * FROM users WHERE id = ?";
    //     $stmt=$this->db->prepare($q);
    //     $stmt->bind_param("i", $googleID);
    //     $stmt->execute();
    //     $result = $stmt->get_result();
    //     return $result->num_rows > 0;
    // }
    // Get user login type
    public function userLoginType($email){
        $stmt=$this->db->prepare("SELECT loginType FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $res = $stmt->get_result();
        $type = $res->fetch_assoc();
        return $type["loginType"];
    }
    // Check user exist with mail or username
    public function userNameExist($username){
        $q = "SELECT id FROM users WHERE username = ?";
        $stmt=$this->db->prepare($q);
        $stmt->bind_param("s", $username);
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
            users.photo_id,
            users.bio,
            users.loginType,
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
                posts.intro,
                posts.published_at,
                posts.likes,
                posts.img,
                posts.img_id,
                users.id AS author_id,
                users.username AS author_name,
                users.photo AS author_img,
                COUNT(DISTINCT comments.id) as comments,
                GROUP_CONCAT(DISTINCT tags.name ORDER BY tags.name SEPARATOR ', ') AS topics
            FROM posts
            INNER JOIN users ON posts.author_id = users.id
            LEFT JOIN post_tags ON posts.id = post_tags.post_id
            LEFT JOIN tags ON post_tags.topic_id = tags.id
            LEFT JOIN comments ON posts.id = comments.post_id
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
    public function checkEmailExist($email){
        $stmt=$this->db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows;
    }
    // Settings
    public function changePhoto($photo,$photo_id,$id){
        $q = "UPDATE users SET photo = ?, photo_id = ? WHERE id = ?";
        $stmt=$this->db->prepare($q);
        $stmt->bind_param("ssi",$photo,$photo_id,$id);
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
    // Set Token reset password
    public function TokenResetPassword($token,$expire,$email){
        $stmt=$this->db->prepare("UPDATE users SET 	reset_token = ?, token_expires_at = ? WHERE email = ?");
        $stmt->bind_param("sss",$token,$expire,$email);
        $stmt->execute();
        if($this->db->affected_rows){
            return true;
        } else {
            return false;
        }
    }
    // Get Token
    public function getTokenResetPassword($token){
        $stmt=$this->db->prepare("SELECT * from users WHERE reset_token = ?");
        $stmt->bind_param("s",$token);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    // Get Token
    public function resetSaveNewPassword($pwd,$id){
        $stmt=$this->db->prepare("UPDATE users SET password = ?, reset_token = NULL, token_expires_at = NULL WHERE id = ?");
        $stmt->bind_param("si",$pwd,$id);
        $stmt->execute();
        if($this->db->affected_rows){
            return true;
        } else {
            return false;
        }
    }
    // Get user notifications
    public function getNotifications($id){
        $stmt=$this->db->prepare("SELECT content,isRead,date FROM notifications WHERE to_id = ?");
        // $stmt->bind_param();
        $stmt->execute([$id]);
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>