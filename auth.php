<?php
require_once __DIR__ . '/session.php';

function is_logged_in(): bool {
    return isset($_SESSION['user_id']);
}

function require_login() {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

function login($user_id, $username)
{
    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $username;
}

function logout()
{
    session_destroy();
}

