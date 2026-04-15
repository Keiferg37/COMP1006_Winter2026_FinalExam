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

<main class="container mt-4">
    <h2 class="mb-4">Image Gallery</h2>

    <!-- Show success message if an image was just deleted -->
    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-success">Image deleted successfully.</div>
    <?php endif; ?>

    <!-- Check if there are any images to display -->
    <?php if (empty($images)): ?>
        <p>No images uploaded yet.</p>
    <?php else: ?>

    <?php endif; ?>
</main>