<?php
function db() {
    static $db = null;
    if ($db === null) {
        $db = new SQLite3(__DIR__ . '/db/chat.sqlite');
    }
    return $db;
}
