<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_login();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Simple PHP Chat</title>
    <style>
        body { font-family: sans-serif; max-width: 600px; margin: 2rem auto; }
        #chat-box { border: 1px solid #ccc; padding: 10px; height: 300px; overflow-y: scroll; }
    </style>
    <script>
        setInterval(() => {
            fetch('fetch_messages.php')
                .then(res => res.text())
                .then(html => document.getElementById('chat-box').innerHTML = html);
        }, 2000);
    </script>
</head>
<body>

<h2>Chat Room</h2>
<p>Welcome, <?= htmlspecialchars(current_user()['username']) ?>! <a href="logout.php">Logout</a></p>

<div id="chat-box"><?php include __DIR__ . '/fetch_messages.php'; ?></div>

<form action="send_message.php" method="post">
    <input type="text" name="message" placeholder="Your message" required>
    <button type="submit">Send</button>
</form>

</body>
</html>
