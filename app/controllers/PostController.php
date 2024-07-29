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
    $tags = $this->postModel->getTags();
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
      $title = $_POST['title'];
      $content = $_POST['content'];
      $tags = $_POST['tags'];
      if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $id=$_SESSION['user_id'];
        if (!is_dir("uploads/$id/")) {
          mkdir("uploads/$id/", 0777, true);
        }
        $targetFile = "uploads/$id/".basename($_FILES["image"]["name"]);
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
          $error="Sorry, there was an error uploading your file.";
        } else {
          if(isset($title)&&isset($content)){
            $tags = $this->postModel->addPost($id,$title,$targetFile,$content);
            include '../app/views/add-post.php';
          } else {
            $error="Sorry, There is a problem, Please try again.";
          }
        }
      } else {
        $error="No image uploaded or an error occurred.";
      }
    } else {
      include '../app/views/add-post.php';
    }
  }
}
