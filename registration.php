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

                // Define regex patterns
                $usernameRegex = '/^.{4,}$/'; // At least 4 characters
                $passwordRegex = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/'; // At least 8 characters, 1 uppercase, 1 lowercase, 1 digit, 1 special character

                // Validate username
                if (!preg_match($usernameRegex, $username)) {
                    echo "<p>Username must be at least 4 characters long.</p>";
                } 
                // Validate password
                elseif (!preg_match($passwordRegex, $password)) {
                    echo "<p>Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one digit, and one special character.</p>";
                } 
                // Proceed if validation passes
                else {
                    $passwordHash = password_hash(password: $password, algo: PASSWORD_BCRYPT);

                    // Insert username and password hash into Users table
                    try {
                        require_once "includes/dbh.inc.php";

                        $query = "INSERT INTO users (Username, PasswordHash) VALUES (:username, :password_hash);";
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
        <p>
            <a href="login.php">I already have an Account</a>
        </p>
    </body>
</html>