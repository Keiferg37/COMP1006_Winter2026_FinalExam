<?php
/**
 * index.php
 * ------------------------------------------------------------
 * Landing page - redirects logged-in users to the gallery
 * and visitors to the login page.
 */

// Start the session to check login status
session_start();

// If logged in, go to the gallery; otherwise go to login
if (!empty($_SESSION['user_id'])) {
    header("Location: gallery.php");
} else {
    header("Location: login.php");
}
exit;