<?php
class Post {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }
    // DB Getter
    private function DBGetter($q){
        $stmt = $this->db->prepare($q);
        $stmt->execute();
        return $stmt->get_result();
    }
    // Add new post
    public function addPost($userId,$title,$img,$content){
        $q="INSERT INTO posts (author_id,title,img,content,likes,published_at) VALUES (?,?,?,?,0,NOW())";
        $stmt = $this->db->prepare($q);
        $stmt->bind_param("ssss",$userId,$title,$img,$content);
        return $stmt->execute();
    }
    // Tags
    public function getTags(){
        return $this->DBGetter("SELECT * FROM tags");
    }
    // All Posts
    public function getLatestPosts() {
        $q = "SELECT posts.id,posts.title,posts.content,posts.published_at,posts.likes,posts.img,
        users.username as author_name, users.id as author_id, users.photo as author_img
        FROM posts
        INNER JOIN users
        ON posts.author_id = users.id";
        return $this->DBGetter($q);
    }
    // Top Post
    public function getTopPost(){
        $q = "SELECT posts.id,posts.title,posts.img,posts.content,posts.likes,posts.published_at,
        users.username as author_name, users.id as author_id, users.photo as author_img
        FROM posts
        INNER JOIN users
        ON posts.author_id = users.id
        ORDER BY posts.likes DESC
        LIMIT 1";
        return $this->DBGetter($q);
    }
    // Trading Posts (6 posts only)
    public function getTradingPosts(){
        $q = "SELECT * FROM posts ORDER BY likes DESC LIMIT 6";
        return $this->DBGetter($q);
    }
    // Posts Topics with nums
    public function getTopicsWithNums(){
        $q = "SELECT tags.name AS tagName, COUNT(post_tags.post_id) AS countTag
            FROM tags
            INNER JOIN post_tags ON tags.id = post_tags.tag_id
            GROUP BY tags.id, tags.name
            ORDER BY countTag DESC;
        ";
        return $this->DBGetter($q);
    }
    // Post Details
    public function getPostDetails($id){
        $q="SELECT posts.title AS title, posts.img as img, posts.content AS content, posts.likes AS likes, posts.published_at AS date,
            users.id AS author_id, users.username AS username, users.bio as bio, users.photo AS photo
            FROM posts
            INNER JOIN users
            ON posts.author_id = users.id
            WHERE posts.id = ?";
        $stmt=$this->db->prepare($q);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        return $stmt->get_result();
    }
    // Add like
    public function addLike($id){
        $q="UPDATE posts SET likes = likes+1 WHERE id = ?";
        $stmt=$this->db->prepare($q);
        $stmt->bind_param("i",$id);
        $stmt->execute();
    }
}
?>