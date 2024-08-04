<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Following Posts - WessBlog</title>
    <?php include("components/favicon.php") ?>
<!-- CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./public/style/main.css">
</head>
<body class="home foryou">
<!-- Header -->
<div class="container mx-auto px-6 py-4">
    <?php include("components/header.php") ?>
    <!-- Page content -->
    <div class="s_sc">
        <div class="latest-posts">
            <?php include("components/Posts.php") ?>
        </div>
        <div class="right_side">
            <?php include("components/Trending.php") ?>
            <?php include("components/Explore-topics.php") ?>
        </div>
    </div>
</div>
<!-- Footer -->
<?php include("components/footer.php") ?>
<!-- JS -->
<body>
</body>
</html>