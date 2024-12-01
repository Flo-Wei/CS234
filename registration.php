<!DOCTYPE html>
<html>
    <head>
        <title>Account Registration</title>
    </head>
    <body>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $username = $_POST["username"];
                $password = $_POST["password"];
                $passwordHash = password_hash(password: $password, algo: PASSWORD_BCRYPT);

                // Insert username and password hash into Users table
                try {
                    require_once "includes/dbh.inc.php";

                    $query = "INSERT INTO users (username, password_hash) VALUES (:username, :password_hash);";
                    $stmt = $pdo->prepare(query: $query);
                    $stmt->bindParam(param: ":username", var: $username);
                    $stmt->bindParam(param: ":password_hash", var: $passwordHash);

                    $stmt->execute();

                    $pdo = null;
                    $stmt = null;
                    echo "<p>Your account has been created.</p>";
                    echo "<p><a href='login.php'>Login</a></p></html>";
                    die;
                } catch (PDOException $e) {
                    if ($e->getCode() == 23000) {
                        echo "<p>Username already exists. Please choose a different username.</p>";
                    } else {
                        die("Query failed: " . $e->getMessage());
                    }
                }
            }
        ?>

        <form method="post" action="registration.php">
            <p>
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" autofocus>
            </p>
            <p>
                <label for="password">Password:</label> 
                <input type="password" name="password" id="password">
            </p>
            <input type="submit" value="Create Account">
        </form>
    </body>
</html>