<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Following Posts - WessBlog</title>
    <!-- CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./public/style/main.css">
</head>
<body class="home foryou">
<!-- Header -->
<div class="container mx-auto px-6 py-4">
    <?php include("header.php") ?>
    <!-- Page content -->
    <div class="s_sc">
        <div class="latest-posts">
            <?php include("home/Posts.php") ?>
        </div>
        <div class="right_side">
            <?php include("home/Trending.php") ?>
            <?php include("home/Explore-topics.php") ?>
        </div>
    </div>
</div>
<!-- Footer -->
<?php include("footer.php") ?>
<!-- JS -->
<body>
</body>
</html>