<?php
require_once 'includes/session_handler.inc.php'; // Session handling
require_once 'includes/dbh.inc.php'; // Database connection

// Handle delete request (only for admin)
if ($_SESSION['Role'] === 'admin' && isset($_POST['delete_book_id'])) {
    $book_id = intval($_POST['delete_book_id']);
    $stmt = $pdo->prepare('DELETE FROM books WHERE BookID = :book_id');
    $stmt->execute(['book_id' => $book_id]);
    header('Location: library.php'); // Redirect to refresh the page
    exit;
}

// Search functionality
$search_query = $_GET['search'] ?? '';
if ($search_query) {
    $stmt = $pdo->prepare('SELECT * FROM books WHERE Title LIKE :search_query ORDER BY Title');
    $stmt->execute(['search_query' => '%' . $search_query . '%']);
} else {
    $stmt = $pdo->query('SELECT * FROM books ORDER BY Title');
}
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Library - All Books</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        .book-card {
            margin-bottom: 20px;
        }
        .book-image {
            width: 150px;
            height: 150px;
            background-color: #f4f4f4;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: #666;
        }
        .book-content {
            padding-left: 15px;
        }
        .book-title-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <div class="w3-bar w3-dark-grey">
        <?php include_once "includes/nav_items.inc.php"; ?>
    </div>

    <div class="w3-container">
        <h2>Library - All Books</h2>

        <!-- Search Field -->
        <form method="get" action="library.php" class="w3-margin-bottom">
            <label for="search" class="w3-text-black"><b>Search by Title</b></label>
            <input class="w3-input w3-border" type="text" name="search" id="search" value="<?= htmlspecialchars($search_query) ?>" placeholder="Enter book title">
            <button class="w3-button w3-blue w3-margin-top" type="submit">Search</button>
        </form>

        <?php if (count($books) > 0): ?>
            <?php foreach ($books as $book): ?>
                <!-- Book Card -->
                <div class="w3-card w3-padding w3-margin-bottom book-card">
                    <div class="w3-row">
                        <!-- Image -->
                        <div class="w3-col s3 w3-center">
                            <div class="book-image">
                                <?php if ($book['CoverImageURL']): ?>
                                    <img src="<?= htmlspecialchars($book['CoverImageURL']) ?>" alt="Cover Image" style="max-width: 100%; max-height: 100%;">
                                <?php else: ?>
                                    <img src="https://t4.ftcdn.net/jpg/07/70/68/85/360_F_770688532_1lSpeaYY1xSDWncJ8g9etCBsCdzIUV2u.jpg" alt="Standard Image" style="max-width: 100%; max-height: 100%;">
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="w3-col s9 book-content">
                            <!-- Title and Delete Button -->
                            <div class="book-title-container">
                                <div class="w3-large w3-bold"><?= htmlspecialchars($book['Title']) ?></div>
                                <?php if ($_SESSION['Role'] === 'admin'): ?>
                                    <form method="post" action="library.php" style="display: inline;">
                                        <input type="hidden" name="delete_book_id" value="<?= $book['BookID'] ?>">
                                        <button class="w3-button w3-red" type="submit" onclick="return confirm('Are you sure you want to delete this book?');">Delete</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Description -->
                            <div class="w3-small w3-text-grey w3-margin-top"><?= nl2br(htmlspecialchars($book['Description'] ?: 'No description available.')) ?></div>
                            
                            <!-- Metadata -->
                            <div class="w3-small w3-text-grey w3-margin-top">
                                <?php
                                // Fetch author name
                                $author_name = 'Unknown';
                                if ($book['AuthorID']) {
                                    $stmt = $pdo->prepare('SELECT Name FROM authors WHERE AuthorID = :author_id');
                                    $stmt->bindParam(":author_id", $book['AuthorID']);
                                    $stmt->execute();
                                    $author = $stmt->fetch(PDO::FETCH_ASSOC);
                                    $author_name = $author ? $author['Name'] : 'Unknown';
                                }
                                
                                // Fetch publisher name
                                $publisher_name = 'Unknown';
                                if ($book['PublisherID']) {
                                    $stmt = $pdo->prepare('SELECT Name FROM publishers WHERE PublisherID = :publisher_id');
                                    $stmt->bindParam(":publisher_id", $book['PublisherID']);
                                    $stmt->execute();
                                    $publisher = $stmt->fetch(PDO::FETCH_ASSOC);
                                    $publisher_name = $publisher ? $publisher['Name'] : 'Unknown';
                                }
                                ?>
                                Author: <?= htmlspecialchars($author_name) ?> | 
                                Publisher: <?= htmlspecialchars($publisher_name) ?> | 
                                ISBN: <?= htmlspecialchars($book['ISBN'] ?: 'N/A') ?> | 
                                Genre: <?= htmlspecialchars($book['Genre'] ?: 'N/A') ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="w3-text-grey">No books found.</p>
        <?php endif; ?>
    </div>
</body>
</html>

