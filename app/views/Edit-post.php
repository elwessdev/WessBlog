<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post - WessBlog</title>
    <!-- CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link href="https://raw.githack.com/ttskch/select2-bootstrap4-theme/master/dist/select2-bootstrap4.css" rel="stylesheet"> 
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style/main.css">
</head>
<body class="edit-post">
<div class="container mx-auto px-6 py-4">
  <!-- Header -->
  <?php include __DIR__ . "/header.php" ?>
  <!-- Page content -->
  <div class="new-post">
      <h2 class="title">
          Edit Post
          <svg width="33" height="6" xmlns="http://www.w3.org/2000/svg">
              <defs>
                  <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                      <stop offset="0%" stop-color="#5171ff"></stop>
                      <stop offset="100%" stop-color="#5171ff"></stop>
                  </linearGradient>
                  </defs>
              <path d="M33 1c-3.3 0-3.3 4-6.598 4C23.1 5 23.1 1 19.8 1c-3.3 0-3.3 4-6.599 4-3.3 0-3.3-4-6.6-4S3.303 5 0 5" stroke="url(#gradient)" stroke-width="2" fill="none"></path>
          </svg>
      </h2>
      <form action="?action=edit-post" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="postID" value="<?php echo $curPost["postId"]; ?>" />
          <input type="hidden" name="prevCover" value="<?php echo $curPost["postCover"]; ?>" />
          <input type="hidden" name="prevTitle" value="<?php echo $curPost["postTitle"]; ?>" />
          <input type="hidden" name="prevContent" value="<?php echo $curPost["postContent"]; ?>" />
          <!-- <input type="hidden" name="prevTopics" value="<?php echo $curPost["topics"]; ?>" /> -->
          <div class="img">
            <div class="add-area">
              <input type="file" name="image" id="image" accept="image/*" class="img_up_fi" />
              <p>Upload Main Post Image</p>
              <img id="previewImg" src="<?php echo $curPost["postCover"]; ?>" alt="" />
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                  <path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152L0 424c0 48.6 39.4 88 88 88l272 0c48.6 0 88-39.4 88-88l0-112c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 112c0 22.1-17.9 40-40 40L88 464c-22.1 0-40-17.9-40-40l0-272c0-22.1 17.9-40 40-40l112 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L88 64z"></path>
              </svg>
            </div>
            <p class="error"></p>
          </div>
          <div class="details">
            <div class="sec">
              <label for="title">Poste Title</label>
              <p class="titleNum"><span>0</span> character - (Minimum 20)</p>
              <input id="inptTitle" minlength="20" type="text" name="title" value="<?php echo $curPost["postTitle"]; ?>" required>
            </div>
            <div class="sec">
              <p class="titleContent"><span>0</span> character - (Minimum 200)</p>
              <label for="content">Poste Content</label>
              <textarea id="inptContent" minlength="200" name="content" required><?php echo $curPost["postContent"]; ?></textarea>
            </div>        
            <label for="topics">Choose Topics</label>
            <div class="topics">
              <?php 
                $postTopics = explode(',', $curPost["topics"]);
              ?>
              <?php foreach ($AllTopics as $topic): ?>
                <div class="topic">
                  <input type="checkbox" <?php echo in_array($topic['name'],$postTopics) ?"checked" :""; ?> value="<?php echo $topic['id'] ?>" name="topics[]" />
                  <label><?php echo $topic['name']; ?></label>
                </div>
              <?php endforeach; ?>
            </div>
            <?php if (!empty($errors)): ?>
                <ul class="errorsList">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <button type="submit" class="btn">Save</button>
          </div>
      </form>
    </div>
</div>
<!-- Footer -->
<?php include("footer.php") ?>
<!-- Js -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="js/post.js"></script>
</body>
</html>