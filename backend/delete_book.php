<?php
require_once '../includes/session_handler.inc.php';
require_once '../includes/dbh.inc.php';
// Handle delete request (only for admin)
if ($_SESSION['Role'] === 'admin' && isset($_POST['delete_book_id'])) {
    var_dump($_POST);
    $book_id = intval($_POST['delete_book_id']);
    $stmt = $pdo->prepare('DELETE FROM books WHERE BookID = :book_id');
    $stmt->execute(['book_id' => $book_id]);

    $referrer = $_POST['referrer'] ?? 'index.php';
    header('Location: ../' . htmlspecialchars($referrer)); 
    exit;
}

