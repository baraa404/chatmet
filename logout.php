<?php
// Include database connection
require_once 'db_connect.php';

// Destroy the session
session_destroy();

// Redirect to login page
header("Location: login.php");
exit;
?>
