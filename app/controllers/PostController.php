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
      if(!isset($_FILES['image'])||$_FILES['image']['error']!=0){array_push($errors,"Pelase upload Post Cover");}
      if(empty($title)){array_push($errors,"Pelase fill Post Title");}
      if(empty($content)){array_push($errors,"Pelase fill Post Content");}
      if (!isset($_POST['topics'])){array_push($errors,"Pelase Choose topics");}

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
  // Post Page
  public function PostPage(){
    if (isset($_GET['action']) && $_GET['action'] === 'post' && isset($_GET['id'])) {
      $result = $this->postModel->getPostDetails($_GET['id']);
      $post = $result->fetch_assoc();
      if ($post) {
        // $data = ['post' => $post];
        // extract($data);
        include '../app/views/post.php';
      } else {
        // http_response_code(404);
        // echo "User not found";
        header("location: ../public/");
      }
    } else {
      http_response_code(400);
      echo "Invalid request";
    }
  }
  // Topic Page
  public function topicPage(){
    if(isset($_GET["action"])&&$_GET["action"]=="topic"&&isset($_GET["name"])){
      $topicName = $_GET["name"];
      $topics = $this->postModel->getTopicsWithNums();
      $topicPosts = $this->postModel->getTopicPosts($_GET["name"]);
      include '../app/views/topic.php';
    }
  }
}
