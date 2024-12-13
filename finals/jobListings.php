<?php
session_start();
require_once 'core/models.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'applicant') {
    header("Location: login.php");
    exit();
}


$jobPosts = getAllJobPosts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
    <link rel="stylesheet" href="styles.css">
    <style>
    body {
        font-family: 'Roboto', sans-serif;
        background: linear-gradient(to bottom right, #0d47a1, #85ACE5); /* Gradient background */
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column; /* Allow the navbar and container to stack vertically */
        align-items: center;
        justify-content: flex-start;
        min-height: 100vh;
        color: #fff;
    }

    nav {
        width: 100%;
        background-color: #0d47a1;
        padding: 12px 20px;
        text-align: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Shadow for the navbar */
        position: sticky;
        top: 0; /* Stick navbar to the top */
        z-index: 10;
    }

    nav a {
        color: white;
        padding: 14px 20px;
        text-decoration: none;
        font-size: 18px;
        font-weight: bold;
        border-radius: 6px; /* Rounded corners for links */
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    nav a:hover {
        background-color: #1565c0;
        transform: translateY(-3px); /* Slight lift effect on hover */
    }

    .container {
        width: 100%;
        max-width: 1200px;
        margin-top: 20px;
        padding: 30px;
        background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent background */
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        text-align: center;
    }

    h1 {
        color: #0d47a1;
        text-align: center;
        margin-bottom: 30px;
        font-size: 2.5em;
    }

    .job-post {
        background-color: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    .job-post h2 {
        color: #0d47a1;
        margin-bottom: 10px;
    }

    .job-post p {
        color: #555;
        margin-bottom: 20px;
    }

    .apply-form {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .apply-form textarea,
    .apply-form input[type="file"] {
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 16px;
    }

    .apply-form button {
        background-color: #0d47a1;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 6px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s;
    }

    .apply-form button:hover {
        background-color: #1565c0;
        transform: scale(1.05);
    }

    .apply-form input[type="file"] {
        padding: 8px;
    }

    .error-message {
        color: red;
        text-align: center;
        margin-top: 20px;
    }
</style>


    </style>
</head>
<body>
    <nav>
        <a href="a_dash.php">Dashboard</a>
        <a href="myApplications.php">My Applications</a>
        <a href="a_messages.php">Messages</a>
        <a href="logout.php">Logout</a>
    </nav>

    <div class="container">
        <h1>Available Job Listings</h1>

        <?php
        if (empty($jobPosts)) {
            echo "<p>No job listings available at the moment.</p>";
        } else {
            foreach ($jobPosts as $job) {
                echo "<div class='job-post'>";
                echo "<h2>" . htmlspecialchars($job['title']) . "</h2>";
                echo "<p>" . htmlspecialchars($job['description']) . "</p>";

                echo "<form action='core/handleForms.php' method='POST' enctype='multipart/form-data' class='apply-form'>";
                echo "<input type='hidden' name='job_post_id' value='" . $job['id'] . "'>";
                echo "<textarea name='cover_message' placeholder='Why are you the best candidate for this job?' required></textarea>";
                echo "<input type='file' name='resume' accept='.pdf' required>";
                echo "<button type='submit' name='applyJobBtn'>Apply</button>";
                echo "</form>";
                echo "</div>";
            }
        }
        ?>
    </div>
</body>
</html>
