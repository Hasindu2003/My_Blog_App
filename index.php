<?php
// index.php - show list of blogs
require_once __DIR__ . '/config/db.php';
include __DIR__ . '/includes/header.php';

// Fetch posts with author info, newest first
$sql = "SELECT b.id, b.title, b.content, b.created_at, u.id AS user_id, u.username 
        FROM blogPost b
        JOIN user u ON b.user_id = u.id
        ORDER BY b.created_at DESC";
$res = $conn->query($sql);
?>

<h2>All Blogs</h2>

<?php if ($res && $res->num_rows > 0): ?>
  <div class="posts">
    <?php while ($post = $res->fetch_assoc()): ?>
      <article class="post">
        <h3><a href="/blog_app/blog/view.php?id=<?php echo $post['id']; ?>">
            <?php echo htmlentities($post['title']); ?></a></h3>
        <p class="meta">By <?php echo htmlentities($post['username']); ?> • <?php echo $post['created_at']; ?></p>
        <p><?php 
            // show excerpt of content (first 250 chars)
            $excerpt = strip_tags($post['content']);
            if (mb_strlen($excerpt) > 250) {
                echo htmlentities(mb_substr($excerpt, 0, 250)) . '...';
            } else {
                echo htmlentities($excerpt);
            }
         ?></p>
        <a class="read-more" href="/blog_app/blog/view.php?id=<?php echo $post['id']; ?>">Read more</a>
      </article>
    <?php endwhile; ?>
  </div>
<?php else: ?>
  <p>No posts yet. 
  <?php if (isset($_SESSION['user_id'])): ?> 
    <a href="/blog_app/blog/create.php">Create the first post</a>
  <?php endif; ?></p>
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
