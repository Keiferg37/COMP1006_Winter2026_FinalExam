<?php
/**
 * register.php
 * ------------------------------------------------------------
 * Allows a new admin user to create an account.
 * Validates all input, checks for duplicates, hashes the
 * password, and inserts the user into the database using PDO.
 */

// Start session so header can check login state
session_start();

// Connect to the database
require "includes/connect.php";

// Show the site header (navigation, Bootstrap, etc.)
require "includes/header.php";

// Array to store validation errors
$errors = [];

// Variable to store a success message if the account is created
$success = "";

// Check if the form was submitted using POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Retrieve and sanitize the username from the form
    $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS));

    // Retrieve and sanitize the email address
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));

    // Retrieve password fields (no sanitizing because passwords may contain special characters)
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Server-side Validation

    // Check that a username was entered
    if ($username === '') {
        $errors[] = "Username is required.";
    }