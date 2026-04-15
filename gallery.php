<?php
/**
 * gallery.php
 * ------------------------------------------------------------
 * Admin view: displays all uploaded images with their titles.
 * Each image has a Delete button that sends the image ID
 * to delete.php via the URL.
 */

// Make sure the user is logged in before they can access this page
require "includes/auth.php";

// Connect to the database
require "includes/connect.php";

// Show the site header
require "includes/header.php";

// Get all images (newest first)
$sql = "SELECT * FROM images ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$images = $stmt->fetchAll();
?>