<?php
require_once __DIR__ . '/../auth.php';
require_login();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Chat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?> <a href="logout.php">(Logout)</a></h2>
<div id="chat"></div>
<form id="chat-form">
    <input type="text" name="message" id="message" placeholder="Type..." autocomplete="off" required>
    <button>Send</button>
</form>

<script>
    async function fetchMessages() {
        const res = await fetch('fetch.php');
        const messages = await res.json();
        const chat = document.getElementById('chat');
        chat.innerHTML = messages.map(m => `<p><strong>${m.username}</strong>: ${m.message}</p>`).join('');
    }
    setInterval(fetchMessages, 1000);
    fetchMessages();

    document.getElementById('chat-form').onsubmit = async e => {
        e.preventDefault();
        const msg = document.getElementById('message');
        await fetch('send.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'message=' + encodeURIComponent(msg.value)
        });
        msg.value = '';
    };
</script>
</body>
</html>
