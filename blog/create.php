<?php
// blog/create.php
session_start();
require_once __DIR__ . '/../config/db.php';

// Only authenticated users
if (!isset($_SESSION['user_id'])) {
    header("Location: /blog_app/auth/login.php");
    exit;
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if (!$title || !$content) {
        $message = "Title and content are required.";
    } else {
        $stmt = $conn->prepare("INSERT INTO blogPost (user_id, title, content) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $_SESSION['user_id'], $title, $content);
        if ($stmt->execute()) {
            $newId = $stmt->insert_id;
            header("Location: /blog_app/blog/view.php?id={$newId}");
            exit;
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}

include __DIR__ . '/../includes/header.php';
?>

<h2>Create New Post</h2>

<form method="post">
  <label>Title</label><br>
  <input type="text" name="title" required value="<?php echo isset($title) ? htmlentities($title) : ''; ?>"><br>

  <label>Content</label><br>
  <textarea name="content" required rows="12"><?php echo isset($content) ? htmlentities($content) : ''; ?></textarea><br>

    <!-- Category Dropdown -->
    <label>Category:</label><br>
    <select name="category_id" required>
        <option value="">Select Category</option>
        <?php
            include('../config/db.php');
            $result = $conn->query("SELECT * FROM category");
            while($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>{$row['name']}</option>";
            }
            ?>
    </select><br><br>


  <button type="submit">Publish</button>
</form>

<?php if($message): ?><p class="message"><?php echo htmlentities($message); ?></p><?php endif; ?>

<?php include __DIR__ . '/../includes/footer.php'; ?>
