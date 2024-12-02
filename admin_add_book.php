<?php
    require_once 'includes/session_handler.inc.php';
    // Check if user is admin
    if ($_SESSION['Role'] != 'admin') {
        header('Location: index.php');
        exit;
    }

    // Include database connection
    require_once 'includes/dbh.inc.php';


    $errors = [];
    $success = false;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'] ?? '';
        $author_name = $_POST['author_name'] ?? '';
        $publisher_name = $_POST['publisher_name'] ?? '';
        $publication_date = $_POST['publication_date'] ?? '';
        $isbn = $_POST['isbn'] ?? '';
        $genre = $_POST['genre'] ?? '';
        $description = $_POST['description'] ?? '';
        $cover_image_url = $_POST['cover_image_url'] ?? '';

        // Validate title field
        if (empty($title)) {
            $errors[] = 'Title is required.';
        }

        // Validate and get AuthorID
        if (!empty($author_name)) {
            // Check if author exists
            $stmt = $pdo->prepare(query: 'SELECT AuthorID FROM authors WHERE Name = :AuthorName');
            $stmt->bindParam(param: ":AuthorName", var: $author_name);
            $author = $stmt->fetch(mode: PDO::FETCH_ASSOC);
            if ($author) {
                $author_id = $author['AuthorID'];
            } else {
                // Insert new author
                $stmt = $pdo->prepare(query: 'INSERT INTO authors (Name) VALUES (:AuthorName)');
                $stmt->bindParam(param: ":AuthorName", var: $author_name);
                $stmt->execute();
                $author_id = $pdo->lastInsertId();
            }
        } else {
            $author_id = null;
        }

        // Validate and get PublisherID
        if (!empty($publisher_name)) {
            // Check if publisher exists
            $stmt = $pdo->prepare(query: 'SELECT PublisherID FROM publishers WHERE Name = :PublishersName');
            $stmt->bindParam(param: ":PublishersName", var: $publisher_name);
            $stmt->execute();
            $publisher = $stmt->fetch(mode: PDO::FETCH_ASSOC);
            if ($publisher) {
                $publisher_id = $publisher['PublisherID'];
            } else {
                // Insert new publisher
                $stmt = $pdo->prepare(query: 'INSERT INTO publishers (Name) VALUES (:PublishersName)');
                $stmt->bindParam(param: ":PublishersName", var: $publisher_name);
                $stmt->execute();
                $publisher_id = $pdo->lastInsertId();
            }
        } else {
            $publisher_id = null;
        }

        // Insert book if no errors
        if (empty($errors)) {
            try {
                $stmt = $pdo->prepare(query: 'INSERT INTO books (Title, AuthorID, PublisherID, PublicationDate, ISBN, Genre, Description, CoverImageURL) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
                $stmt->execute(params: [
                    $title,
                    $author_id,
                    $publisher_id,
                    $publication_date ?: null,
                    $isbn ?: null,
                    $genre ?: null,
                    $description ?: null,
                    $cover_image_url ?: null
                ]);
                $book_id = $pdo->lastInsertId();
                $success = true;
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) { // Integrity constraint violation
                    $errors[] = 'A book with this ISBN already exists.';
                } else {
                    $errors[] = 'Database error: ' . $e->getMessage();
                }
            }
        }
    }

    
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Add New Book</title>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    </head>
<body>
    <div class="w3-bar w3-dark-grey">
        <?php include_once "includes/nav_items.inc.php"; ?>
    </div>

    <div class="w3-container">
        <h2>Add New Book</h2>

        <?php 
            if ($success) {
                header(header: "Location: view_book.php?book_id=$book_id");
                die;
            }

            if (!empty($errors)) {
                echo '<div class="w3-panel w3-red"><ul>';
                foreach ($errors as $error) {
                    echo '<li>' . htmlspecialchars(string: $error) . '</li>';
                }
                echo '</ul></div>';
            }
        ?>

        <form class="w3-container" method="post" action="">

            <label class="w3-text-black"><b>Title*</b></label>
            <input class="w3-input w3-border" type="text" name="title" value="<?= htmlspecialchars(string: $title ?? '') ?>" required>

            <label class="w3-text-black"><b>Author</b></label>
            <input class="w3-input w3-border" type="text" name="author_name" value="<?= htmlspecialchars(string: $author_name ?? '') ?>">

            <label class="w3-text-black"><b>Publisher</b></label>
            <input class="w3-input w3-border" type="text" name="publisher_name" value="<?= htmlspecialchars(string: $publisher_name ?? '') ?>">

            <label class="w3-text-black"><b>Publication Date</b></label>
            <input class="w3-input w3-border" type="date" name="publication_date" value="<?= htmlspecialchars(string: $publication_date ?? '') ?>">

            <label class="w3-text-black"><b>ISBN</b></label>
            <input class="w3-input w3-border" type="text" name="isbn" value="<?= htmlspecialchars(string: $isbn ?? '') ?>">

            <label class="w3-text-black"><b>Genre</b></label>
            <input class="w3-input w3-border" type="text" name="genre" value="<?= htmlspecialchars(string: $genre ?? '') ?>">

            <label class="w3-text-black"><b>Description</b></label>
            <textarea class="w3-input w3-border" name="description"><?= htmlspecialchars(string: $description ?? '') ?></textarea>

            <label class="w3-text-black"><b>Cover Image URL</b></label>
            <input class="w3-input w3-border" type="text" name="cover_image_url" value="<?= htmlspecialchars(string: $cover_image_url ?? '') ?>">

            <br>
            <button class="w3-button w3-blue" type="submit">Add Book</button>
        </form>
    </div>
</body>
</html>
