<?php
  function checkLoginOutSide() {
    if (!isset($_SESSION['user_id'])) {
      header('Location: ?action=');
      exit;
    }
  }
  function checkLoginInside() {
    if (isset($_SESSION['user_id'])) {
      header('Location: ?action=');
      exit;
    }
  }
?>