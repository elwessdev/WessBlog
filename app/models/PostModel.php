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
        $q="SELECT 
            posts.id AS postId,
            posts.title AS postTitle,
            posts.content AS postContent,
            posts.published_at AS postDate,
            posts.likes AS postLikes,
            posts.img AS postCover,
            users.username AS authorName,
            users.id AS authorId,
            users.photo AS authorPhoto,
            GROUP_CONCAT(tags.name ORDER BY tags.name) AS topics
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
                postDate DESC;
        ";
        return $this->DBGetter($q);
    }
    // Top Post
    public function getTopPost(){
        $q = "SELECT 
            posts.id AS postId,
            posts.title AS postTitle,
            posts.published_at AS postDate,
            posts.img AS postCover,
            users.username AS authorName,
            users.id AS authorId,
            users.photo AS authorPhoto,
            GROUP_CONCAT(tags.name ORDER BY tags.name) AS topics
            FROM posts
            INNER JOIN users ON posts.author_id = users.id
            LEFT JOIN post_tags ON posts.id = post_tags.post_id
            LEFT JOIN tags ON post_tags.topic_id = tags.id
            GROUP BY 
                    posts.id, posts.title, posts.img, posts.published_at, 
                    users.id, users.username, users.photo
            ORDER BY posts.likes DESC
            LIMIT 1;
        ";
        return $this->DBGetter($q);
    }
    // Trading Posts (6 posts only)
    public function getTradingPosts(){
        $q = "SELECT * FROM posts ORDER BY likes DESC LIMIT 6";
        return $this->DBGetter($q);
    }
    // Posts Topics numbers
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
        $q="SELECT
            posts.id AS postId,
            posts.title AS postTitle,
            posts.content AS postContent,
            posts.published_at AS postDate,
            posts.likes AS postLikes,
            posts.img AS postCover,
            users.username AS authorName,
            users.id AS authorId,
            users.photo AS authorPhoto,
            GROUP_CONCAT(tags.name ORDER BY tags.name) AS topics
            FROM posts
            INNER JOIN users
                ON posts.author_id = users.id
            LEFT JOIN post_tags
                ON posts.id = post_tags.post_id
            LEFT JOIN tags
                ON post_tags.topic_id = tags.id
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
            posts.id AS postId,
            posts.title AS postTitle,
            posts.content AS postContent,
            posts.published_at AS postDate,
            posts.likes AS postLikes,
            posts.img AS postCover,
            users.username AS authorName,
            users.id AS authorId,
            users.photo AS authorPhoto,
            GROUP_CONCAT(tags.name ORDER BY tags.name) AS topics
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
    // Get Search Posts
    public function getSearchPosts($keyword){
        $stmt=$this->db->prepare("SELECT 
                posts.id AS postId,
                posts.title AS postTitle,
                posts.content AS postContent,
                posts.published_at AS postDate,
                posts.likes AS postLikes,
                posts.img AS postCover,
                users.username AS authorName,
                users.id AS authorId,
                users.photo AS authorPhoto,
                GROUP_CONCAT(tags.name ORDER BY tags.name) AS topics
            FROM posts
            INNER JOIN users ON posts.author_id = users.id
            LEFT JOIN post_tags ON posts.id = post_tags.post_id
            LEFT JOIN tags ON post_tags.topic_id = tags.id
            WHERE posts.title LIKE ?
            GROUP BY posts.id, users.username, users.id, users.photo
            ORDER BY postLikes DESC
            ");
        $keyword="%{$keyword}%";
        $stmt->bind_param("s",$keyword);
        $stmt->execute();
        return $stmt->get_result();
    }
    // Get Post Topics ID
    public function getPostTopicsID($postID){
        $q = "SELECT GROUP_CONCAT(tags.id) AS topics
            FROM posts
            LEFT JOIN post_tags ON posts.id = post_tags.post_id
            LEFT JOIN tags ON post_tags.topic_id = tags.id
            WHERE posts.id = ?";
        $stmt=$this->db->prepare($q);
        $stmt->bind_param("i",$postID);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    // UPDATE Post
    public function changePostCover($postID, $url){
        $q = "UPDATE posts SET img = ? WHERE id = ?";
        $stmt=$this->db->prepare($q);
        $stmt->bind_param("si",$url,$postID);
        $stmt->execute();
    }
    public function changePostTitle($postID, $title){
        $q = "UPDATE posts SET title = ? WHERE id = ?";
        $stmt=$this->db->prepare($q);
        $stmt->bind_param("si",$title,$postID);
        $stmt->execute();
    }
    public function changePostContent($postID, $content){
        $q = "UPDATE posts SET content = ? WHERE id = ?";
        $stmt=$this->db->prepare($q);
        $stmt->bind_param("si",$content,$postID);
        $stmt->execute();
    }
    public function deletePostTopic($postID, $topic){
        $q="DELETE FROM post_tags WHERE post_id = ? AND topic_id = ?";
        $stmt=$this->db->prepare($q);
        $stmt->bind_param("ii",$postID,$topic);
        if (!$stmt->execute()) {
            throw new Exception("Error inserting post topic: " . $stmt->error);
        }
    }
    // Following Posts
    public function followingPosts($id){
        $q="SELECT 
                posts.id AS postId,
                posts.title AS postTitle,
                posts.content AS postContent,
                posts.published_at AS postDate,
                posts.likes AS postLikes,
                posts.img AS postCover,
                users.username AS authorName,
                users.id AS authorId,
                users.photo AS authorPhoto,
                GROUP_CONCAT(tags.name ORDER BY tags.name) AS topics
            FROM
                posts
            INNER JOIN
                users ON posts.author_id = users.id
            LEFT JOIN
                post_tags ON posts.id = post_tags.post_id
            LEFT JOIN
                tags ON post_tags.topic_id = tags.id
            INNER JOIN
                following ON users.id = following.followed_id
            WHERE
                following.user_id = ?
            GROUP BY
                posts.id, posts.title, posts.content, posts.published_at, posts.likes, posts.img, users.username, users.id, users.photo
            ORDER BY posts.published_at DESC
        ";
        $stmt=$this->db->prepare($q);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        return $stmt->get_result();
    }
    // Check post owner
    public function checkPostOwner($user,$post){
        $stmt=$this->db->prepare("SELECT id FROM posts WHERE author_id = ? AND id = ?");
        $stmt->bind_param("ii",$user,$post);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->num_rows > 0;
    }
}
?>