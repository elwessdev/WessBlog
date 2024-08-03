<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up | WessBlog</title>
    <!-- CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./public/style/main.css">
</head>
<body>
<div class="container mx-auto px-6 py-4">
    <!-- Header -->
    <?php include __DIR__ . "/../header.php" ?>
    <!-- Page Content -->
    <div class="auth">
        <h2>
            Sign up
        </h2>
        <form action="?action=register" method="POST">
            <label for="username">Username:</label>
            <input type="text" minlength="5" id="username" name="username" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" minlength="5" id="password" name="password" required>
            <br>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" minlength="5" id="confirm_password" name="confirm_password" required>
            <br>
            <p>Do you have an account ? <a href="?action=login">Sign in</a></p>
            <?php if (!empty($errors)): ?>
                <ul class="errorsList" style="margin-top: 10px !important;">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <button type="submit">Sign up</button>
            <?php if (!empty($message)): ?>
                <p style="color:green;"><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>
        </form>
    </div>
    <!-- Footer -->
    <?php #include __DIR__ . "/../footer.php" ?>
</div>
</body>
</html>