<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../utils.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $stmt = db()->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
    $stmt->bindValue(1, $username);
    $stmt->bindValue(2, $password);
    if ($stmt->execute()) {
        header('Location: login.php');
        exit;
    }
    $error = 'Username may already be taken.';
}
?>
<form method="post">
    <h2>Register</h2>
    <?= isset($error) ? "<p>$error</p>" : '' ?>
    <input name="username" required>
    <input name="password" type="password" required>
    <button>Register</button>
    <p><a href="login.php">Login</a></p>
</form>
