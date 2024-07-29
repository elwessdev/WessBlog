<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - WessBlog</title>
    <!-- CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link href="https://raw.githack.com/ttskch/select2-bootstrap4-theme/master/dist/select2-bootstrap4.css" rel="stylesheet"> 
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style/main.css">
</head>
<body>
<div class="container mx-auto px-6 py-4">
  <!-- Header -->
  <?php include __DIR__ . "/header.php" ?>
  <!-- Page content -->
  <div class="new-post">
      <h2 class="title">
          New Post
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
      <form action="/blog/public/?action=add-post" method="POST" enctype="multipart/form-data">
          <div class="img">
            <div class="add-area">
              <input type="file" name="image" id="image" accept="image/*" class="img_up_fi" required />
              <p>Upload Main Post Image</p>
              <img id="previewImg" alt="" />
            </div>
            <p class="error"></p>
          </div>
          <div class="details">
            <label for="title">Poste Title</label>
            <input type="text" name="title" required>
            <br>
            <label for="content">Poste Content</label>
            <textarea name="content" required></textarea>
            <br>
            <label for="topics">Poste Topics</label>
            <!-- <input type="text" name="topics" required> -->
            <select multiple placeholder="Choose skills" data-allow-clear="1" name="tags">
              <?php foreach ($tags as $tag): ?>
              <option value="<?php echo $tag['id'] ?>"><?php echo $tag['name']; ?></option>
              <?php endforeach; ?>
            </select>
            <p><?php echo $error ?></p>
            <button type="submit" class="btn">Publish</button>
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