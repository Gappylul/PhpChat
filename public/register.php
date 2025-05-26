<?php
require_once __DIR__ . '/../session.php';
require_once __DIR__ . '/../utils.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = db()->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
    $stmt->bindValue(1, $_POST['username']);
    $stmt->bindValue(2, password_hash($_POST['password'], PASSWORD_BCRYPT));
    try {
        $stmt->execute();
        header('Location: login.php');
        exit;
    } catch (Exception $e) {
        $error = 'Username already exists';
    }
}
?>

<form method="POST">
    <h2>Register</h2>
    <?= isset($error) ? "<p class='error'>$error</p>" : '' ?>

    <div class="form-group">
        <label for="username">Username</label>
        <input id="username" name="username" required>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input id="password" name="password" type="password" required>
    </div>

    <button>Register</button>
    <p><a href="login.php">Register</a></p>
</form>
