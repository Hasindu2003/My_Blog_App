<?php
// auth/login.php
session_start();
require_once __DIR__ . '/../config/db.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) {
        $message = "Both fields are required.";
    } else {
        $stmt = $conn->prepare("SELECT id, username, password, role FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows === 1) {
            $user = $res->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Successful login
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                header("Location: /blog_app/index.php");
                exit;
            } else {
                $message = "Invalid credentials.";
            }
        } else {
            $message = "No user found with that email.";
        }
    }
}

include __DIR__ . '/../includes/header.php';
?>

<h2>Login</h2>
<form method="post" action="">
  <label>Email</label><br>
  <input type="email" name="email" required value="<?php echo isset($email) ? htmlentities($email) : ''; ?>"><br>

  <label>Password</label><br>
  <input type="password" name="password" required><br>

  <button type="submit">Login</button>
</form>

<?php if($message): ?>
  <p class="message"><?php echo htmlentities($message); ?></p>
<?php endif; ?>

<p>Don't have an account? <a href="register.php">Register here</a></p>

<?php include __DIR__ . '/../includes/footer.php'; ?>
