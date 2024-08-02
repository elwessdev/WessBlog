<?php
session_start();
require '../../vendor/autoload.php';
require '../../config/db.php';

// Get the raw POST data
$postData = file_get_contents("php://input");
$data = json_decode($postData, true);
$postID = $data['postID'];

$q = "UPDATE posts SET likes = likes + 1 WHERE id = ?";
$stmt = $db->prepare($q);
$stmt->bind_param("i", $postID);
$stmt->execute();

?>