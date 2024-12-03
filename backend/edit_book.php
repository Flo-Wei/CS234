<?php
require_once '../includes/session_handler.inc.php';
require_once '../includes/dbh.inc.php';

// Check if user is admin
if ($_SESSION['Role'] != 'admin') {
    header('Location: ../index.php');
    exit;
}

// Validate POST data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book_id'])) {
    $book_id = intval($_POST['book_id']);
    $title = $_POST['title'] ?? '';
    $author_name = !empty($_POST['author_name']) ? $_POST['author_name'] : null;
    $publisher_name = !empty($_POST['publisher_name']) ? $_POST['publisher_name'] : null;
    $publication_date = !empty($_POST['publication_date']) ? $_POST['publication_date'] : null;
    $isbn = !empty($_POST['isbn']) ? $_POST['isbn'] : null;
    $genre = !empty($_POST['genre']) ? $_POST['genre'] : null;
    $description = !empty($_POST['description']) ? $_POST['description'] : null;
    $cover_image_url = !empty($_POST['cover_image_url']) ? $_POST['cover_image_url'] : null;

    try {
        // Update book in the database
        $stmt = $pdo->prepare(
            'UPDATE books 
             SET Title = :title, 
                 AuthorID = :author_name, 
                 PublisherID = :publisher_name, 
                 PublicationDate = :publication_date, 
                 ISBN = :isbn, 
                 Genre = :genre, 
                 Description = :description, 
                 CoverImageURL = :cover_image_url 
             WHERE BookID = :book_id'
        );

        $stmt->execute([
            'title' => $title,
            'author_name' => $author_name,
            'publisher_name' => $publisher_name,
            'publication_date' => $publication_date,
            'isbn' => $isbn,
            'genre' => $genre,
            'description' => $description,
            'cover_image_url' => $cover_image_url,
            'book_id' => $book_id
        ]);

        header('Location: ../library_all.php?message=Book+updated+successfully');
        exit;

    } catch (PDOException $e) {
        // Handle duplicate entry error
        if ($e->getCode() == 23000) {
            header('Location: ../admin_edit_book.php?book_id=' . $book_id . '&error=Duplicate+ISBN');
        } else {
            // Handle other database errors
            header('Location: ../admin_edit_book.php?book_id=' . $book_id . '&error=Database+Error');
        }
        exit;
    }
} else {
    header('Location: ../library_all.php?error=Invalid+Request');
    exit;
}
