<?php
require_once __DIR__ . '/../auth.php';
require_login();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: sans-serif;
            padding: 1em;
            background: #f5f5f5;
        }

        #chat {
            height: 300px;
            overflow-y: auto;
            background: white;
            padding: 1em;
            border: 1px solid #ccc;
            margin-bottom: 1em;
            border-radius: 8px;
        }

        form {
            display: flex;
            gap: 0.5em;
        }

        input[type="text"] {
            flex: 1;
            padding: 0.5em;
            font-size: 1em;
        }

        button {
            padding: 0.5em 1em;
            font-size: 1em;
        }

        .message {
            margin-bottom: 0.5em;
        }

        .username {
            font-weight: bold;
        }
    </style>
</head>
<body>
<h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?> <a href="logout.php">(Logout)</a></h2>
<div id="chat"></div>

<form id="chat-form" autocomplete="off">
    <input type="text" name="message" id="message" placeholder="Type your message..." required>
    <button type="submit">Send</button>
</form>

<script>
    const chat = document.getElementById('chat');
    let lastLength = 0;

    async function fetchMessages() {
        try {
            const res = await fetch('fetch.php');
            const messages = await res.json();

            // Avoid re-rendering if nothing changed
            if (messages.length === lastLength) return;
            lastLength = messages.length;

            chat.innerHTML = '';
            messages.forEach(m => {
                const p = document.createElement('p');
                p.classList.add('message');
                p.innerHTML = `<span class="username">${m.username}</span>: ${m.message}`;
                chat.appendChild(p);
            });

            chat.scrollTop = chat.scrollHeight;
        } catch (err) {
            console.error('Failed to fetch messages:', err);
        }
    }

    // Fetch messages every 2 seconds
    setInterval(fetchMessages, 2000);
    fetchMessages();

    // Send message
    document.getElementById('chat-form').onsubmit = async e => {
        e.preventDefault();
        const msg = document.getElementById('message');
        const message = msg.value.trim();
        if (!message) return;

        try {
            await fetch('send.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'message=' + encodeURIComponent(message)
            });
            msg.value = '';
            await fetchMessages(); // immediately refresh
        } catch (err) {
            alert("Failed to send message.");
        }
    };
</script>
</body>
</html>
