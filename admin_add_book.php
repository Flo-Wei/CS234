<?php 
require_once "includes/session_handler.inc.php"; 
// Check if user is admin
if ($_SESSION['Role'] != 'admin') {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add New Book</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        body {
            font-family: "Arial", sans-serif;
            background-color: #f5f5f5;
            margin: 0;
        }
        .content-container {
            margin: 30px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .form-header {
            margin-bottom: 20px;
        }
        .w3-button {
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <div class="w3-bar w3-teal">
        <?php include_once "includes/nav_items.inc.php"; ?>
    </div>

    <!-- Main Content -->
    <div class="content-container">
        <h2 class="w3-text-teal w3-center form-header">Add New Book</h2>

        <!-- Error Messages -->
        <?php 
        if (isset($_GET["error"])) {
            $errors = $_GET["error"];
            echo '<div class="w3-panel w3-pale-red w3-border w3-round"><ul>';
            echo $errors;
            echo '</ul></div>';
        }
        ?>

        <!-- Form -->
        <form method="post" action="backend/add_book.php">
            <div class="w3-margin-bottom">
                <label class="w3-text-black"><b>Title*</b></label>
                <input class="w3-input w3-border" type="text" name="title" value="<?= htmlspecialchars($title ?? '') ?>" required>
            </div>

            <div class="w3-margin-bottom">
                <label class="w3-text-black"><b>Author</b></label>
                <input class="w3-input w3-border" type="text" name="author_name" value="<?= htmlspecialchars($author_name ?? '') ?>">
            </div>

            <div class="w3-margin-bottom">
                <label class="w3-text-black"><b>Publisher</b></label>
                <input class="w3-input w3-border" type="text" name="publisher_name" value="<?= htmlspecialchars($publisher_name ?? '') ?>">
            </div>

            <div class="w3-margin-bottom">
                <label class="w3-text-black"><b>Publication Date</b></label>
                <input class="w3-input w3-border" type="date" name="publication_date" value="<?= htmlspecialchars($publication_date ?? '') ?>">
            </div>

            <div class="w3-margin-bottom">
                <label class="w3-text-black"><b>ISBN</b></label>
                <input class="w3-input w3-border" type="text" name="isbn" value="<?= htmlspecialchars($isbn ?? '') ?>">
            </div>

            <div class="w3-margin-bottom">
                <label class="w3-text-black"><b>Genre</b></label>
                <input class="w3-input w3-border" type="text" name="genre" value="<?= htmlspecialchars($genre ?? '') ?>">
            </div>

            <div class="w3-margin-bottom">
                <label class="w3-text-black"><b>Description</b></label>
                <textarea class="w3-input w3-border" name="description"><?= htmlspecialchars($description ?? '') ?></textarea>
            </div>

            <div class="w3-margin-bottom">
                <label class="w3-text-black"><b>Cover Image URL</b></label>
                <input class="w3-input w3-border" type="text" name="cover_image_url" value="<?= htmlspecialchars($cover_image_url ?? '') ?>">
            </div>

            <button class="w3-button w3-teal w3-round" type="submit">Add Book</button>
        </form>
    </div>
</body>
</html>
