<?php
require_once 'includes/session_handler.inc.php'; 
require_once 'includes/dbh.inc.php'; 


// Search functionality
$search_query = $_GET['search'] ?? '';
$user_id = $_SESSION['UserID'];
if ($search_query) {
    // Search only within the user's favorite books
    $stmt = $pdo->prepare(
        'SELECT books.* 
         FROM books 
         INNER JOIN favorites 
         ON books.BookID = favorites.BookID 
         WHERE favorites.UserID = :user_id 
         AND books.Title LIKE :search_query 
         ORDER BY books.Title'
    );
    $stmt->execute([
        'user_id' => $user_id,
        'search_query' => '%' . $search_query . '%'
    ]);
} else {
    // Show all favorite books for the logged-in user
    $stmt = $pdo->prepare(
        'SELECT books.* 
         FROM books 
         INNER JOIN favorites 
         ON books.BookID = favorites.BookID 
         WHERE favorites.UserID = :user_id 
         ORDER BY books.Title'
    );
    $stmt->execute(['user_id' => $user_id]);
}
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Library - Favourite Books</title>
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
        .favorite-button {
            background: none;
            border: none;
            cursor: pointer;
        }
        .favorite-button img {
            width: 20px;
            height: 20px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <div class="w3-bar w3-dark-grey">
        <?php include_once "includes/nav_items.inc.php"; ?>
    </div>

    <div class="w3-container">
        <h2>Library - Favourite Books</h2>

        <!-- Search Field -->
        <form method="get" action="library_favourites.php" class="w3-margin-bottom">
            <label for="search" class="w3-text-black"><b>Search by Title</b></label>
            <input class="w3-input w3-border" type="text" name="search" id="search" value="<?= htmlspecialchars($search_query) ?>" placeholder="Enter book title">
            <button class="w3-button w3-blue w3-margin-top" type="submit">Search</button>
        </form>

        <?php if (count($books) > 0): ?>
            <?php foreach ($books as $book): ?>
                <?php
                // Check if the book is already in the user's favourites
                $user_id = $_SESSION['UserID'];
                $stmt = $pdo->prepare('SELECT * FROM favorites WHERE UserID = :user_id AND BookID = :book_id');
                $stmt->execute(['user_id' => $user_id, 'book_id' => $book['BookID']]);
                $is_favourite = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>
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
                            <!-- Title and Favorite/Delete Buttons -->
                            <div class="book-title-container">
                            <div class="w3-large w3-bold"><a href="view_book.php?book_id=<?= $book['BookID'];?>"><?= htmlspecialchars($book['Title']) ?></a></div>
                                <div>
                                    <!-- Delete Button (Admins only) -->
                                    <?php if ($_SESSION['Role'] === 'admin'): ?>
                                        <form method="post" action="backend/delete_book.php" style="display: inline;">
                                            <input type="hidden" name="delete_book_id" value="<?= $book['BookID'] ?>">
                                            <input type="hidden" name="referrer" value="library_favourites.php">
                                            <button class="w3-button w3-red" type="submit" onclick="return confirm('Are you sure you want to delete this book?');">Delete</button>
                                        </form>
                                    <?php endif; ?>
                                    <!-- Favorite Button -->
                                    <form method="post" action="backend/handle_favourites.php" style="display: inline;">
                                        <input type="hidden" name="favourite_book_id" value="<?= $book['BookID'] ?>">
                                        <input type="hidden" name="referrer" value="library_favourites.php">
                                        <button class="favorite-button" type="submit">
                                            <img src="<?= $is_favourite ? 'other/full_star_icon.png' : 'other/empty_star_icon.png' ?>" alt="Favorite">
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Description -->
                            <div class="w3-small w3-text-grey w3-margin-top"><?= nl2br(htmlspecialchars($book['Description'] ?: 'No description available.')) ?></div>
                            
                            <!-- Metadata -->
                            <div class="w3-small w3-text-grey w3-margin-top">
                                <?php
                                // Fetch author and publisher names
                                $author_name = 'Unknown';
                                if ($book['AuthorID']) {
                                    $stmt = $pdo->prepare('SELECT Name FROM authors WHERE AuthorID = :author_id');
                                    $stmt->execute(['author_id' => $book['AuthorID']]);
                                    $author = $stmt->fetch(PDO::FETCH_ASSOC);
                                    $author_name = $author ? $author['Name'] : 'Unknown';
                                }
                                $publisher_name = 'Unknown';
                                if ($book['PublisherID']) {
                                    $stmt = $pdo->prepare('SELECT Name FROM publishers WHERE PublisherID = :publisher_id');
                                    $stmt->execute(['publisher_id' => $book['PublisherID']]);
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
