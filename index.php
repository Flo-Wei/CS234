<?php require_once "includes/session_handler.inc.php"; ?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Project Bookshelf - Homepage</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        body {
            font-family: "Arial", sans-serif;
            background-color: #f5f5f5;
            margin: 0;
        }
        .content-container {
            margin: 10px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
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
        <h1 class="w3-text-teal w3-center">Welcome to the Homepage</h1>
        <p class="w3-text-grey w3-center"> Logged in as: <strong><?php echo htmlspecialchars($_SESSION["Username"]); ?></strong> | Role: <strong><?php echo htmlspecialchars($role); ?></strong></p>
        <p class="w3-text-grey w3-center">Explore the library, manage books, or access your favorite books!</p>
        <p><br><br><br></p>
        <p class="w3-text-grey w3-center">This is the Final Project for CS234 by Florian Weigelt<br>
        The Project course of this project can be viewed on <a href="https://github.com/Flo-Wei/CS234-Project" target="_blank">Github</a></p>
        <p class="w3-text-grey w3-center">
            This is the database configuration:<br>
            <img src="other/DatabaseStructure.png" alt="database" width="500">
        </p>

    </div>
</body>
</html>
