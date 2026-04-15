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
