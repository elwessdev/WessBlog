<?php
session_start();
require '../../vendor/autoload.php';
require '../../config/db.php';
require './UploadImageHelper.php';

// Get the raw POST data
$postData = file_get_contents("php://input");
$data = json_decode($postData, true);
$postID = $data['postID'];
$authID = $data['authID'];
$imgID = $data['imgID'];


$q = "DELETE FROM posts WHERE id = ? AND author_id = ? AND img_id = ?";
$stmt = $db->prepare($q);
$stmt->bind_param("iis", $postID,$authID,$imgID);
$stmt->execute();
if ($stmt->affected_rows > 0) {
  // Delete post cover
  deleteImage($imgID);
}
?>