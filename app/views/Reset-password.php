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
        <form action="/blog/public/?action=reset-password" method="POST">
            <input type="hidden" name="token" value="<?php echo $user["reset_token"]; ?>">
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
    </div>
    <!-- Footer -->
    <?php #include __DIR__ . "/../footer.php" ?>
</div>
</body>
</html>