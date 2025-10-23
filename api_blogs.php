<?php
session_start();
require_once 'db.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

// GET - List all blogs or get a specific blog
if ($method === 'GET') {
    try {
        if (isset($_GET['id'])) {
            // Get specific blog
            $stmt = $conn->prepare("
                SELECT b.*, u.username 
                FROM blogs b 
                JOIN users u ON b.user_id = u.id 
                WHERE b.id = ?
            ");
            $stmt->execute([$_GET['id']]);
            $blog = $stmt->fetch();
            
            if ($blog) {
                echo json_encode(['success' => true, 'blog' => $blog]);
            } else {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Blog not found']);
            }
        } else {
            // Get all blogs or user's blogs
            if (isset($_GET['user_only']) && $_GET['user_only'] === 'true') {
                $stmt = $conn->prepare("
                    SELECT b.*, u.username 
                    FROM blogs b 
                    JOIN users u ON b.user_id = u.id 
                    WHERE b.user_id = ?
                    ORDER BY b.created_at DESC
                ");
                $stmt->execute([$_SESSION['user_id']]);
            } else {
                $stmt = $conn->query("
                    SELECT b.*, u.username 
                    FROM blogs b 
                    JOIN users u ON b.user_id = u.id 
                    ORDER BY b.created_at DESC
                ");
            }
            $blogs = $stmt->fetchAll();
            echo json_encode(['success' => true, 'blogs' => $blogs]);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database error occurred']);
    }
    exit;
}

// POST - Create new blog
if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!$data) {
        $data = $_POST;
    }
    
    $title = trim($data['title'] ?? '');
    $content = trim($data['content'] ?? '');
    
    if (empty($title) || empty($content)) {
        echo json_encode(['success' => false, 'message' => 'Title and content are required']);
        exit;
    }
    
    try {
        $stmt = $conn->prepare("INSERT INTO blogs (user_id, title, content) VALUES (?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $title, $content]);
        
        $blog_id = $conn->lastInsertId();
        echo json_encode(['success' => true, 'message' => 'Blog created successfully', 'blog_id' => $blog_id]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database error occurred']);
    }
    exit;
}

// PUT - Update blog
if ($method === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $id = $data['id'] ?? null;
    $title = trim($data['title'] ?? '');
    $content = trim($data['content'] ?? '');
    
    if (!$id || empty($title) || empty($content)) {
        echo json_encode(['success' => false, 'message' => 'ID, title and content are required']);
        exit;
    }
    
    try {
        // Check if blog belongs to user
        $stmt = $conn->prepare("SELECT user_id FROM blogs WHERE id = ?");
        $stmt->execute([$id]);
        $blog = $stmt->fetch();
        
        if (!$blog) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Blog not found']);
            exit;
        }
        
        if ($blog['user_id'] != $_SESSION['user_id']) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'You can only edit your own blogs']);
            exit;
        }
        
        $stmt = $conn->prepare("UPDATE blogs SET title = ?, content = ? WHERE id = ?");
        $stmt->execute([$title, $content, $id]);
        
        echo json_encode(['success' => true, 'message' => 'Blog updated successfully']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database error occurred']);
    }
    exit;
}

// DELETE - Delete blog
if ($method === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!$data) {
        parse_str(file_get_contents('php://input'), $data);
    }
    
    $id = $data['id'] ?? $_GET['id'] ?? null;
    
    if (!$id) {
        echo json_encode(['success' => false, 'message' => 'Blog ID is required']);
        exit;
    }
    
    try {
        // Check if blog belongs to user
        $stmt = $conn->prepare("SELECT user_id FROM blogs WHERE id = ?");
        $stmt->execute([$id]);
        $blog = $stmt->fetch();
        
        if (!$blog) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Blog not found']);
            exit;
        }
        
        if ($blog['user_id'] != $_SESSION['user_id']) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'You can only delete your own blogs']);
            exit;
        }
        
        $stmt = $conn->prepare("DELETE FROM blogs WHERE id = ?");
        $stmt->execute([$id]);
        
        echo json_encode(['success' => true, 'message' => 'Blog deleted successfully']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database error occurred']);
    }
    exit;
}

http_response_code(405);
echo json_encode(['success' => false, 'message' => 'Method not allowed']);
?>
