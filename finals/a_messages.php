<?php
session_start();
require_once 'core/dbConfig.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'applicant') {
    header("Location: login.php");
    exit();
}


$stmt = $pdo->prepare("SELECT m.id, m.from_user_id, m.to_user_id, m.message, m.created_at, u.username AS sender_username, u2.username AS recipient_username 
                        FROM messages m
                        JOIN users u ON m.from_user_id = u.id
                        LEFT JOIN users u2 ON m.to_user_id = u2.id
                        WHERE m.from_user_id = ? OR m.to_user_id = ?
                        ORDER BY m.created_at DESC");
$stmt->execute([$_SESSION['user_id'], $_SESSION['user_id']]);
$messages = $stmt->fetchAll();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reply_message'])) {
    $messageContent = $_POST['message'];
    $hrUserId = $_POST['hr_user_id'];  


    $query = "INSERT INTO messages (from_user_id, to_user_id, message, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['user_id'], $hrUserId, $messageContent]);


    header("Location: a_messages.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_message'])) {
    $messageContent = $_POST['message'];
    $hrUserId = $_POST['hr_user_id'];  

    $query = "INSERT INTO messages (from_user_id, to_user_id, message, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['user_id'], $hrUserId, $messageContent]);


    header("Location: a_messages.php");
    exit();
}


function getHRUsers() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id, username FROM users WHERE role = 'hr'");
    $stmt->execute();
    return $stmt->fetchAll();
}

$hrUsers = getHRUsers();  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Messages</title>
    <style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #e3f2fd;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 90%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    h1 {
        text-align: center;
        color: #0d47a1;
        margin-bottom: 20px;
        font-size: 2.5em;
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

    select, textarea {
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
    <div class="container">
        <h1>Messages</h1>
        <nav>
            <a href="a_dash.php">Back to Dashboard</a> |
            <a href="core/handleForms.php?logoutAUser=1">Logout</a>
        </nav>

        <h2>Send Message to HR</h2>
        <form method="POST" action="a_messages.php">
            <label for="hr_user_id">Select HR User:</label>
            <select name="hr_user_id" id="hr_user_id" required>
                <?php
                foreach ($hrUsers as $hr) {
                    echo "<option value='" . $hr['id'] . "'>" . htmlspecialchars($hr['username']) . "</option>";
                }
                ?>
            </select>

            <label for="message">Your Message:</label>
            <textarea name="message" id="message" rows="4" required></textarea>

            <button type="submit" name="send_message">Send Message</button>
        </form>

        <h2>Message History</h2>
        <?php if (!empty($messages)): ?>
            <ul class="message-history">
                <?php foreach ($messages as $message): ?>
                    <li class="message-item">
                        <?php
                        if ($message['from_user_id'] == $_SESSION['user_id']) {
                            echo "<strong>To: " . htmlspecialchars($message['recipient_username']) . "</strong>";
                        } else {
                            echo "<strong>From: " . htmlspecialchars($message['sender_username']) . "</strong>";
                        }
                        ?>
                        <p><?php echo nl2br(htmlspecialchars($message['message'])); ?></p>
                        <p><small>Sent/Received on: <?php echo htmlspecialchars($message['created_at']); ?></small></p>

                        <?php if ($message['from_user_id'] != $_SESSION['user_id']): ?>
                            <div class="reply-form">
                                <form method="POST" action="a_messages.php">
                                    <textarea name="message" rows="4" required placeholder="Your reply..."></textarea>
                                    <input type="hidden" name="hr_user_id" value="<?php echo $message['from_user_id']; ?>">
                                    <button type="submit" name="reply_message">Send Reply</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="no-messages">No messages available.</p>
        <?php endif; ?>
    </div>
</body>
</html>
