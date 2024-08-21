<?php
session_start();
require '../../vendor/autoload.php';
require '../../config/db.php';

// Get the raw POST data
$postData = file_get_contents("php://input");
$data = json_decode($postData, true);

// new notification
if($data["action"]=="new"){
  $from_id = $data["from_id"];
  $to_id = $data["to_id"];
  $content = htmlspecialchars($data["content"]);
  $stmt = $db->prepare("INSERT INTO notifications (from_id,to_id,content,isRead,date) VALUES (?,?,?,FALSE,NOW())");
  $stmt->bind_param("iis",$from_id,$to_id,$content);
  $stmt->execute();
  return $stmt->get_result();
}
// Reading notification
if($data["action"]=="read"){
  $id = $data["notif_id"];
  $stmt = $db->prepare("UPDATE notifications SET isRead = 1 WHERE id = ? AND to_id = ?");
  $stmt->bind_param("ii",$id,$_SESSION["user_id"]);
  $stmt->execute();
  return $stmt->get_result();
}
?>