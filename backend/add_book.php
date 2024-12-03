<?php
    require_once '../includes/session_handler.inc.php';
    // Check if user is admin
    if ($_SESSION['Role'] != 'admin') {
        header('Location: index.php');
        exit;
    }

    // Include database connection
    require_once '../includes/dbh.inc.php';


    $errors = [];

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
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) { // Integrity constraint violation
                    $errors[] = 'A book with this ISBN already exists.';
                } else {
                    $errors[] = 'Database error: ' . $e->getMessage();
                }
            }
        }
        if (empty($errors)){
            header(header: "Location: ../view_book.php?book_id=$book_id");
        } else {
            $errormsg = "";
            foreach ($errors as $error) {
                $errormsg .= '<li>' . htmlspecialchars(string: $error) . '</li>';
            }
            header("Location: ../admin_add_book.php?error=$errormsg");
        }
        die;
    }

    
?>