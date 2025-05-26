<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_login();

$message = trim($_POST['message'] ?? '');
if ($message) {
    $stmt = $db->prepare("INSERT INTO messages (user_id, message) VALUES (?, ?)");
    $stmt->execute([current_user()['id'], $message]);
}

header("Location: index.php");