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

        // Look up the user by email
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Fetch the user record
        $user = $stmt->fetch();

        // Verify the password against the stored hash
        if ($user && password_verify($password, $user['password'])) {

            // Set session variables to mark the user as logged in
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Redirect to the gallery page
            header("Location: gallery.php");
            exit();
        } else {
            // Login failed - generic error message for security
            $errors[] = "Invalid email or password.";
        }
    }
}
?>

<main class="container mt-4">
    <h2>Login</h2>

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

    <!-- Login form -->
    <form method="post" class="mt-3">

        <!-- Email input -->
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" class="form-control mb-3"
            value="<?= htmlspecialchars($email ?? ''); ?>" required>

        <!-- Password input -->
        <label for="password" class="form-label">Password</label>
        <input type="password" id="password" name="password" class="form-control mb-4" required>

        <!-- Submit button -->
        <button type="submit" class="btn btn-primary">Log In</button>

        <!-- Link to register page -->
        <a href="register.php" class="btn btn-secondary">Register Instead</a>
    </form>
</main>

<?php require "includes/footer.php"; ?>