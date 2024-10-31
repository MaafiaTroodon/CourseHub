<?php
/*
    CSCI 2170: Introduction to Server-Side Scripting
    (Fall Semester 2024)
    Assignment 3 (login.php)
*/

include('../includes/header.php');
require_once '../includes/db.php'; // Include the database connection

// Start a session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Prepare and execute the SQL statement using $mysqli_user for the user database
    $stmt = $mysqli_user->prepare("SELECT id, password FROM users WHERE user_name = ?");
    if (!$stmt) {
        die("Prepare failed: (" . $mysqli_user->errno . ") " . $mysqli_user->error);
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Check if the user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $stored_password);
        $stmt->fetch();

        // Verify the password (plain text comparison if passwords are not hashed)
        if ($password === $stored_password) {
            // Set session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['login_time'] = date('Y-m-d H:i:s');

            // Set a cookie for the last login time (30 days)
            setcookie('last_login_time', $_SESSION['login_time'], time() + (86400 * 30), "/");

            // Regenerate session ID for security
            session_regenerate_id(true);

            // Redirect to dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Invalid username or password.";
    }

    $stmt->close();
}
?>

<h2 class="text-center">Login</h2>
<div class="row justify-content-center mt-4">
    <div class="col-md-4">
        <form method="POST" action="login.php">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <?php if (!empty($error)): ?>
                <p class="text-danger"><?php echo $error; ?></p>
            <?php endif; ?>
            <button type="submit" class="btn btn-warning text-black">Login</button>
        </form>
    </div>
</div>

<?php
include('../includes/footer.php');
?>
