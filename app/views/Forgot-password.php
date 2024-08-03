<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | WessBlog</title>
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
            Forgot Password
        </h2>
        <form action="/blog/public/?action=forgot-password" method="POST">
            <label for="email">Enter Account Email:</label>
            <input type="email" id="email" name="email" required>
            <?php if (!empty($errors)): ?>
                <ul class="errorsList" style="margin-top: 10px !important;">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <button type="submit">Send</button>
        </form>
    </div>
    <!-- Footer -->
    <?php #include __DIR__ . "/../footer.php" ?>
</div>
</body>
</html>