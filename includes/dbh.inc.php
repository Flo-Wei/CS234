<?php

// Database connection settings
$host = 'localhost:8889'; // Database host
$dbname = 'project'; // Database name
$db_username = 'root'; // Database username
$db_password = 'root'; // Database password

$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";


try {
    $pdo = new PDO(dsn: $dsn, username: $db_username, password: $db_password);
    $pdo->setAttribute(attribute: PDO::ATTR_ERRMODE, value: PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Database Connection failed: " . $e->getMessage();
}