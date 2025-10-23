<?php
// blog/edit.php
session_start();
require_once __DIR__ . '/../config/db.php';

// Auth check
if (!isset($_SESSION['user_id'])) {
    header("Location: /blog_app/auth/login.php");
    exit;
}

$post_id = intval($_GET['id'] ?? 0);
if (!$post_id) {
    header("Location: /blog_app/index.php");
    exit;
}

// Fetch post and ensure ownership
$stmt = $conn->prepare("SELECT * FROM blogPost WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows !== 1) {
    die("Post not found.");
}
$post = $res->fetch_assoc();

if ($post['user_id'] != $_SESSION['user_id']) {
    die("Unauthorized access.");
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if (!$title || !$content) {
        $message = "Title and content cannot be empty.";
    } else {
        $stmt = $conn->prepare("UPDATE blogPost SET title = ?, content = ? WHERE id = ?");
        $stmt->bind_param("ssi", $title, $content, $post_id);
        if ($stmt->execute()) {
            header("Location: /blog_app/blog/view.php?id={$post_id}");
            exit;
        } else {
            $message = "Error updating: " . $conn->error;
        }
    }
}

include __DIR__ . '/../includes/header.php';
?>

<h2>Edit Post</h2>

<form method="post">
  <label>Title</label><br>
  <input type="text" name="title" required value="<?php echo htmlentities($post['title']); ?>"><br>

  <label>Content</label><br>
  <textarea name="content" required rows="12"><?php echo htmlentities($post['content']); ?></textarea><br>

  <button type="submit">Update</button>
</form>

<?php if($message): ?><p class="message"><?php echo htmlentities($message); ?></p><?php endif; ?>

<?php include __DIR__ . '/../includes/footer.php'; ?>
