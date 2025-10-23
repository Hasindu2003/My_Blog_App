<?php
// includes/header.php
// Start session (idempotent) and show nav
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>My Blog App</title>
  <link rel="stylesheet" href="/blog_app/css/style.css">
</head>
<body>
<header class="site-header">
  <div class="container">
    <h1 class="brand"><a href="/blog_app/index.php">My Blog App</a></h1>
    <nav>
      <a href="/blog_app/index.php">Home</a>
      <?php if(isset($_SESSION['user_id'])): ?>
        <a href="/blog_app/blog/create.php">Create</a>
        <a href="/blog_app/auth/logout.php">Logout (<?php echo htmlentities($_SESSION['username']); ?>)</a>
      <?php else: ?>
        <a href="/blog_app/auth/login.php">Login</a>
        <a href="/blog_app/auth/register.php">Register</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
<main class="container">
