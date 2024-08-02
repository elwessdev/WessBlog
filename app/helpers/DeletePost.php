<?php
session_start();
require '../../vendor/autoload.php';
require '../../config/db.php';

// Get the raw POST data
$postData = file_get_contents("php://input");
$data = json_decode($postData, true);
$postID = $data['postID'];
$authID = $data['authID'];

echo $postID.$authID;

$q = "DELETE FROM posts WHERE id = ? AND author_id = ?";
$stmt = $db->prepare($q);
$stmt->bind_param("ii", $postID,$authID);
$stmt->execute();

?>