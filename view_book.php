<?php 
    require_once "includes/session_handler.inc.php"; 
    if (!isset($_GET['book_id'])) {
        $BookID = $GET['book_id'];
        // ToDo view book logic
        echo "Book viewer with GET: <a href='index.php'>Back to Homepage</a>\n";
        var_dump($_GET);
        // header(header: "Location: index.php");
        // die;
    } else {
        echo "Book viewer with GET: <a href='index.php'>Back to Homepage</a>\n";
        var_dump($_GET);
        
        



    }
?>