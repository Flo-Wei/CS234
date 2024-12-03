<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
    </head>
    <body>
        <?php
            if (isset($_GET["msg"])) {
                $msg = $_GET["msg"];
                echo "<p>$msg</p>";
            }
        ?>
        <form method="post" action="backend/login.php">
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
        <p>
            <a href="registration.php">Create an Account</a>
        </p>
    </body>
</html>