<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in | WessBlog</title>
    <!-- CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./style/main.css">
</head>
<body>
<div class="container mx-auto px-6 py-4">
    <!-- Header -->
    <?php include __DIR__ . "/../header.php" ?>
    <!-- Page Content -->
    <div class="auth">
        <h2>Sign in</h2>
        <form action="/blog/public/?action=login" method="POST">
            <label for="email">Username/Email:</label>
                <input type="text" id="email" name="email" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" minlength="5" id="password" name="password" required>
            <br>
            <p>Did you not have account ? <a href="?action=register">Sign up</a></p>
            <?php if (!empty($errors)): ?>
                <ul class="errorsList" style="margin-top: 10px !important;">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <button type="submit">Sign in</button>
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