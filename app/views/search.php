<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $keyword; ?> - WessBlog</title>
    <!-- CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style/main.css">
</head>
<body class="home searchPage">
<!-- Header -->
<div class="container mx-auto px-6 py-4">
    <?php include("header.php") ?>
    <!-- Page content -->
    <div class="s_sc">
        <div class="latest-posts">
            <h2 class="title">
                Search For <?php echo ucfirst($keyword); ?>
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