<?php
class PostController{
  private $postModel;
  public function __construct($postModel){
    $this->postModel = $postModel;
  }
  // Add new post
  public function handleNewPost(){
    // Get all tags
    $error="";
    $AllTopics = $this->postModel->getAllTopics();
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
      $title = $_POST['title'];
      $content = $_POST['content'];
      $errors=[];
      if(!isset($_FILES['image'])||$_FILES['image']['error']!=0){
        array_push($errors,"Pelase upload Post Cover");
      }
      if(empty($title)){
        array_push($errors,"Pelase fill Post Title");
      }
      if(!empty($title)&&strlen($title)<20){
        array_push($errors,"The minimum characters in title is 20");
      }
      if(empty($content)){
        array_push($errors,"Pelase fill Post Content");
      }
      if(!empty($content)&&strlen($content)<200){
        array_push($errors,"The minimum characters in content is 200");
      }
      if (!isset($_POST['topics'])){
        array_push($errors,"Please choose at least one topic");
      }

      if(!empty($errors)){
        include '../app/views/add-post.php';
        exit();
      } else {
        $id=$_SESSION['user_id'];
        $file = $_FILES['image']['tmp_name'];
        $cover = uploadImage($file);
        if(empty($cover)){
          array_push($errors,"There is problem in upload Post Photo");
          include '../app/views/add-post.php';
          exit();
        }
        try {
          // Start transaction
          $this->postModel->beginTransaction();
          // Add post
          $postId = $this->postModel->addPost($id, $title, $cover, $content);
          // Add topics
          $topics = $_POST['topics'];
          foreach ($topics as $topic) {
              $this->postModel->addPostTopic($postId, $topic);
          }
          // Commit transaction
          $this->postModel->commit();
          header('location: ?action=my-profile');
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $this->postModel->rollback();
            // array_push($errors, "There was a problem adding your post: " . $e->getMessage());
            array_push($errors, "There was a problem adding your post, Please try again");
            include '../app/views/add-post.php';
            exit();
        }
      }
    } else {
      include '../app/views/add-post.php';
    }
  }
  // Edit Poste
  public function editPost(){
    if(isset($_GET['action']) && $_GET['action'] === 'edit-post' && isset($_GET['id'])){
      $isMyPost = $this->postModel->checkPostOwner($_SESSION["user_id"],$_GET['id']);
      if($isMyPost){
        $postID=$_GET["id"];
        $AllTopics = $this->postModel->getAllTopics();
        $result = $this->postModel->getPostDetails($postID);
        $curPost = $result->fetch_assoc();
        include "../app/views/Edit-post.php";
      } else {
        header('location: ?action=');
      }
    } else{
      header('location: ?action=');
    }
    
    if($_SERVER["REQUEST_METHOD"]=="POST"){
      $postID=$_POST["postID"];
      $result = $this->postModel->getPostTopicsID($postID);
      $errors=[];
      $oldData = [
        'cover' => $_POST["prevCover"],
        'title' => $_POST["prevTitle"],
        'content' => $_POST["prevContent"],
        'topics' => explode(',', $result["topics"])
      ];
      $newData = [
        'cover' => $_FILES["image"]["tmp_name"],
        'title' => $_POST['title'],
        'content' => $_POST['content'],
        'topics' => $_POST['topics'],
      ];
      $changedData = [
        'cover'=>false,
        'title'=>false,
        'content'=>false,
        'topics'=>false
      ];

      // if($oldData["topics"]!=$newData["topics"]){
      //   echo "yes";
      // } else {
      //   echo "no";
      // }
      // echo $oldData["cover"]." ".$newData["cover"]."<br>";
      // echo $oldData["title"]." ".$newData["title"]."<br>";
      // foreach($oldData["topics"] as $topic){
      //   echo $topic." ";
      // }
      // echo "<br>";
      // foreach($newData["topics"] as $topic){
      //   echo $topic." ";
      // }

      if(empty($newData["title"])){
        array_push($errors,"Please fill post title");
      }
      if(!empty($newData["title"])&&strlen($newData["title"])<20&&$newData["title"]!=$oldData["title"]){
        array_push($errors,"The minimum characters in title is 20");
      }
      if(empty($newData["content"])){
        array_push($errors,"Please fill post content");
      }
      if(!empty($newData["content"])&&strlen($newData["content"])<200&&$newData["content"]!=$oldData["content"]){
        array_push($errors,"The minimum characters in content is 200");
      }
      if(empty($newData["topics"])){
        array_push($errors,"Please choose at least one topic");
      }

      function getFileIdFromUrl($url) {
        // Parse the URL to get the path
        $parsedUrl = parse_url($url);
        $path = $parsedUrl['path'];
    
        // Split the path by '/'
        $pathParts = explode('/', $path);
    
        // The file ID is the last part of the path
        $fileId = end($pathParts);
    
        return $fileId;
      }

      if(!empty($errors)){
        include '../app/views/Edit-post.php';
        exit();
      } else{
        if(!empty($newData["cover"])&&$oldData["cover"]!=$newData["cover"]){
          $fileId = getFileIdFromUrl($oldData["cover"]);
          $deleteFile = deleteImage($fileId); #php48B5_SfSBbSW3E
          if ($deleteFile->error) {
            echo "Error deleting file: " . $deleteFile->error->message;
            include '../app/views/Edit-post.php';
            exit();
          } else {
              echo "File deleted successfully.";
              $url = uploadImage($newData["cover"]);
              if(empty($url)){
                array_push($errors,"There is problem in upload Post Photo");
                include '../app/views/Edit-post.php';
                exit();
              } else {
                $this->postModel->changePostCover($postID,$url);
              }
          }
        }
        if($oldData["title"]!=$newData["title"]){
          $this->postModel->changePostTitle($postID,$newData["title"]);
        }
        if($oldData["content"]!=$newData["content"]){
          $this->postModel->changePostContent($postID,$newData["content"]);
        }
        if($oldData["topics"]!=$newData["topics"]){
          // Delete Past Topics
          foreach ($oldData["topics"] as $topic) {
            $this->postModel->deletePostTopic($postID, $topic);
          }
          // Add New Topics
          foreach ($newData["topics"] as $topic) {
            $this->postModel->addPostTopic($postID, $topic);
          }
        }
        header('location: ?action=edit-post&id='.$postID);
      }
    }
  }
  // Post Page
  public function PostPage(){
    if (isset($_GET['action']) && $_GET['action'] === 'post' && isset($_GET['id'])) {
      $result = $this->postModel->getPostDetails($_GET['id']);
      $post = $result->fetch_assoc();
      $name=$post["postTitle"];
      if ($post) {
        include '../app/views/post.php';
      } else {
        // http_response_code(404);
        // echo "User not found";
        header("location: ../public/");
      }
    } else {
      // http_response_code(400);
      // echo "Invalid request";
      header("location: ../public/");
    }
  }
  // Topic Page
  public function topicPage(){
    if(isset($_GET["action"])&&$_GET["action"]=="topic"&&isset($_GET["name"])){
      $topicName = $_GET["name"];
      $topics = $this->postModel->getTopicsWithNums();
      $tradingPosts = $this->postModel->getTradingPosts();
      $posts = $this->postModel->getTopicPosts($_GET["name"]);
      include '../app/views/topic.php';
    }
  }
  // Search Page
  public function searchPage(){
    if(isset($_POST["keywords"])&&!empty($_POST["keywords"])){
      $keyword=$_POST["keywords"];
      $tradingPosts = $this->postModel->getTradingPosts();
      $topics = $this->postModel->getTopicsWithNums();
      $posts = $this->postModel->getSearchPosts($keyword);
      include '../app/views/search.php';
    } else {
      header("location: ../public/");
    }
  }
  // For you page
  public function ForYouPage(){
    if(isset($_GET['action'])&&$_GET['action']=='for-you'&&isset($_SESSION["user_id"])){
      $tradingPosts = $this->postModel->getTradingPosts();
      $topics = $this->postModel->getTopicsWithNums();
      $posts = $this->postModel->followingPosts($_SESSION["user_id"]);
      include '../app/views/For-you.php';
    } else {
      header("location: ../public/");
    }
  }
}
