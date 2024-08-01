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
    <?php foreach ($topics as $topic) : ?>
      <li>
        <a href="?action=topic&name=<?php echo strtolower($topic["tagName"]); ?>">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
            <path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z" />
          </svg>
          <?php echo $topic["tagName"] ?>
          <span><?php echo $topic["countTag"] ?></span>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</div>