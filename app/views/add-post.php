<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - WessBlog</title>
    <?php include("components/favicon.php") ?>
<!-- CSS -->
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" /> -->
    <!-- <link href="https://raw.githack.com/ttskch/select2-bootstrap4-theme/master/dist/select2-bootstrap4.css" rel="stylesheet">  -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./public/style/main.css">
</head>
<body>
<div class="container mx-auto px-6 py-4">
  <!-- Header -->
  <?php include __DIR__ . "/components/header.php" ?>
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
      <form action="?action=add-post" method="POST" enctype="multipart/form-data" class="formAddPost">
          <?php if (!empty($errors)): ?>
            <ul class="errorsList" style="margin-top: 10px !important;">
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
          <?php endif; ?>
          <div class="img">
            <div class="add-area">
              <input type="file" name="image" id="image" accept="image/*" class="img_up_fi" required />
              <p>Upload Main Post Image</p>
              <img id="previewImg" alt="" />
            </div>
            <!-- <div class="drop-zone">
              <span class="drop-zone__prompt">Drop file here or click to upload</span>
              <input type="file" name="myFile" class="drop-zone__input">
            </div> -->
            <p class="error"></p>
          </div>
          <div class="details">
            <div class="sec">
              <label for="title">Poste Title</label>
              <p class="titleContent"><span>0</span> character - (Minimum 20)</p>
              <input minlength="20" type="text" name="title" required onkeydown="validInput(this,20)">
            </div>
            <div class="sec">
              <label for="title">Small Introduction</label>
              <p class="titleContent"><span>0</span> character - (Minimum 50)</p>
              <input minlength="50" type="text" name="introduction" required onkeydown="validInput(this,50)">
            </div>
            <div class="sec" style="margin-bottom: 15px;">
              <label for="content">Poste Content</label>
              <p class="titleContent lengthQuill"><span>0</span> character - (Minimum 200)</p>
              <div id="editor"></div>
              <input type="hidden" name="content" id="content">
            </div>
            <!-- <div class="sec">
              <p class="titleContent"><span>0</span> character - (Minimum 200)</p>
              <label for="content">Poste Content</label>
              <textarea id="inptContent" minlength="200" name="content" required></textarea>
            </div> -->
            <div class="sec">
              <label for="topics">Choose Topics</label>
              <div class="topics">
                <?php foreach ($AllTopics as $topic): ?>
                  <div class="topic">
                    <input type="checkbox" value="<?php echo $topic['id'] ?>" name="topics[]" />
                    <label><?php echo $topic['name']; ?></label>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
            <button type="submit" class="btn">Publish</button>
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
<!-- <script src="public/js/drag-drop.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script src="public/js/post.js"></script>
<script>
  var quill = new Quill('#editor', {
    theme: 'snow',
    modules: {
        toolbar: [
            [{ 'header': [1, 2, false] }],
            ['bold', 'italic', 'underline'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }]
        ]
    }
  });
  document.querySelector('.formAddPost').onsubmit = function(event) {
    document.getElementById('content').value = quill.root.innerHTML;
  }
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