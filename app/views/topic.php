<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $topicName." Posts"; ?> - Wess-Blog</title>
    <!-- CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style/main.css">
</head>
<body class="home">
<!-- Header -->
<div class="container mx-auto px-6 py-4">
    <?php include("header.php") ?>
    <!-- Page content -->
    <div class="s_sc">
        <div class="latest-posts">
            <h2 class="title">
                <?php echo ucfirst($topicName); ?> Posts
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
            <div class="posts">
                <?php if (count($topicPosts->fetch_array()) > 0): ?>
                    <?php foreach ($topicPosts as $post): ?>
                        <article class="post">
                            <a href="?action=post&id=<?php echo $post['post_id'] ?>" class="img">
                                <img src="<?php echo $post['img']; ?>">
                            </a>
                            <div class="post-content">
                                <div class="pyt">
                                    <div class="user">
                                        <img src="<?php echo $post['author_img']; ?>" />
                                        <?php if(isset($_SESSION["user_id"]) && $_SESSION["user_id"]==$post["author_id"]): ?>
                                            <a href="?action=my-profile">Me</a>
                                        <?php else: ?>
                                            <a href="?action=user&id=<?php echo $post['author_id']; ?>"><?php echo $post['author_name']; ?></a>
                                        <?php endif; ?>
                                    </div>
                                    <p>
                                        <?php 
                                            $date = new DateTime($post['published_at']);
                                            echo $date->format('F j, Y');
                                        ?>
                                    </p>
                                </div>
                                <a href="?action=post&id=<?php echo $post['post_id'] ?>"><?php echo $post['title']; ?></a>
                                <p><?php echo $post['content']; ?></p>
                                <div class="post-meta">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 16 16"><path fill="#6B6B6B" fill-rule="evenodd" d="m3.672 10.167 2.138 2.14h-.002c1.726 1.722 4.337 2.436 5.96.81 1.472-1.45 1.806-3.68.76-5.388l-1.815-3.484c-.353-.524-.849-1.22-1.337-.958-.49.261 0 1.56 0 1.56l.78 1.932L6.43 2.866c-.837-.958-1.467-1.108-1.928-.647-.33.33-.266.856.477 1.598.501.503 1.888 1.957 1.888 1.957.17.174.083.485-.093.655a.56.56 0 0 1-.34.163.43.43 0 0 1-.317-.135s-2.4-2.469-2.803-2.87c-.344-.346-.803-.54-1.194-.15-.408.406-.273 1.065.11 1.447.345.346 2.31 2.297 2.685 2.67l.062.06c.17.175.269.628.093.8-.193.188-.453.33-.678.273a.9.9 0 0 1-.446-.273S2.501 6.84 1.892 6.23c-.407-.406-.899-.333-1.229 0-.525.524.263 1.28 1.73 2.691.384.368.814.781 1.279 1.246m8.472-7.219c.372-.29.95-.28 1.303.244V3.19l1.563 3.006.036.074c.885 1.87.346 4.093-.512 5.159l-.035.044c-.211.264-.344.43-.74.61 1.382-1.855.963-3.478-.248-5.456L11.943 3.88l-.002-.037c-.017-.3-.039-.71.203-.895" clip-rule="evenodd"></path></svg>
                                        <?php echo $post['likes']; ?>
                                    </span>
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#6B6B6B" viewBox="0 0 16 16"><path fill="#6B6B6B" d="M12.344 11.458A5.28 5.28 0 0 0 14 7.526C14 4.483 11.391 2 8.051 2S2 4.483 2 7.527c0 3.051 2.712 5.526 6.059 5.526a6.6 6.6 0 0 0 1.758-.236q.255.223.554.414c.784.51 1.626.768 2.512.768a.37.37 0 0 0 .355-.214.37.37 0 0 0-.03-.384 4.7 4.7 0 0 1-.857-1.958v.014z"></path></svg>
                                        <?php echo $post['likes']; ?>
                                    </span>
                                </div>
                                <div class="tags">
                                    <?php $topicsPost = explode(',', $post["topics"]);?>
                                    <?php foreach ($topicsPost as $topic): ?>
                                        <a href="?action=topic&name=<?php echo strtolower(trim($topic)); ?>"><?php echo $topic; ?></a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No posts available.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="explore_topics">
            <h2 class="title">
                Explore Topics
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
            <ul class="list">
                <?php foreach ($topics as $topic): ?>
                    <li>
                        <a href="?action=topic&name=<?php echo strtolower($topic["tagName"]); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/></svg>
                            <?php echo $topic["tagName"] ?>
                            <span><?php echo $topic["countTag"] ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<!-- Footer -->
<?php include("footer.php") ?>
<!-- JS -->
<body>
</body>
</html>