<?php 
require_once "includes/session_handler.inc.php"; 
require_once "includes/dbh.inc.php"; 

// Check if user is admin
if ($_SESSION['Role'] != 'admin') {
    header('Location: index.php');
    exit;
}

// Check if a book ID is provided
if (!isset($_GET['book_id'])) {
    header('Location: library_all.php');
    exit;
}

$book_id = intval($_GET['book_id']);

// Fetch book data
$stmt = $pdo->prepare('SELECT * FROM books WHERE BookID = :book_id');
$stmt->execute(['book_id' => $book_id]);
$book = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$book) {
    echo "<p>Book ID not found</p>";
    echo "<p><a href='library_all.php'>Back to the Library</a></p>";
    die;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Edit Book</title>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    </head>
<body>
    <div class="w3-bar w3-dark-grey">
        <?php include_once "includes/nav_items.inc.php"; ?>
    </div>

    <div class="w3-container">
        <h2>Edit Book</h2>

        <?php 
            if (isset($_GET["error"])) {
                $errors = $_GET["error"];
                echo '<div class="w3-panel w3-red"><ul>';
                echo $errors;
                echo '</ul></div>';
            }
        ?>

        <form class="w3-container" method="post" action="backend/edit_book.php">
            <input type="hidden" name="book_id" value="<?= htmlspecialchars($book_id) ?>">

            <label class="w3-text-black"><b>Title*</b></label>
            <input class="w3-input w3-border" type="text" name="title" value="<?= htmlspecialchars($book['Title']) ?>" required>

            <label class="w3-text-black"><b>Author</b></label>
            <input class="w3-input w3-border" type="text" name="author_name" value="<?= htmlspecialchars($book['AuthorID']) ?>">

            <label class="w3-text-black"><b>Publisher</b></label>
            <input class="w3-input w3-border" type="text" name="publisher_name" value="<?= htmlspecialchars($book['PublisherID']) ?>">

            <label class="w3-text-black"><b>Publication Date</b></label>
            <input class="w3-input w3-border" type="date" name="publication_date" value="<?= htmlspecialchars($book['PublicationDate']) ?>">

            <label class="w3-text-black"><b>ISBN</b></label>
            <input class="w3-input w3-border" type="text" name="isbn" value="<?= htmlspecialchars($book['ISBN']) ?>">

            <label class="w3-text-black"><b>Genre</b></label>
            <input class="w3-input w3-border" type="text" name="genre" value="<?= htmlspecialchars($book['Genre']) ?>">

            <label class="w3-text-black"><b>Description</b></label>
            <textarea class="w3-input w3-border" name="description"><?= htmlspecialchars($book['Description']) ?></textarea>

            <label class="w3-text-black"><b>Cover Image URL</b></label>
            <input class="w3-input w3-border" type="text" name="cover_image_url" value="<?= htmlspecialchars($book['CoverImageURL']) ?>">

            <br>
            <button class="w3-button w3-blue" type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>
