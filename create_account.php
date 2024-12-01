<!DOCTYPE html>
<html>
    <head>
        <title>Create Account</title>
    </head>
    <body>
        <?php
            // If POST then create account
            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                // Get values submitted from the form
                $username = $_POST["username"];
                $password = $_POST["password"];
                    
                // Hash the password
                $passwordHash = password_hash($password, PASSWORD_BCRYPT);

                // Insert username and password hash into Users table
                $mysqli = new mysqli("localhost:8889","bookshelf_user","bookshelf_password","project_bookshelf");
                if ($mysqli->connect_error) {
                    die("Connection failed: " . $mysqli->connect_error);
                }
                $sql = "INSERT INTO users (username, password_hash) VALUES ('" . $mysqli->real_escape_string($username) . "', '$passwordHash')";
                if ($mysqli->query($sql)) {
                    echo "<p>Your account has been created.</p>",
                        "<p><a href='login.php'>Login</a></p></html>";
                    die;
                }
                elseif ($mysqli->errno == 1062) {
                    echo "<p>The username <strong>$username</strong> already exists.",
                        "Please choose another.</p>";
                }
                else {
                    die("Error ($mysqli->errno) $mysqli->error");
                }         
            }
        ?>

        <form method="post" action="create_account.php">
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