<?php
require_once 'db_connect.php';

requireLogin();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_chat'])) {
    $message = sanitizeInput($_POST['message'] ?? '');
    $response = $_POST['response'] ?? '';

    if (empty($message) || empty($response)) {
        echo json_encode(['success' => false, 'error' => 'Message and response are required']);
        exit;
    }

    try {
        $stmt = $conn->prepare("INSERT INTO chat_history (user_id, message, response) VALUES (?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $message, $response]);

        echo json_encode(['success' => true, 'message' => 'Chat saved successfully']);
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>
