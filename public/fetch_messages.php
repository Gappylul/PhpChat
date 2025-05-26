<?php
require_once __DIR__ . '/../includes/db.php';

$stmt = $db->query("
    SELECT messages.*, users.username 
    FROM messages 
    JOIN users ON messages.user_id = users.id 
    ORDER BY created_at DESC 
    LIMIT 50
");

$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach (array_reverse($messages) as $msg) {
    echo "<p><strong>" . htmlspecialchars($msg['username']) . "</strong>: " .
        htmlspecialchars($msg['message']) .
        " <small>(" . $msg['created_at'] . ")</small></p>";
}
