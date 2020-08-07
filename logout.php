<?php
session_start();
unset($_SESSION['bank']);
header("Location: login.php");
exit;
?>