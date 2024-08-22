<?php
// functions.php

if (!function_exists('generateCSRFToken')) {
    function generateCSRFToken() {
        if (!isset($_COOKIE['csrf_token'])) {
            $token = bin2hex(random_bytes(32));
            setcookie('csrf_token', $token, [
                'expires' => time() + 3600,
                'path' => '/',
                'secure' => false, // A changer en true lor du passage en HTTPS
                'httponly' => true,
                'samesite' => 'Strict'
            ]);
            error_log("CSRF Token créé : " . $token);
            // Pour s'assurer que le cookie est défini immédiatement
            $_COOKIE['csrf_token'] = $token;
            return $token;
        }
        error_log("CSRF Token existant : " . $_COOKIE['csrf_token']);
        return $_COOKIE['csrf_token'];
    }
}

if (!function_exists('validateInput')) {
    function validateInput($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }
}
?>

