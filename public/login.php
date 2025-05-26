<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../utils.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = db()->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->bindValue(1, $_POST['username']);
    $res = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

    if ($res && password_verify($_POST['password'], $res['password'])) {
        login($res['id'], $res['username']);
        header('Location: index.php');
        exit;
    }
    $error = 'Invalid login';
}
?>
<form method="post">
    <h2>Login</h2>
    <?= isset($error) ? "<p>$error</p>" : '' ?>
    <input name="username" required>
    <input name="password" type="password" required>
    <button>Login</button>
    <p><a href="register.php">Register</a></p>
</form>
