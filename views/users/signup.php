<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Creare cont</title>
    <link rel="stylesheet" href="public/css/login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body class="center">

<div class="card">
    <h2>Create New Account</h2>

    <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php?route=signup">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm">Confirm Password</label>
        <input type="password" id="confirm" name="confirm" required>

        <label>Pick a Profile Photo</label>
        <div class="avatar-carousel">
            <button type="button" class="avatar-prev">&#10094;</button>
            <div class="avatar-container">
                <img src="public/images/profile_photos/profile_1.jpeg" class="avatar active" data-path="public/images/profile_photos/profile_1.jpeg">
                <img src="public/images/profile_photos/profile_2.jpeg" class="avatar" data-path="public/images/profile_photos/profile_2.jpeg">
                <img src="public/images/profile_photos/profile_3.jpeg" class="avatar" data-path="public/images/profile_photos/profile_3.jpeg">
                <img src="public/images/profile_photos/profile_4.jpeg" class="avatar" data-path="public/images/profile_photos/profile_4.jpeg">
                <img src="public/images/profile_photos/profile_5.jpeg" class="avatar" data-path="public/images/profile_photos/profile_5.jpeg">
                <img src="public/images/profile_photos/profile_6.jpeg" class="avatar" data-path="public/images/profile_photos/profile_6.jpeg">
            </div>
            <button type="button" class="avatar-next">&#10095;</button>
        </div>

        <input type="hidden" name="profile_image" id="selectedAvatar" value="public/images/profile_photos/profile_1.jpeg">

        <button type="submit">Create account</button>
    </form>

    <a class="link" href="index.php?route=login">Already have an account? Log in</a>
</div>

<script src="public/js/signup.js"></script>

</body>
</html>
