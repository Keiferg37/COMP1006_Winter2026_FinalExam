<?php
/**
 * delete.php
 * ------------------------------------------------------------
 * Deletes an image record from the database and removes
 * the image file from the uploads/ folder.
 * Expects an image ID passed via the URL: delete.php?id=5
 */

// Make sure the user is logged in
require "includes/auth.php";

// Connect to the database
require "includes/connect.php";

// Make sure we received an ID in the URL
if (!isset($_GET['id'])) {
    die("No image ID provided.");
}