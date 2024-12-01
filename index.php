<!DOCTYPE html>
<html>
    <head>
        <title>Library</title>
    </head>
    <body>
        <?php
            session_start();
            if (!isset($_SESSION["username"])) {
                // var_dump($_SESSION);
                header(header: "Location: login.php");
                die;
             }
        ?>

        <h1>Library:</h1>
        <ul>
            <li>Book 1</li>
            <li>Book 2</li>
            <li>Book 3</li>
        </ul>
    </body>
</html>