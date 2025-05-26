<?php
require_once __DIR__ . '/../session.php';
require_once __DIR__ . '/../utils.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = db()->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->bindValue(1, $_POST['username']);
    $res = $stmt->execute();
    $user = $res->fetchArray(SQLITE3_ASSOC);
    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: index.php');
        exit;
    }
    $error = 'Invalid credentials';
}
?>

<form method="POST">
    <h2>Login</h2>
    <?= isset($error) ? "<p class='error'>$error</p>" : '' ?>

    <div class="form-group">
        <label for="username">Username</label>
        <input id="username" name="username" required>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input id="password" name="password" type="password" required>
    </div>

    <button>Login</button>
    <p><a href="register.php">Login</a></p>
</form>

