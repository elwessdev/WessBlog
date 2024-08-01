<div class="trending">
  <h2 class="title">
    Trending
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
  <div class="articles">
    <?php foreach ($tradingPosts as $post) : ?>
      <div class="sidebar-article">
        <img src="<?php echo $post["img"]; ?>" alt="iPhone">
        <a href="?action=post&id=<?php echo $post['id'] ?>" class="article-info">
          <p><?php echo $post["title"]; ?></p>
          <span>
            <?php
            $date = new DateTime($post["published_at"]);
            echo $date->format('F j, Y');
            ?>
          </span>
        </a>
      </div>
    <?php endforeach; ?>
  </div>
</div>