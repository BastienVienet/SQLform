<?php

session_start();
if (is_null($_SESSION['connected'])) {
    $_SESSION['connected'] = false;
}


function connect ($username, $password): bool {
    if ($username === 'Kimo' && $password === 'password') {
        $_SESSION['connected'] = true;
        return true;
    }
    return false;
}

function disconnect () {
    $_SESSION['connected'] = false;
    header('Location: index.php');
}

function isConnected (): bool {
    return $_SESSION['connected'];
}