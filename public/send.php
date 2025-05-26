<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../utils.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['message'])) {
    $stmt = db()->prepare('INSERT INTO messages (user_id, message) VALUES (?, ?)');
    $stmt->bindValue(1, $_SESSION['user_id'], SQLITE3_INTEGER);
    $stmt->bindValue(2, $_POST['message']);
    $stmt->execute();
}
