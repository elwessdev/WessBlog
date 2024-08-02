<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucfirst($name); ?> - WessBlog</title>
    <!-- CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style/main.css">
</head>
<body class="post">
<!-- Header -->
<div class="container mx-auto px-6 py-4">
    <?php include("header.php") ?>
    <!-- Page content -->
    <div class="post_content">
        <h2><?php echo htmlspecialchars($post["postTitle"]) ?></h2>
        <?php if(isset($_SESSION["user_id"]) && $_SESSION["user_id"]==$post["authorId"]): ?>
            <a class="user" href="?action=my-profile">
                <img src="<?php echo $post['authorPhoto']; ?>" />
                <p>Me</p>
            </a>
            <a href="?action=edit-post&id=<?php echo $post["postId"]; ?>" class="edit">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152L0 424c0 48.6 39.4 88 88 88l272 0c48.6 0 88-39.4 88-88l0-112c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 112c0 22.1-17.9 40-40 40L88 464c-22.1 0-40-17.9-40-40l0-272c0-22.1 17.9-40 40-40l112 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L88 64z"/></svg>
                Edit Post
            </a>
        <?php else: ?>
            <a class="user" href="?action=user&id=<?php echo $post['authorId']; ?>">
                <img src="<?php echo $post['authorPhoto']; ?>" />
                <p><?php echo $post['authorName']; ?></p>
            </a>
        <?php endif; ?>
        <div class="tags">
            <?php $topicsPost = explode(',', $post["topics"]);?>
            <?php foreach ($topicsPost as $topic): ?>
                <a href="?action=topic&name=<?php echo strtolower(trim($topic)); ?>"><?php echo $topic; ?></a>
            <?php endforeach; ?>
        </div>
        <div class="img">
            <img src="<?php echo $post["postCover"]; ?>" />
        </div>
        <div class="txt"><?php echo htmlspecialchars($post["postContent"]) ?></div>
        <div class="ld">
            <span class="like-btn" data-postid="<?php echo $post["postId"]; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 16 16"><path fill="#6B6B6B" fill-rule="evenodd" d="m3.672 10.167 2.138 2.14h-.002c1.726 1.722 4.337 2.436 5.96.81 1.472-1.45 1.806-3.68.76-5.388l-1.815-3.484c-.353-.524-.849-1.22-1.337-.958-.49.261 0 1.56 0 1.56l.78 1.932L6.43 2.866c-.837-.958-1.467-1.108-1.928-.647-.33.33-.266.856.477 1.598.501.503 1.888 1.957 1.888 1.957.17.174.083.485-.093.655a.56.56 0 0 1-.34.163.43.43 0 0 1-.317-.135s-2.4-2.469-2.803-2.87c-.344-.346-.803-.54-1.194-.15-.408.406-.273 1.065.11 1.447.345.346 2.31 2.297 2.685 2.67l.062.06c.17.175.269.628.093.8-.193.188-.453.33-.678.273a.9.9 0 0 1-.446-.273S2.501 6.84 1.892 6.23c-.407-.406-.899-.333-1.229 0-.525.524.263 1.28 1.73 2.691.384.368.814.781 1.279 1.246m8.472-7.219c.372-.29.95-.28 1.303.244V3.19l1.563 3.006.036.074c.885 1.87.346 4.093-.512 5.159l-.035.044c-.211.264-.344.43-.74.61 1.382-1.855.963-3.478-.248-5.456L11.943 3.88l-.002-.037c-.017-.3-.039-.71.203-.895" clip-rule="evenodd"></path></svg>
                <span class="nums"><?php echo $post["postLikes"]; ?></span>
                <span class="like_pop">+1</span>
            </span>
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#6B6B6B" viewBox="0 0 16 16"><path fill="#6B6B6B" d="M12.344 11.458A5.28 5.28 0 0 0 14 7.526C14 4.483 11.391 2 8.051 2S2 4.483 2 7.527c0 3.051 2.712 5.526 6.059 5.526a6.6 6.6 0 0 0 1.758-.236q.255.223.554.414c.784.51 1.626.768 2.512.768a.37.37 0 0 0 .355-.214.37.37 0 0 0-.03-.384 4.7 4.7 0 0 1-.857-1.958v.014z"></path></svg>
                0
            </span>
            <p class="date"><?php $date = new DateTime($post["postDate"]); echo $date->format('F j, Y'); ?></p>
        </div>
        <!-- <div class="profile-card">
            <img src="<?php echo $post["photo"] ?>" class="profile-img">
            <div class="infos">
                <a href="?action=user&name=<?php echo $post["username"] ?>" class="profile-name"><?php echo $post["username"] ?></a>
                <p class="profile-bio"><?php echo htmlspecialchars($post["bio"]) ?></p>
                <div class="social-icons">
                    <a href="#" class="social-icon"><img src="twitter-icon.png" alt="Twitter"></a>
                    <a href="#" class="social-icon"><img src="facebook-icon.png" alt="Facebook"></a>
                    <a href="#" class="social-icon"><img src="instagram-icon.png" alt="Instagram"></a>
                    <a href="#" class="social-icon"><img src="pinterest-icon.png" alt="Pinterest"></a>
                    <a href="#" class="social-icon"><img src="medium-icon.png" alt="Medium"></a>
                    <a href="#" class="social-icon"><img src="youtube-icon.png" alt="YouTube"></a>
                </div>
            </div>
        </div> -->
        <div class="comments">
            <h2></h2>
        </div>
    </div>
</div>
<!-- Footer -->
<?php include("footer.php") ?>
<!-- JS -->
<script>
    // Like Button
    var like = document.querySelector(".like-btn");
    like.onclick = () => {
        let postID=like.dataset.postid;
        // console.log(postID);
        addLike(postID);
        document.querySelector(".like_pop").classList.add("show");
        let n = like.children[1];
        n.textContent = Number(n.textContent)+1;
        setTimeout(()=>{
            document.querySelector(".like_pop").classList.remove("show");
        },200);
    }
    function addLike(id){
        fetch("../app/helpers/Clap.php",{
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({postID: id})
        })
        .then(res=>res.text())
        .then(data=>{console.log("data", "clap");})
        .catch(err=>console.log("error", err))
    }
</script>
<body>
</body>
</html>