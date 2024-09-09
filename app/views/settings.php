<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - WessBlog</title>
    <?php include("components/favicon.php") ?>
<!-- CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./public/style/main.css">
</head>

<body>
    <div class="container mx-auto px-6 py-4">
        <!-- Header -->
        <?php include __DIR__ . "/components/header.php" ?>
        <!-- Page content -->
        <div class="settings">
            <form class="profile-form" action="?action=settings" method="POST" enctype="multipart/form-data">
                <input type="text" name="login-type" value="<?php echo $user["loginType"] ?>" hidden />
                <input type="text" name="prev-photo" value="<?php echo $user["photo_id"] ?>" hidden />
                <input type="text" name="prev-username" value="<?php echo $user["username"] ?>" hidden />
                <input type="text" name="prev-bio" value="<?php echo $user["bio"] ?>" hidden />
                <input type="text" name="prev-email" value="<?php echo $user["email"] ?>" hidden />
                <div class="profile-header">
                    <div class="profile-avatar">
                        <img id="previewImg" src="<?php echo $user["photo"] ?>" />
                        <input id="image" type="file" accept="image/*" name="photo" />
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152L0 424c0 48.6 39.4 88 88 88l272 0c48.6 0 88-39.4 88-88l0-112c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 112c0 22.1-17.9 40-40 40L88 464c-22.1 0-40-17.9-40-40l0-272c0-22.1 17.9-40 40-40l112 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L88 64z" />
                        </svg>
                    </div>
                    <p class="error"></p>
                </div>
                <?php if (!empty($errors)): ?>
                    <ul class="errorsList">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <div class="form-group">
                    <label for="first-name">Username</label>
                    <input type="text" id="first-name" name="username" value="<?php echo $user["username"] ?>">
                </div>
                <div class="form-group">
                    <label for="last-name">Short Bio</label>
                    <textarea id="last-name" name="bio"><?php echo $user["bio"] ?></textarea>
                </div>
                <div class="form-group">
                    <label for="email">Email <?= $user["loginType"]=="google" ?"(Can't change Email when you login with Google)":"" ?></label>
                    <input type="email" id="email" name="email" value="<?php echo $user["email"] ?>" <?= ($user["loginType"]=="google") ?"readonly":"" ?>>
                </div>
                <?php if($user["loginType"]=="manual"): ?>
                    <div class="form-group">
                        <label for="new-password">Current Password</label>
                        <input type="password" id="current-password" name="current-password" autocomplete="new-password">
                    </div>
                    <div class="form-group">
                        <label for="new-password">New Password</label>
                        <input type="password" id="new-password" name="new-password">
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" id="confirm-password" name="confirm-password">
                    </div>
                <?php endif; ?>
                <button type="submit" class="save-btn">Save</button>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <?php include("components/footer.php") ?>
    <!-- Js -->
    <script src="public/js/settings.js"></script>
</body>
</html>