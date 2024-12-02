<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
    </head>
    <body>
        <?php
            // If POST then check submitted username and password
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                session_start();

                // Get values submitted from the form
                $username = $_POST["username"];
                $password = $_POST["password"];

                try {
                    require_once "includes/dbh.inc.php";

                    $query = "SELECT UserID, Username, PasswordHash, Role FROM users WHERE Username=:username;";
                    $stmt = $pdo->prepare(query: $query);
                    $stmt->bindParam(param: ":username", var: $username);

                    $stmt->execute();
                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (count(value: $results) !== 1) {
                        echo"<p>Incorrect username or password.</p>";
                    } else {
                        $result = $results[0];
                        // See if submitted password matches the hash stored in the Users table  
                        if (password_verify(password: $password, hash: $result["PasswordHash"])) {
                            $_SESSION["UserID"] = $result["UserID"];
                            $_SESSION["Username"] = $result["Username"];
                            $_SESSION["Role"] = $result["Role"];
                            header(header: "Location: index.php");
                            die;
                        } 
                        else {
                            echo "<p>Incorrect username or password.</p>";
                        }
                    }

                    $pdo = null;
                    $stmt = null;

                } catch (PDOException $e) {
                    if ($e->getCode() == 23000) {
                        echo "<p>Username already exists. Please choose a different username.</p>";
                    } else {
                        echo "$query";
                        die("Query failed: " . $e->getMessage());
                    }
                }
            }
        ?>

        <form method="post" action="login.php">
            <p>
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" autofocus>
            </p>
            <p>
                <label for="password">Password:</label> 
                <input type="password" name="password" id="password">
            </p>
            <input type="submit" value="Login">
        </form>
    </body>
</html>