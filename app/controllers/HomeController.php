<?php
class HomeController{
  private $postModel;
  public function __construct($postModel){
    $this->postModel = $postModel;
  }
  // Index
  public function index(){
    $posts = $this->postModel->getLatestPosts();
    $topPost = $this->postModel->getTopPost()->fetch_object();
    $tradingPosts = $this->postModel->getTrendingPosts();
    $topics = $this->postModel->getTopicsWithNums();
    include 'app/views/index.php';
  }
}
