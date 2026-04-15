<?php
/**
 * login.php
 * ------------------------------------------------------------
 * Handles admin login. Validates form input, looks up the user
 * by email, and verifies the password using password_verify().
 * On success, stores user info in the session and redirects
 * to the gallery page.
 */

// Start the session
session_start();

// If already logged in, redirect to gallery
if (!empty($_SESSION['user_id'])) {
    header("Location: gallery.php");
    exit();
}

// Connect to the database
require "includes/connect.php";

// Show the site header
require "includes/header.php";

// Array to store validation errors
$errors = [];

// Check if the form was submitted using POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
}
?>
