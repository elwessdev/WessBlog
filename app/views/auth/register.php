<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up | WessBlog</title>
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
        <h2>
            Sign up
            <!-- <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                width="116.000000pt" height="124.000000pt" viewBox="0 0 116.000000 124.000000"
                preserveAspectRatio="xMidYMid meet">
                <g transform="translate(0.000000,124.000000) scale(0.100000,-0.100000)"
                fill="#5171ff" stroke="none">
                <path d="M782 937 l-263 -220 24 -25 25 -25 246 233 c135 128 246 236 246 241
                0 4 -3 10 -7 12 -5 3 -126 -94 -271 -216z"/>
                <path d="M470 702 c0 -14 79 -86 87 -79 4 4 -11 25 -32 47 -38 39 -55 49 -55
                32z"/>
                <path d="M377 642 c-9 -10 -25 -46 -36 -81 l-20 -63 37 7 c78 14 112 26 127
                48 20 29 19 49 -6 81 -25 31 -77 36 -102 8z"/>
                <path d="M199 462 c-64 -33 -92 -76 -91 -138 1 -78 51 -137 131 -155 56 -12
                90 -6 244 43 125 41 130 42 194 31 41 -7 97 -28 144 -52 52 -28 90 -41 116
                -41 l38 1 -30 13 c-16 8 -50 35 -75 61 -100 104 -248 141 -375 95 -234 -84
                -274 -88 -313 -30 -42 62 -21 115 67 172 60 38 23 38 -50 0z"/>
                </g>
            </svg> -->
        </h2>
        <form action="/blog/public/?action=register" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <br>
            <p>Do you have an account ? <a href="?action=login">Sign in</a></p>
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