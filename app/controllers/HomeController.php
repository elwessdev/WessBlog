<?php
class HomeController{
  private $postModel;
  public function __construct($postModel){
    $this->postModel = $postModel;
  }
  public function index(){
    $posts = $this->postModel->getAllPosts();
    include '../app/views/index.php';
  }
}
