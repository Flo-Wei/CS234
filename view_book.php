<?php
require_once "includes/session_handler.inc.php"; 
require_once 'includes/dbh.inc.php'; 

if (!isset($_GET['book_id'])) {
    // header("Location: library_all.php");
    // exit;
} else {
    $BookID = intval($_GET['book_id']); // Get BookID from URL safely

    // Fetch book details from the database
    $stmt = $pdo->prepare(
        'SELECT books.*, 
                authors.Name AS AuthorName, 
                publishers.Name AS PublisherName 
         FROM books 
         LEFT JOIN authors ON books.AuthorID = authors.AuthorID 
         LEFT JOIN publishers ON books.PublisherID = publishers.PublisherID 
         WHERE books.BookID = :book_id'
    );
    $stmt->execute(['book_id' => $BookID]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$book) {
        // Redirect if book not found
        // header("Location: library_all.php");
        // exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($book['Title']) ?> - Book Details</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        .book-details {
            max-width: 800px;
            margin: auto;
        }
        .book-image {
            width: 200px;
            height: 300px;
            background-color: #f4f4f4;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
        }
        .book-info {
            padding-left: 20px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <div class="w3-bar w3-dark-grey">
        <?php include_once "includes/nav_items.inc.php"; ?>
    </div>

    <div class="w3-container book-details">
        <h2 class="w3-center"><?= htmlspecialchars($book['Title']) ?></h2>

        <div class="w3-row w3-padding">
            <!-- Book Image -->
            <div class="w3-col s4 w3-center">
                <div class="book-image">
                    <?php if ($book['CoverImageURL']): ?>
                        <img src="<?= htmlspecialchars($book['CoverImageURL']) ?>" alt="Cover Image" style="max-width: 100%; max-height: 100%;">
                    <?php else: ?>
                        <img src="https://t4.ftcdn.net/jpg/07/70/68/85/360_F_770688532_1lSpeaYY1xSDWncJ8g9etCBsCdzIUV2u.jpg" alt="Standard Image" style="max-width: 100%; max-height: 100%;">
                    <?php endif; ?>
                </div>
            </div>

            <!-- Book Info -->
            <div class="w3-col s8 book-info">
                <p><strong>Author:</strong> <?= htmlspecialchars($book['AuthorName'] ?: 'Unknown') ?></p>
                <p><strong>Publisher:</strong> <?= htmlspecialchars($book['PublisherName'] ?: 'Unknown') ?></p>
                <p><strong>Publication Date:</strong> <?= htmlspecialchars($book['PublicationDate'] ?: 'N/A') ?></p>
                <p><strong>ISBN:</strong> <?= htmlspecialchars($book['ISBN'] ?: 'N/A') ?></p>
                <p><strong>Genre:</strong> <?= htmlspecialchars($book['Genre'] ?: 'N/A') ?></p>
                <p><strong>Description:</strong></p>
                <p><?= nl2br(htmlspecialchars($book['Description'] ?: 'No description available.')) ?></p>
            </div>
        </div>

        <!-- Back Button -->
        <div class="w3-center">
            <a href="library_all.php" class="w3-button w3-blue w3-margin-top">Back to Library</a>
        </div>
    </div>
</body>
</html>
