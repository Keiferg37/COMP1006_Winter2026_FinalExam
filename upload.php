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

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get and sanitize the title
    $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS));

    // This will store the image path for the database
    $imagePath = null;

    // Validate title - make sure it is not empty
    if ($title === '') {
        $errors[] = "Image title is required.";
    }

    // Validate image upload - check if a file was selected
    if (!isset($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
        $errors[] = "Please select an image to upload.";
    }
    // Check if there was an upload error
    elseif ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "File upload error. Please try again.";
    } else {

        // List of allowed MIME types (only image files)
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

        // Get file information from the upload
        $fileType = $_FILES['image']['type'];
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];

        // Get the file extension and convert to lowercase
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Check that the file type is an allowed image type
        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = "Only JPG, PNG, and WebP images are allowed.";
        }

        // Check that the file extension is allowed
        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
            $errors[] = "Invalid file extension.";
        }
    }

    // If there are no errors, move the file and insert into the database
    if (empty($errors)) {

        // Create a unique file name using time() so files don't overwrite each other
        $newFileName = time() . '_' . $fileName;

        // Set the destination path in the uploads folder
        $destination = 'uploads/' . $newFileName;

        // Move the uploaded file from the temp location to the uploads folder
        if (move_uploaded_file($fileTmpPath, $destination)) {

            // Store the path for the database
            $imagePath = $destination;

            // Insert the image record into the database
            $sql = "INSERT INTO images (title, image_path)
                    VALUES (:title, :image_path)";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':image_path', $imagePath);
            $stmt->execute();

            $success = "Image uploaded successfully!";
        } else {
            $errors[] = "Failed to upload the file. Please try again.";
        }
    }
}
?>

<main class="container mt-4">
    <h2>Upload Image</h2>

    <!-- Display validation errors if any exist -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <h3>Please fix the following:</h3>
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Display success message -->
    <?php if ($success !== ""): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($success); ?>
        </div>
    <?php endif; ?>

    <!-- enctype="multipart/form-data" required for uploads, will not send properly if not included -->
    <form method="post" enctype="multipart/form-data" class="mt-3">

        <!-- Image title input -->
        <label for="title" class="form-label">Image Title</label>
        <input type="text" id="title" name="title" class="form-control mb-3" required>

        <!-- File upload input - only accepts image types -->
        <label for="image" class="form-label">Select Image</label>
        <input type="file" id="image" name="image" class="form-control mb-4"
            accept=".jpg,.jpeg,.png,.webp" required>

        <!-- Submit button -->
        <button type="submit" class="btn btn-primary">Upload Image</button>
    </form>
</main>
