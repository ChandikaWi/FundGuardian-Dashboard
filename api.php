<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$host = 'localhost';
$dbname = 'budget_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

$user_id = $_SESSION['user_id'];
$action = $_REQUEST['action'] ?? '';

if ($action === 'get_transactions') {
    $stmt = $pdo->prepare("SELECT * FROM transactions WHERE user_id = ? ORDER BY date DESC, id DESC");
    $stmt->execute([$user_id]);
    $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(['success' => true, 'transactions' => $transactions]);
    
} elseif ($action === 'add_transaction') {
    $description = $_POST['description'] ?? '';
    $amount = $_POST['amount'] ?? 0;
    $type = $_POST['type'] ?? '';
    $category = $_POST['category'] ?? '';
    
    if (empty($description) || empty($amount) || empty($type) || empty($category)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit;
    }
    
    $stmt = $pdo->prepare("INSERT INTO transactions (user_id, description, amount, type, category, date) VALUES (?, ?, ?, ?, ?, CURDATE())");
    
    if ($stmt->execute([$user_id, $description, $amount, $type, $category])) {
        echo json_encode(['success' => true, 'message' => 'Transaction added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add transaction']);
    }
    
} elseif ($action === 'delete_transaction') {
    $id = $_POST['id'] ?? 0;
    
    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'Transaction ID is required']);
        exit;
    }
    
    $stmt = $pdo->prepare("DELETE FROM transactions WHERE id = ? AND user_id = ?");
    
    if ($stmt->execute([$id, $user_id])) {
        echo json_encode(['success' => true, 'message' => 'Transaction deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete transaction']);
    }
    
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
}
?>