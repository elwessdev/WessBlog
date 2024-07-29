<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post - Wess-Blog</title>
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
        <h2>A New Language for Photography</h2>
        <div class="img">
            <img src="https://miro.medium.com/v2/resize:fit:720/format:webp/1*Cws_A2jQm3Y3q0yqS1ooFw.png" />
        </div>
        <div class="txt">
            Critiquing and discussing photography, particularly for novices, can be difficult. Most critique is exceptionally subjective — various nice ways to say you don’t like something, and some guesses about what it is you don’t like.
            Here is a more objective language I use to explore image aesthetics. And while I have my preferences — and you can see it in my photographs — these axis provide space for every image and photographer. There’s no right and wrong, no good or bad. Just more or less of various traits, any of which can be isolated and explored.
            Content classification and discussion is easy: this is a still-life, this is a landscape. I’m drawn to modernism; I’m moved by Dorthea Lange. But structure — “composition” in particular — is almost impossible to explain or discuss. I’ve long been repulsed by forming photos through schema (e.g. rule of thirds, et al.) but never really had anything else to replace it with.
            Over the past decade I’ve come to this way of thinking — not a post mortem on image geometry, but a better articulation of what all photographers are doing as they look through their viewfinders, whether they know it or not. I believe these are broad ideas and a structured means for improvement…
        </div>
        <div class="ld">
            <span class="like-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 16 16"><path fill="#6B6B6B" fill-rule="evenodd" d="m3.672 10.167 2.138 2.14h-.002c1.726 1.722 4.337 2.436 5.96.81 1.472-1.45 1.806-3.68.76-5.388l-1.815-3.484c-.353-.524-.849-1.22-1.337-.958-.49.261 0 1.56 0 1.56l.78 1.932L6.43 2.866c-.837-.958-1.467-1.108-1.928-.647-.33.33-.266.856.477 1.598.501.503 1.888 1.957 1.888 1.957.17.174.083.485-.093.655a.56.56 0 0 1-.34.163.43.43 0 0 1-.317-.135s-2.4-2.469-2.803-2.87c-.344-.346-.803-.54-1.194-.15-.408.406-.273 1.065.11 1.447.345.346 2.31 2.297 2.685 2.67l.062.06c.17.175.269.628.093.8-.193.188-.453.33-.678.273a.9.9 0 0 1-.446-.273S2.501 6.84 1.892 6.23c-.407-.406-.899-.333-1.229 0-.525.524.263 1.28 1.73 2.691.384.368.814.781 1.279 1.246m8.472-7.219c.372-.29.95-.28 1.303.244V3.19l1.563 3.006.036.074c.885 1.87.346 4.093-.512 5.159l-.035.044c-.211.264-.344.43-.74.61 1.382-1.855.963-3.478-.248-5.456L11.943 3.88l-.002-.037c-.017-.3-.039-.71.203-.895" clip-rule="evenodd"></path></svg>
                233
                <span class="like_pop">+1</span>
            </span>
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#6B6B6B" viewBox="0 0 16 16"><path fill="#6B6B6B" d="M12.344 11.458A5.28 5.28 0 0 0 14 7.526C14 4.483 11.391 2 8.051 2S2 4.483 2 7.527c0 3.051 2.712 5.526 6.059 5.526a6.6 6.6 0 0 0 1.758-.236q.255.223.554.414c.784.51 1.626.768 2.512.768a.37.37 0 0 0 .355-.214.37.37 0 0 0-.03-.384 4.7 4.7 0 0 1-.857-1.958v.014z"></path></svg>
                3
            </span>
        </div>
        <div class="profile-card">
            <img src="https://api.dicebear.com/9.x/thumbs/svg?seed=rami" class="profile-img">
            <div class="infos">
                <h2 class="profile-name">Katen Doe</h2>
                <p class="profile-bio">Hello, I'm a content writer who is fascinated by content fashion, celebrity and lifestyle. She helps clients bring the right content to the right people.</p>
                <!-- <div class="social-icons">
                    <a href="#" class="social-icon"><img src="twitter-icon.png" alt="Twitter"></a>
                    <a href="#" class="social-icon"><img src="facebook-icon.png" alt="Facebook"></a>
                    <a href="#" class="social-icon"><img src="instagram-icon.png" alt="Instagram"></a>
                    <a href="#" class="social-icon"><img src="pinterest-icon.png" alt="Pinterest"></a>
                    <a href="#" class="social-icon"><img src="medium-icon.png" alt="Medium"></a>
                    <a href="#" class="social-icon"><img src="youtube-icon.png" alt="YouTube"></a>
                </div> -->
            </div>
        </div>
        <div class="comments">
            <h2></h2>
        </div>
    </div>
</div>
<!-- Footer -->
<?php include("footer.php") ?>
<!-- JS -->
<script>
    var like = document.querySelector(".like-btn");
    like.onclick = () => {
        document.querySelector(".like_pop").classList.add("show");
        console.log( document.querySelector(".like_pop"));
        setTimeout(()=>{
            document.querySelector(".like_pop").classList.remove("show");
            console.log( document.querySelector(".like_pop"));
        },200);
    }
</script>
<body>
</body>
</html>