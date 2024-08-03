<?php
session_start();
echo "Test de connexion<br>";
echo "POST data: ";
print_r($_POST);
echo "<br>Session data: ";
print_r($_SESSION);
?>
