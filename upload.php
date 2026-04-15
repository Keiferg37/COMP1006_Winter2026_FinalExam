<?php
/**
 * upload.php
 * ------------------------------------------------------------
 * Allows a logged-in admin to upload an image with a title.
 * Validates the title and the uploaded file, restricts uploads
 * to image types only, saves the file to the uploads/ folder,
 * and stores the file path in the database using PDO.
 */

// Make sure the user is logged in before they can access this page
require "includes/auth.php";

// Connect to the database
require "includes/connect.php";

// Show the site header
require "includes/header.php";

// Array for validation errors
$errors = [];

// Success message
$success = "";


?>