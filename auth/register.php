<?php
// auth/register.php
session_start();
require_once __DIR__ . '/../config/db.php';

$message = "";

// Process POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Basic input trim & validation
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$username || !$email || !$password) {
        $message = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Email is invalid.";
    } elseif (strlen($password) < 6) {
        $message = "Password must be at least 6 characters.";
    } else {
        // Check existing email
        $stmt = $conn->prepare("SELECT id FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            $message = "Email is already registered.";
        } else {
            // Insert user
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hash);
            if ($stmt->execute()) {
                $message = "Registration successful. You can now log in.";
                // Optionally redirect to login:
                // header("Location: login.php");
                // exit;
            } else {
                $message = "Error: " . $conn->error;
            }
        }
    }
}

include __DIR__ . '/../includes/header.php';
?>

<h2>Register</h2>
<form method="post" action="">
  <label>Username</label><br>
  <input type="text" name="username" required value="<?php echo isset($username) ? htmlentities($username) : ''; ?>"><br>

  <label>Email</label><br>
  <input type="email" name="email" required value="<?php echo isset($email) ? htmlentities($email) : ''; ?>"><br>

  <label>Password</label><br>
  <input type="password" name="password" required><br>

  <button type="submit">Register</button>
</form>

<?php if($message): ?>
  <p class="message"><?php echo htmlentities($message); ?></p>
<?php endif; ?>

<p>Already registered? <a href="login.php">Login here</a></p>

<?php include __DIR__ . '/../includes/footer.php'; ?>
