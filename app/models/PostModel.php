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
    public function addPost($userId,$title,$img,$content,$img_id){
        $q="INSERT INTO posts (author_id,title,img,content,likes,published_at,img_id) VALUES (?,?,?,?,0,NOW(),?)";
        $stmt = $this->db->prepare($q);
        $stmt->bind_param("sssss",$userId,$title,$img,$content,$img_id);
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
            COUNT(DISTINCT comments.id) as comments,
            GROUP_CONCAT(tags.name ORDER BY tags.name) AS topics
            FROM
                posts
            INNER JOIN
                users ON posts.author_id = users.id
            LEFT JOIN
                post_tags ON posts.id = post_tags.post_id
            LEFT JOIN
                tags ON post_tags.topic_id = tags.id
            LEFT JOIN
                comments ON posts.id = comments.post_id
            GROUP BY
                posts.id, posts.title, posts.content, posts.published_at, posts.likes, posts.img,
                users.username, users.id, users.photo
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
            posts.img_id AS postCoverID,
            --
            users.username AS authorName,
            users.id AS authorId,
            users.photo AS authorPhoto,
            --
            COUNT(DISTINCT comments.id) as comments,
            --
            GROUP_CONCAT(tags.name ORDER BY tags.name) AS topics
            FROM 
                posts
            INNER JOIN users
                ON posts.author_id = users.id
            LEFT JOIN post_tags
                ON posts.id = post_tags.post_id
            LEFT JOIN tags
                ON post_tags.topic_id = tags.id
            LEFT JOIN
                comments ON posts.id = comments.post_id
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
            COUNT(DISTINCT comments.id) as comments,
            GROUP_CONCAT(tags.name ORDER BY tags.name) AS topics
        FROM
            posts
        INNER JOIN
            users ON posts.author_id = users.id
        LEFT JOIN
            post_tags ON posts.id = post_tags.post_id
        LEFT JOIN
            tags ON post_tags.topic_id = tags.id
        LEFT JOIN
            comments ON posts.id = comments.post_id
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
                COUNT(DISTINCT comments.id) as comments,
                GROUP_CONCAT(tags.name ORDER BY tags.name) AS topics
            FROM 
                posts
            INNER JOIN 
                users ON posts.author_id = users.id
            LEFT JOIN
                post_tags ON posts.id = post_tags.post_id
            LEFT JOIN
                tags ON post_tags.topic_id = tags.id
            LEFT JOIN
                comments ON posts.id = comments.post_id
            WHERE 
                posts.title LIKE ?
            GROUP BY 
                posts.id, users.username, users.id, users.photo
            ORDER BY 
                postLikes DESC
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
    public function changePostCover($postID,$url,$img_id){
        $q = "UPDATE posts SET img = ?, img_id = ? WHERE id = ?";
        $stmt=$this->db->prepare($q);
        $stmt->bind_param("ssi",$url,$img_id,$postID);
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
                COUNT(DISTINCT comments.id) as comments,
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
            LEFT JOIN
                comments ON posts.id = comments.post_id
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
    // Get Post Comments
    public function getPostComments($id){
        $stmt=$this->db->prepare("SELECT
            comments.id as comment_id,
            comments.user_id as comment_user_id,
            comments.content as comment_content,
            comments.likes as comment_likes,
            comments.date as comment_date,
            --
            u1.username as comment_user_name,
            u1.photo as comment_user_photo,
            --
            comment_reply.id as reply_id,
            comment_reply.comment_id as reply_comment_id,
            comment_reply.user_id as reply_user_id,
            comment_reply.content as reply_content,
            comment_reply.date as reply_date,
            --
            u2.username as reply_user_name,
            u2.photo as reply_user_photo
            FROM comments
            LEFT JOIN users as u1
                ON comments.user_id = u1.id
            LEFT JOIN comment_reply
                ON comments.id = comment_reply.comment_id
            LEFT JOIN users as u2
                ON comment_reply.user_id = u2.id
            where comments.post_id = ?
            ORDER BY comment_likes DESC
        ");
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $result = $stmt->get_result();
        $comments = [];
        while($row = $result->fetch_assoc()){
            $comment_id = $row['comment_id'];
            if (!isset($comments[$comment_id])) {
                $comments[$comment_id] = [
                    'comment_id' => $row['comment_id'],
                    'user_id' => $row['comment_user_id'],
                    'content' => $row['comment_content'],
                    'likes' => $row['comment_likes'],
                    'date' => $row['comment_date'],
                    'user_name' => $row['comment_user_name'],
                    'user_photo' => $row['comment_user_photo'],
                    'replies' => []
                ];
            }
            if($row["reply_id"]){
                $comments[$comment_id]["replies"][] = [
                    'reply_id' => $row['reply_id'],
                    'comment_id' => $row['reply_comment_id'],
                    'content' => $row['reply_content'],
                    'date' => $row['reply_date'],
                    'reply_user_id' => $row['reply_user_id'],
                    'reply_user_name' => $row['reply_user_name'],
                    'reply_user_photo' => $row['reply_user_photo']
                ];
            }
        }
        return $comments;
    }
}
?>