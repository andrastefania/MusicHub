<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Înregistrare</title>
    <link rel="stylesheet" href="public/css/login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body class="center">
    <div class="card">
        <h2>Create new account</h2>

        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" action="index.php?route=signup">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Parolă:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm">Confirmă parola:</label>
            <input type="password" id="confirm" name="confirm" required>

            <button type="submit">Sign Up</button>
        </form>

        <a class="link" href="index.php?route=login">Already have an account? Log in</a>

    </div>
</body>
</html>
