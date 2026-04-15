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

    // Retrieve and sanitize the email
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));

    // Retrieve password (no sanitizing - may contain special characters)
    $password = $_POST['password'] ?? '';

    // -----------------------------
    // Server-side Validation
    // -----------------------------

    // Check that an email was entered
    if ($email === '') {
        $errors[] = "Email is required.";
    }
    // Validate the email format
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email must be a valid email address.";
    }

    // Check that a password was entered
    if ($password === '') {
        $errors[] = "Password is required.";
    }

    // --------------------------------------------------
    // Authenticate the user
    // --------------------------------------------------

    // Only check the database if there are no validation errors
    if (empty($errors)) {

    }
}
?>
