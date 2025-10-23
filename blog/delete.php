<?php
// blog/delete.php
session_start();
require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /blog_app/auth/login.php");
    exit;
}

$post_id = intval($_GET['id'] ?? 0);
if (!$post_id) {
    header("Location: /blog_app/index.php");
    exit;
}

// Ensure ownership
$stmt = $conn->prepare("SELECT user_id FROM blogPost WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows !== 1) {
    die("Post not found.");
}
$row = $res->fetch_assoc();
if ($row['user_id'] != $_SESSION['user_id']) {
    die("Unauthorized.");
}

// Delete
$stmt = $conn->prepare("DELETE FROM blogPost WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();

header("Location: /blog_app/index.php");
exit;
