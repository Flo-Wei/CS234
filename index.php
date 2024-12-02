<?php require_once "includes/session_handler.inc.php"; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Project Bookshelf - Homepage</title>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    </head>
    <body>
        <div class="w3-bar w3-dark-grey">
            <?php include_once "includes/nav_items.inc.php"; ?>
        </div>

        <!-- Main content of the page -->
        <div>
            <h1>Welcome to the Homepage</h1>
            <p>Your role is: <strong><?php echo htmlspecialchars($role); ?></strong></p>
        </div>
    </body>
</html>