<?php require_once "includes/session_handler.inc.php"; ?>
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
            if (isset($_GET["error"])) {
                $errors = $_GET["error"];
                echo '<div class="w3-panel w3-red"><ul>';
                echo $errors;
                echo '</ul></div>';
            }
        ?>

        <form class="w3-container" method="post" action="backend/add_book.php">

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
