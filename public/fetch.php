<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../utils.php';
require_login();

header('Content-Type: application/json');

$res = db()->query('
    SELECT m.message, m.created_at, u.username
    FROM messages m
    JOIN users u ON m.user_id = u.id
    ORDER BY m.created_at DESC LIMIT 50
');

$out = [];
while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
    $out[] = $row;
}
echo json_encode(array_reverse($out), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
