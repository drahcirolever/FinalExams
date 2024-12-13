<?php
session_start();
require_once 'core/models.php'; 

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'applicant') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
    body {
        font-family: 'Roboto', sans-serif;
        background: linear-gradient(to bottom right, #0d47a1, #85ACE5);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        color: #fff;
    }

    .dashboard-container {
        background-color: rgba(255, 255, 255, 0.9);
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        width: 100%;
        max-width: 400px;
        text-align: center; /* Center the links */
        color: #333;
    }

    h1 {
        font-size: 24px;
        color: #444;
        margin-bottom: 15px;
    }

    h2 {
        font-size: 20px;
        color: #666;
        margin-top: 25px;
    }

    a {
        display: inline-block; /* Ensure the link behaves like a block but stays inline */
        margin: 10px 0;
        font-size: 16px;
        color: #fff;
        text-decoration: none;
        padding: 12px;
        background: linear-gradient(to right, #0d47a1, #85ACE5);
        border-radius: 6px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        font-weight: bold;
        width: auto; /* Let the links adjust their width automatically */
    }

    a:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    a.logout-link {
        color: #fff;
        background: red;
        padding: 12px;
        border-radius: 6px;
        font-weight: bold;
    }

    a.logout-link:hover {
        background: darkred;
        transform: translateY(-3px);
        box-shadow: 0 4px 10px rgba(255, 0, 0, 0.2);
    }

    .welcome-message {
        margin-bottom: 25px;
        font-size: 18px;
        color: #555;
        font-style: italic;
    }
</style>

</head>
<body>
    <div class="dashboard-container">
        <h1>Welcome Applicant: <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
        <p class="welcome-message"> Menu </p>
        
        <a href="jobListings.php">View Job Listings</a>
        <a href="myApplications.php">My Applications</a>
        <a href="a_messages.php">Messages</a> 
        <a href="core/handleForms.php?logoutAUser=1" class="logout-link">Logout</a>

    </div>
</body>
</html>
