<?php
session_start();
require '../../vendor/autoload.php';
require '../../config/db.php';

// Get the raw POST data
$commentData = file_get_contents("php://input");
$data = json_decode($commentData, true);

// Comment actions
if ($data['action']=="add") {
  $postID = $data['post_id'];
  $userID = $data['user_id'];
  $commentContent = htmlspecialchars($data['commentContent'],ENT_QUOTES,'UTF-8');
  $stmt=$db->prepare("INSERT INTO comments (post_id,user_id,content,likes,date) VALUES (?,?,?,0,NOW())");
  $stmt->bind_param("iis",$postID,$userID,$commentContent);
  try {
    $stmt->execute();
  } catch (Exception $err) {
      return "Error: " . $err->getMessage();
  } finally {
      $stmt->close(); // Close the statement
  }
}
if ($data['action']=="like") {
  $commentID = $data['comment_id'];
  $postID = $data['post_id'];
  $stmt=$db->prepare("UPDATE comments SET likes = likes + 1 WHERE id = ? AND post_id = ?");
  $stmt->bind_param("ii",$commentID,$postID);
  return $stmt->execute();
}
if ($data['action']=="edit") {
  $newComment = htmlspecialchars($data['new_comment'],ENT_QUOTES,'UTF-8');
  $commentID = $data['comment_id'];
  $userID = $data['user_id'];
  $stmt=$db->prepare("UPDATE comments SET content = ? WHERE id = ? AND user_id = ?");
  $stmt->bind_param("sii",$newComment,$commentID,$userID);
  return $stmt->execute();
}
if ($data['action']=="delete") {
  $commentID = $data['comment_id'];
  $userID = $data['user_id'];
  $stmt=$db->prepare("DELETE FROM comments WHERE id = ? AND user_id = ?");
  $stmt->bind_param("ii",$commentID,$userID);
  return $stmt->execute();
}
// Reply actions
if ($data['action']=="addReply") {
  $commentID = $data['comment_id'];
  $userID = $data['user_id'];
  $replyContent = htmlspecialchars($data['reply_content'],ENT_QUOTES,'UTF-8');
  $stmt=$db->prepare("INSERT INTO comment_reply (comment_id,user_id,content,date) VALUES (?,?,?,NOW())");
  $stmt->bind_param("iis",$commentID,$userID,$replyContent);
  return $stmt->execute();
}
if ($data['action']=="editReply") {
  $newReply = htmlspecialchars($data['new_reply'],ENT_QUOTES,'UTF-8');
  $replyID = $data['reply_id'];
  $commentID = $data['comment_id'];
  $userID = $data['user_id'];
  $stmt=$db->prepare("UPDATE comment_reply SET content = ? WHERE id = ? AND user_id = ? AND comment_id = ?");
  $stmt->bind_param("siii",$newReply,$replyID,$userID,$commentID);
  return $stmt->execute();
}
if ($data['action']=="deleteReply") {
  $replyID = $data['reply_id'];
  $commentID = $data['comment_id'];
  $userID = $data['user_id'];
  $stmt=$db->prepare("DELETE FROM comment_reply WHERE id = ? AND comment_id = ? AND user_id = ?");
  $stmt->bind_param("iii",$replyID,$commentID,$userID);
  return $stmt->execute();
}
?>