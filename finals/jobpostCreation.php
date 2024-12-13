<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'hr') {
    header("Location: ../login.php");
    exit();
}
require_once 'core/dbConfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];

    $sql = "INSERT INTO job_posts (title, description, created_by) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $description, $_SESSION['user_id']]);

    header("Location: hr_dashboard.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Job Post</title>
    <style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #e3f2fd;
        margin: 0;
        padding: 0;
    }

    header {
        background-color: #0d47a1;
        color: white;
        padding: 15px 20px;
        text-align: center;
        border-radius: 0 0 12px 12px;
    }

    h1 {
        margin: 0;
        font-size: 2.5em;
    }

    .container {
        width: 90%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    nav a {
        text-decoration: none;
        color: #0d47a1;
        margin-right: 20px;
        font-weight: bold;
        transition: color 0.3s ease;
    }

    nav a:hover {
        color: #1976d2;
    }

    form {
        background-color: #ffffff;
        padding: 25px;
        margin-bottom: 30px;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
    }

    form:hover {
        transform: scale(1.02);
    }

    form label {
        font-weight: bold;
        display: block;
        margin-bottom: 8px;
        color: #1a237e;
    }

    input[type="text"], select, textarea {
        width: 100%;
        padding: 12px;
        margin: 10px 0;
        border-radius: 6px;
        border: 1px solid #90caf9;
        font-size: 1rem;
    }

    button {
        background-color: #0d47a1;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 6px;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s;
    }

    button:hover {
        background-color: #1565c0;
        transform: scale(1.05);
    }

    .back-link {
        display: block;
        text-align: center;
        margin-top: 20px;
        font-size: 16px;
    }

    .back-link a {
        text-decoration: none;
        color: #0d47a1;
    }

    .back-link a:hover {
        color: #1976d2;
    }

    .message-history {
        list-style-type: none;
        padding: 0;
    }

    .message-item {
        background-color: #ffffff;
        padding: 20px;
        margin-bottom: 15px;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    .message-item strong {
        font-size: 1.2em;
        color: #0d47a1;
    }

    .message-item p {
        margin: 10px 0;
        color: #555;
        font-size: 1rem;
        line-height: 1.6;
    }

    .message-item small {
        color: #90a4ae;
        display: block;
        margin-top: 10px;
    }

    .message-item .reply-form {
        margin-top: 15px;
        background-color: #e3f2fd;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .no-messages {
        text-align: center;
        color: #546e7a;
        font-size: 20px;
        margin-top: 40px;
    }
</style>

</head>
<body>
    <header>
        <h1>Create a New Job Post</h1>
    </header>

    <div class="container">
        <form method="POST" action="jobpostCreation.php">
            <label for="title">Job Title:</label>
            <input type="text" name="title" required>

            <label for="description">Job Description:</label>
            <textarea name="description" required></textarea>

            <button type="submit">Create Job Post</button>
        </form>

        <div class="back-link">
            <a href="hr_dashboard.php">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
