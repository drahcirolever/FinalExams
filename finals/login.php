<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FindHire</title>
    <link rel="stylesheet" href="styles.css">
    <style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #e3f2fd;
        background-image: url('215837.gif');
        background-size: cover;
        background-position: center;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .login-container {
        background-color: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
        text-align: center;
    }

    h1 {
        color: #0d47a1;
        margin-bottom: 20px;
        font-size: 2em;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    label {
        text-align: left;
        font-size: 14px;
        color: #555;
    }

    input[type="text"], input[type="password"] {
        padding: 12px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 8px;
        width: 100%;
        box-sizing: border-box;
    }

    input[type="text"]:focus, input[type="password"]:focus {
        border-color: #0d47a1;
        outline: none;
    }

    button {
        background-color: #0d47a1;
        color: white;
        border: none;
        padding: 12px;
        font-size: 16px;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s;
    }

    button:hover {
        background-color: #1565c0;
        transform: scale(1.05);
    }

    .error-message {
        color: red;
        font-size: 14px;
        margin-bottom: 20px;
    }

    p {
        font-size: 14px;
    }

    p a {
        color: #0d47a1;
        text-decoration: none;
    }

    p a:hover {
        text-decoration: underline;
    }
</style>

</head>
<body>
    <div class="login-container">
        <h1>Login to FindHire</h1>
        <?php if (isset($_SESSION['message'])): ?>
            <p class="error-message"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
        <?php endif; ?>
        <form method="POST" action="core/handleForms.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" name="loginUserBtn">Login</button>
        </form>

        <p>Don't have an account? <a href="register.php">Register here</a>.</p>
    </div>
</body>
</html>
