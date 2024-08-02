<?php
session_start();
require '../../vendor/autoload.php';
require '../../config/db.php';

// Get the raw POST data
$postData = file_get_contents("php://input");
$data = json_decode($postData, true);
$userID = $_SESSION['user_id'];
$followedID = $data['followed'];

if ($data['follow']==true) {
  $q = "INSERT INTO following (user_id, followed_id) VALUES (?, ?)";
  $stmt = $db->prepare($q);
  $stmt->bind_param("ii", $userID, $followedID);
  $stmt->execute();
}
if($data['follow']==false){
  $q = "DELETE FROM following WHERE user_id = ? AND followed_id = ?";
  $stmt = $db->prepare($q);
  $stmt->bind_param("ii", $userID, $followedID);
  $stmt->execute();
}

?>