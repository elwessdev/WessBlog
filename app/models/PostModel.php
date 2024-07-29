<?php
class Post {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }
    // Add new post
    public function addPost($userId,$title,$img,$content){
        $q="INSERT INTO posts (author_id,title,img,content,likes,published_at) VALUES (?,?,?,?,0,NOW())";
        $stmt = $this->db->prepare($q);
        $stmt->bind_param("ssss",$userId,$title,$img,$content);
        return $stmt->execute();
    }
    // Get Tags
    public function getTags(){
        $stmt = $this->db->prepare("SELECT * FROM tags");
        $stmt->execute();
        return $stmt->get_result();
    }
    // Get All Posts
    public function getAllPosts() {
        $q = "SELECT posts.id,posts.title,posts.content,posts.published_at,posts.likes,posts.img, users.username as author_name, users.id as author_id, users.photo as author_img
            FROM posts 
            INNER JOIN users ON posts.author_id = users.id";
        $stmt = $this->db->prepare($q);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>