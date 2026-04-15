<?php
session_start();

// Check if the user is logged in
// If not, redirect to the login page
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}