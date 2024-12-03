<?php
    // If POST then check submitted username and password
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        session_start();

        // Get values submitted from the form
        $username = $_POST["username"];
        $password = $_POST["password"];

        try {
            require_once "../includes/dbh.inc.php";

            $query = "SELECT UserID, Username, PasswordHash, Role FROM users WHERE Username=:username;";
            $stmt = $pdo->prepare(query: $query);
            $stmt->bindParam(param: ":username", var: $username);

            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count(value: $results) !== 1) {
                $msg = "Incorrect username or password";
                // echo"<p>Incorrect username or password.</p>";
            } else {
                $result = $results[0];
                // See if submitted password matches the hash stored in the Users table  
                if (password_verify(password: $password, hash: $result["PasswordHash"])) {
                    $_SESSION["UserID"] = $result["UserID"];
                    $_SESSION["Username"] = $result["Username"];
                    $_SESSION["Role"] = $result["Role"];
                    header(header: "Location: ../index.php");
                    die;
                } 
                else {
                    $msg = "Incorrect username or password";
                    
                    die;
                    // echo "<p>Incorrect username or password.</p>";
                }
            }

            
            $pdo = null;
            $stmt = null;
            if ($msg){
                header("Location: ../login.php?msg=$msg");
            } 
            die;

        } catch (PDOException $e) {
            echo "$query";
            die("Query failed: " . $e->getMessage());
        }
    } else {
        header("Location: ../login.php");
        die;
    }
