<?php
require_once "includes/session_handler.inc.php"; 
require_once 'includes/dbh.inc.php'; 

if (!isset($_GET['book_id'])) {
    header("Location: library_all.php");
    exit;
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
        header("Location: library_all.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($book['Title']) ?> - Book Details</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        body {
            font-family: "Arial", sans-serif;
            background-color: #f5f5f5;
            margin: 0;
        }
        .content {
            padding: 20px;
        }
        .book-details {
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .book-image {
            width: 200px;
            height: 300px;
            background-color: #f4f4f4;
            display: flex;
            align-items: right;
            justify-content: right;
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
        }
        .book-info {
            padding-left: 0px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <div class="w3-bar w3-teal">
        <?php include_once "includes/nav_items.inc.php"; ?>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="book-details">
            <h2 class="w3-text-teal w3-center"><?= htmlspecialchars($book['Title']) ?></h2>

            <div class="w3-row w3-padding">
                <!-- Book Image -->
                <div class="w3-col s3 w3-center">
                    <div class="book-image">
                        <?php if ($book['CoverImageURL']): ?>
                            <img src="<?= htmlspecialchars($book['CoverImageURL']) ?>" alt="Cover Image" style="max-width: 100%; max-height: 100%;">
                        <?php else: ?>
                            <img src="https://t4.ftcdn.net/jpg/07/70/68/85/360_F_770688532_1lSpeaYY1xSDWncJ8g9etCBsCdzIUV2u.jpg" alt="Standard Image" style="max-width: 100%; max-height: 100%;">
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Book Info -->
                <div class="w3-col s7 book-info">
                    <p><strong>Author:</strong> <?= htmlspecialchars($book['AuthorName'] ?: 'Unknown') ?></p>
                    <p><strong>Publisher:</strong> <?= htmlspecialchars($book['PublisherName'] ?: 'Unknown') ?></p>
                    <p><strong>Publication Date:</strong> <?= htmlspecialchars($book['PublicationDate'] ?: 'N/A') ?></p>
                    <p><strong>ISBN:</strong> <?= htmlspecialchars($book['ISBN'] ?: 'N/A') ?></p>
                    <p><strong>Genre:</strong> <?= htmlspecialchars($book['Genre'] ?: 'N/A') ?></p>
                    <p><strong>Description:</strong></p>
                    <p><?= nl2br(htmlspecialchars($book['Description'] ?: 'No description available.')) ?></p>
                </div>
            </div>

            <!-- Buttons -->
            <div class="w3-bar w3-margin-top">
                <a href="library_all.php" class="w3-bar-item w3-button w3-blue w3-right">Back to Library</a>
                <?php if ($_SESSION['Role'] === 'admin'): ?>
                    <a href="admin_edit_book.php?book_id=<?= $BookID ?>" class="w3-bar-item w3-button w3-yellow w3-right w3-margin-right">Edit Book</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
