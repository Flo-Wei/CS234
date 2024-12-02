<?php // session_handler.inc.php
    session_start(); 
    if (!isset($_SESSION["Username"])) {
        header(header: "Location: login.php");
        die;
     }