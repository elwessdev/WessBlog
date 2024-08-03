<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | WessBlog</title>
    <!-- CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./style/main.css">
</head>
<body>
<div class="container mx-auto px-6 py-4">
    <!-- Header -->
    <?php include __DIR__ . "/header.php" ?>
    <!-- Page Content -->
    <div class="auth">
        <h2>
            Reset Password
        </h2>
        <?php if(!isset($done)): ?>
            <form action="/blog/public/?action=reset-password" method="POST">
                <input type="hidden" name="token" value="<?php # echo $user["reset_token"]; ?>">
                <input type="hidden" name="user_id" value="<?php echo $user["id"]; ?>">
                <label for="pwd1">Enter new password:</label>
                <input type="password" minlength="5" id="pwd1" name="pwd1" required>
                <label for="pwd2">Confirm password:</label>
                <input type="password" minlength="5" id="pwd2" name="pwd2" required>
                <?php if (!empty($errors)): ?>
                    <ul class="errorsList" style="margin-top: 10px !important;">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <button type="submit">Save</button>
            </form>
        <?php endif; ?>
        <?php if(isset($done)&&$done==true): ?>
            <p class="done_msg">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg>
                You Password is changed
            </p>
            <a href="?action=login" style="background-color: #5171ff; color: #FFF; border-radius: 5px; font-size: 13px; font-weight: 600; padding: 10px 15px; display: flex; height: fit-content; width: fit-content; margin: 0 auto;">Back to login</a>
        <?php endif; ?>
    </div>
    <!-- Footer -->
    <?php #include __DIR__ . "/../footer.php" ?>
</div>
</body>
</html>