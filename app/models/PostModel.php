<?php
class Post {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }
    // Transactions
    public function beginTransaction() {
        $this->db->begin_transaction();
    }
    public function commit() {
        $this->db->commit();
    }
    public function rollback() {
        $this->db->rollback();
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
        if ($stmt->execute()) {
            return $this->db->insert_id;
        } else {
            throw new Exception("Error inserting post: " . $stmt->error);
        }
    }
    // Add Post Topics
    public function addPostTopic($post_id,$tag_id){
        $q="INSERT INTO post_tags (post_id,topic_id) VALUES (?,?)";
        $stmt=$this->db->prepare($q);
        $stmt->bind_param("ii",$post_id,$tag_id);
        if (!$stmt->execute()) {
            throw new Exception("Error inserting post topic: " . $stmt->error);
        }
    }
    // All Topics
    public function getAllTopics(){
        return $this->DBGetter("SELECT * FROM tags");
    }
    // All Posts
    public function getLatestPosts() {
        // $q = "SELECT posts.id,posts.title,posts.content,posts.published_at,posts.likes,posts.img,
        // users.username as author_name, users.id as author_id, users.photo as author_img
        // FROM posts
        // INNER JOIN users
        // ON posts.author_id = users.id
        // ORDER BY posts.published_at DESC";
        $q="SELECT 
                posts.id AS post_id,
                posts.title,
                posts.content,
                posts.published_at,
                posts.likes,
                posts.img,
                users.username AS author_name,
                users.id AS author_id,
                users.photo AS author_img,
                GROUP_CONCAT(tags.name ORDER BY tags.name SEPARATOR ', ') AS topics
            FROM
                posts
            INNER JOIN
                users ON posts.author_id = users.id
            LEFT JOIN
                post_tags ON posts.id = post_tags.post_id
            LEFT JOIN
                tags ON post_tags.topic_id = tags.id
            GROUP BY
                posts.id, posts.title, posts.content, posts.published_at, posts.likes, posts.img, users.username, users.id, users.photo
            ORDER BY
                posts.published_at DESC;
        ";
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
            INNER JOIN post_tags ON tags.id = post_tags.topic_id
            GROUP BY tags.id, tags.name
            ORDER BY countTag DESC;
        ";
        return $this->DBGetter($q);
    }
    // Post Details
    public function getPostDetails($id){
        $q="SELECT posts.title AS title, posts.img as img, posts.content AS content, posts.likes AS likes, posts.published_at AS date,
            users.id AS author_id, users.username AS username, users.bio as bio, users.photo AS photo,
            GROUP_CONCAT(tags.name ORDER BY tags.name SEPARATOR ', ') AS topics
            FROM posts
            INNER JOIN users
            ON posts.author_id = users.id
            LEFT JOIN
                post_tags ON posts.id = post_tags.post_id
            LEFT JOIN
                tags ON post_tags.topic_id = tags.id
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
    // Get Topic posts
    public function getTopicPosts($name){
        $stmt=$this->db->prepare("SELECT 
            posts.id AS post_id,
            posts.title,
            posts.content,
            posts.published_at,
            posts.likes,
            posts.img,
            users.username AS author_name,
            users.id AS author_id,
            users.photo AS author_img,
            GROUP_CONCAT(tags.name ORDER BY tags.name SEPARATOR ', ') AS topics
        FROM
            posts
        INNER JOIN
            users ON posts.author_id = users.id
        LEFT JOIN
            post_tags ON posts.id = post_tags.post_id
        LEFT JOIN
            tags ON post_tags.topic_id = tags.id
        WHERE 
            tags.name = ?
        GROUP BY
            posts.id, posts.title, posts.content, posts.published_at, posts.likes, posts.img, users.username, users.id, users.photo
        ORDER BY
            posts.published_at DESC;
        ");
        $stmt->bind_param("s",$name);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>