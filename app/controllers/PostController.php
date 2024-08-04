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
      // Validation
      if(!isset($_FILES['image'])||$_FILES['image']['error']!=0){
        array_push($errors,"Post cover is require");
      }
      if(empty($title)){
        array_push($errors,"Post title is require");
      } else {
        if(strlen($title)<20){
          array_push($errors,"Title at least 20 characters");
        }
      }
      if(empty($content)){
        array_push($errors,"Post content is require");
      } else {
        if(strlen($content)<200){
          array_push($errors,"Content at least 200 characters");
        }
      }
      if (!isset($_POST['topics'])){
        array_push($errors,"Choose at least one topic");
      }

      if(!empty($errors)){
        include 'app/views/add-post.php';
        exit();
      } else {
        $id=$_SESSION['user_id'];
        $file = $_FILES['image']['tmp_name'];
        $cover = uploadImage($file);
        $validTitle = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
        $validContent = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');
        if($cover->error){
          array_push($errors,"There is problem in upload Post Photo");
          include 'app/views/add-post.php';
          exit();
        } else {
          try {
            // Start transaction
            $this->postModel->beginTransaction();
            // Add post
            $postId = $this->postModel->addPost($id, $validTitle, $cover->result->url, $validContent,$cover->result->fileId);
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
              include 'app/views/add-post.php';
              exit();
          }
        }
      }
    } else {
      include 'app/views/add-post.php';
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
        include "app/views/Edit-post.php";
      } else {
        header('location: ?action=');
      }
    }
    if($_SERVER["REQUEST_METHOD"]=="POST"&&isset($_GET['action']) && $_GET['action'] === 'edit-post'){
      $postID=$_POST["postID"];
      $result = $this->postModel->getPostTopicsID($postID);
      $errors=[];
      $oldData = [
        'cover' => $_POST["prevCover"],
        'coverID' => $_POST["prevCoverID"],
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
      // Validation
      if(empty($newData["title"])){
        array_push($errors,"Post title is require");
      } else {
        if(strlen($newData["title"])<20&&$newData["title"]!=$oldData["title"]){
          array_push($errors,"Title at least 20 characters");
        }
      }
      if(empty($newData["content"])){
        array_push($errors,"Post content is require");
      } else {
        if(strlen($content)<200&&$newData["content"]!=$oldData["content"]){
          array_push($errors,"Content at least 200 characters");
        }
      }
      // if(!isset($_FILES['image'])||$_FILES['image']['error']!=0){
      //   array_push($errors,"Post cover is require");
      // }
      // if(empty($newData["topics"])){
      //   array_push($errors,"Choose at least one topic");
      // }

      if(!empty($errors)){
        // include "app/views/Edit-post.php";
        header("Location: ?action=edit-post&id={$postID}");
        exit();
      } else{
        if(!empty($newData["cover"])&&$oldData["cover"]!=$newData["cover"]){
          $deleteFile = deleteImage($oldData["coverID"]);
          if ($deleteFile->error&&!empty($oldData["coverID"])) {
            // echo "Error deleting file: " . $deleteFile->error->message;
            array_push($errors,"There is problem in post cover, Try Again");
            include 'app/views/Edit-post.php';
            exit();
          } else {
              $resultUpload = uploadImage($newData["cover"]);
              $img_url = $resultUpload->result->url;
              $img_id = $resultUpload->result->fileId;
              if(empty($img_url)){
                array_push($errors,"There is problem in post cover, Try Again");
                include 'app/views/Edit-post.php';
                exit();
              } else {
                $this->postModel->changePostCover($postID,$img_url,$img_id);
              }
          }
        }
        if($oldData["title"]!=$newData["title"]){
          $validTitle = htmlspecialchars($newData["title"], ENT_QUOTES, 'UTF-8');
          $this->postModel->changePostTitle($postID,$validTitle);
        }
        if($oldData["content"]!=$newData["content"]){
          $validContent = htmlspecialchars($newData["content"], ENT_QUOTES, 'UTF-8');
          $this->postModel->changePostContent($postID,$validContent);
        }
        if($oldData["topics"]!=$newData["topics"]&&!empty($newData["topics"])){
          // Delete Past Topics
          foreach ($oldData["topics"] as $topic) {
            $this->postModel->deletePostTopic($postID, $topic);
          }
          // Add New Topics
          foreach ($newData["topics"] as $topic) {
            $this->postModel->addPostTopic($postID, $topic);
          }
        }
        header('location: ?action=post&id='.$postID);
        // header('location: ?action=edit-post&id='.$postID);
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
        include 'app/views/post.php';
      } else {
        // http_response_code(404);
        // echo "User not found";
        header("location: ?action=");
      }
    } else {
      // http_response_code(400);
      // echo "Invalid request";
      header("location: ?action=");
    }
  }
  // Topic Page
  public function topicPage(){
    if(isset($_GET["action"])&&$_GET["action"]=="topic"&&isset($_GET["name"])){
      $topicName = $_GET["name"];
      $topics = $this->postModel->getTopicsWithNums();
      $tradingPosts = $this->postModel->getTradingPosts();
      $posts = $this->postModel->getTopicPosts($_GET["name"]);
      include 'app/views/topic.php';
    }
  }
  // Search Page
  public function searchPage(){
    if(isset($_POST["keywords"])&&!empty($_POST["keywords"])){
      $keyword=htmlspecialchars($_POST["keywords"],ENT_QUOTES,'UTF-8');
      $tradingPosts = $this->postModel->getTradingPosts();
      $topics = $this->postModel->getTopicsWithNums();
      $posts = $this->postModel->getSearchPosts($keyword);
      include 'app/views/search.php';
    } else {
      header("location: ?action=home");
    }
  }
  // For you page
  public function ForYouPage(){
    if(isset($_GET['action'])&&$_GET['action']=='for-you'&&isset($_SESSION["user_id"])){
      $tradingPosts = $this->postModel->getTradingPosts();
      $topics = $this->postModel->getTopicsWithNums();
      $posts = $this->postModel->followingPosts($_SESSION["user_id"]);
      include 'app/views/For-you.php';
    } else {
      header("location: ?action=home");
    }
  }
}
