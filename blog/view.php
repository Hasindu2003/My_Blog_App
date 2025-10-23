<?php
// blog/view.php
require_once __DIR__ . '/../config/db.php';
include __DIR__ . '/../includes/header.php';

$post_id = intval($_GET['id'] ?? 0);
if (!$post_id) {
    echo "<p>Invalid post.</p>";
    include __DIR__ . '/../includes/footer.php';
    exit;
}

$stmt = $conn->prepare("SELECT b.*, u.username FROM blogPost b JOIN user u ON b.user_id = u.id WHERE b.id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows !== 1) {
    echo "<p>Post not found.</p>";
    include __DIR__ . '/../includes/footer.php';
    exit;
}

$post = $res->fetch_assoc();
?>

<article class="single-post">
  <h2><?php echo htmlentities($post['title']); ?></h2>
  <p class="meta">By <?php echo htmlentities($post['username']); ?> • <?php echo $post['created_at']; ?></p>
  <div class="content">
    <?php
    // If you stored plain text or markdown, you could parse markdown here.
    // For now we assume stored content is plain HTML-safe text. Use nl2br for newlines.
    echo nl2br(htmlentities($post['content']));
    ?>
  </div>

  <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['user_id']): ?>
    <div class="post-actions">
      <a href="/blog_app/blog/edit.php?id=<?php echo $post['id']; ?>">Edit</a>
      <a href="/blog_app/blog/delete.php?id=<?php echo $post['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
    </div>
  <?php endif; ?>
</article>

<?php include __DIR__ . '/../includes/footer.php'; ?>
