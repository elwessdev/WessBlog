<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Post - WessBlog</title>
  <?php include("components/favicon.php") ?>
  <!-- CSS -->
  <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" /> -->
  <!-- <link href="https://raw.githack.com/ttskch/select2-bootstrap4-theme/master/dist/select2-bootstrap4.css" rel="stylesheet">  -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/default.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
  <link rel="stylesheet" href="./public/style/main.css">
</head>
<body class="edit-post">
<div class="container mx-auto px-6 py-4">
  <!-- Header -->
  <?php include __DIR__ . "/components/header.php" ?>
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
        <a target="_blank" href="?action=post&id=<?php echo $curPost["postId"]; ?>">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/></svg>
          View
        </a>
      </h2>
      <form action="?action=edit-post" method="POST" enctype="multipart/form-data" class="formAddPost">
        <input type="hidden" name="postID" value="<?php echo $curPost["postId"]; ?>" />
        <input type="hidden" name="prevCover" value="<?php echo $curPost["postCover"]; ?>" />
        <input type="hidden" name="prevCoverID" value="<?php echo $curPost["postCoverID"]; ?>" />
        <input type="hidden" name="prevIntro" value="<?php echo $curPost["postIntro"]; ?>">
        <input type="hidden" name="prevTitle" value="<?php echo $curPost["postTitle"]; ?>" />
        <input type="hidden" name="prevContent" id="prevContent" value="<?php echo $curPost["postContent"]; ?>" />
        <!-- <input type="hidden" name="prevTopics" value="<?php #echo $curPost["topics"]; ?>" /> -->
        <?php if (!empty($errors)): ?>
              <ul class="errorsList">
                  <?php foreach ($errors as $error): ?>
                      <li><?php echo htmlspecialchars($error); ?></li>
                  <?php endforeach; ?>
              </ul>
          <?php endif; ?>
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
            <p class="titleContent"><span><?php echo strlen($curPost["postTitle"]); ?></span> character - (Minimum 20)</p>
            <input minlength="20" type="text" name="title" onkeyup="validInput(this,20)" value="<?php echo $curPost["postTitle"]; ?>" required>
          </div>
          <div class="sec">
            <label for="title">Small Introduction</label>
            <p class="titleContent"><span><?php echo strlen($curPost["postIntro"]); ?></span> character - (Minimum 50)</p>
            <input minlength="50" type="text" name="intro" value="<?php echo $curPost["postIntro"]; ?>" required onkeyup="validInput(this,50)">
          </div>
          <div class="sec" style="margin-bottom: 15px;">
            <label for="content">Poste Content</label>
            <p class="titleContent lengthQuill"><span>0</span> character - (Minimum 200)</p>
            <div id="editor"></div>
            <input type="hidden" name="content" id="content" value="">
          </div>
          <!-- <div class="sec">
            <p class="titleContent"><span>0</span> character - (Minimum 200)</p>
            <label for="content">Poste Content</label>
            <textarea id="inptContent" minlength="200" name="content" required><?php #echo $curPost["postContent"]; ?></textarea>
          </div>         -->
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
          <button type="submit" class="btn">Save</button>
        </div>
      </form>
    </div>
</div>
<!-- Footer -->
<?php include("components/footer.php") ?>
<!-- Js -->
<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script src="public/js/post.js"></script>
<script>
  var quill = new Quill('#editor', {
    modules: {
      toolbar: [
        [{ 'header': [1, 2, false] }],
        ['bold', 'italic', 'underline'],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        ['code-block']
      ],
      syntax: true,              // Include syntax module
    },
    theme: 'snow',
    placeholder: 'Create your story here...',
  });
  quill.on('text-change', function() {
    var codeBlocks = document.querySelectorAll('pre code');
    codeBlocks.forEach((block) => {
        hljs.highlightBlock(block);
    });
  });


  document.querySelector('.formAddPost').onsubmit = function(event) {
    document.getElementById('content').value = quill.root.innerHTML;
  }
  quill.root.innerHTML = document.getElementById("prevContent").value;
  // Input Valid
  function validInput(e,max){
    e.parentElement.children[1].children[0].textContent=e.parentElement.children[2].value.length;
  }
  quill.on('text-change', ()=>{
    document.querySelector(".lengthQuill span").textContent = quill.getText().length;
  });
</script>
</body>
</html>