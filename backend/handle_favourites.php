<?php
require_once '../includes/session_handler.inc.php'; 
require_once '../includes/dbh.inc.php'; 


// Handle favourite book request
if (isset($_POST['favourite_book_id'])) {
    $user_id = $_SESSION['UserID'];
    $book_id = intval($_POST['favourite_book_id']);

    // Check if the book is already in the user's favourites
    $stmt = $pdo->prepare('SELECT * FROM favorites WHERE UserID = :user_id AND BookID = :book_id');
    $stmt->execute(['user_id' => $user_id, 'book_id' => $book_id]);
    $favourite = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($favourite) {
        // Remove from favourites
        $stmt = $pdo->prepare('DELETE FROM favorites WHERE UserID = :user_id AND BookID = :book_id');
        $stmt->execute(['user_id' => $user_id, 'book_id' => $book_id]);
    } else {
        // Add to favourites
        $stmt = $pdo->prepare('INSERT INTO favorites (UserID, BookID) VALUES (:user_id, :book_id)');
        $stmt->execute(['user_id' => $user_id, 'book_id' => $book_id]);
    }

    $referrer = $_POST['referrer'] ?? 'index.php';
    header('Location: ../' . htmlspecialchars($referrer)); 
    // header('Location: library_all.php');
    die;
}