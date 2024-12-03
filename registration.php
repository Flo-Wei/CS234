<!DOCTYPE html>
<html>
<head>
    <title>Account Registration</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        body {
            font-family: "Arial", sans-serif;
            background-color: #f5f5f5;
        }
        .registration-container {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            border-radius: 8px;
        }
        .w3-button {
            width: 100%;
        }
        .form-link {
            text-align: center;
            margin-top: 15px;
        }
        .banner-container img {
            max-width: 600px; 
            height: auto;
            margin: 0 auto;
            display: block;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="w3-container">
        <!-- Banner -->
        <div class="banner-container w3-center w3-margin-top">
            <img src="other/Banner.jpeg" alt="Banner" class="w3-image">
        </div>

        <!-- Registration Form -->
        <div class="registration-container w3-card">
            <h2 class="w3-center w3-text-teal">Account Registration</h2>

            <!-- Display Messages -->
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $username = $_POST["username"];
                $password = $_POST["password"];

                // Define regex patterns
                $usernameRegex = '/^.{4,}$/'; // At least 4 characters
                $passwordRegex = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/'; // At least 8 characters, 1 uppercase, 1 lowercase, 1 digit, 1 special character

                // Error messages
                $errors = [];

                // Validate username
                if (!preg_match($usernameRegex, $username)) {
                    $errors[] = "Username must be at least 4 characters long.";
                }
                // Validate password
                if (!preg_match($passwordRegex, $password)) {
                    $errors[] = "Password must:
                    <ul>
                        <li>Be at least 8 characters long</li>
                        <li>Include at least one uppercase letter</li>
                        <li>Include at least one lowercase letter</li>
                        <li>Include at least one digit</li>
                        <li>Include at least one special character</li>
                    </ul>";
                }

                // Display Errors
                if (!empty($errors)) {
                    echo "<div class='w3-panel w3-pale-red w3-border w3-round'>";
                    echo "<ul>";
                    foreach ($errors as $error) {
                        echo "<li>" . $error . "</li>";
                    }
                    echo "</ul>";
                    echo "</div>";
                } else {
                    // Proceed if validation passes
                    try {
                        require_once "includes/dbh.inc.php";

                        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

                        $query = "INSERT INTO users (Username, PasswordHash) VALUES (:username, :password_hash);";
                        $stmt = $pdo->prepare($query);
                        $stmt->bindParam(":username", $username);
                        $stmt->bindParam(":password_hash", $passwordHash);

                        $stmt->execute();

                        echo "<div class='w3-panel w3-pale-green w3-border w3-round'><p>Your account has been created successfully.</p></div>";
                        echo "<p class='form-link'><a href='login.php' class='w3-text-teal'>Login</a></p>";
                        die;
                    } catch (PDOException $e) {
                        if ($e->getCode() == 23000) {
                            echo "<div class='w3-panel w3-pale-red w3-border w3-round'><p>Username already exists. Please choose a different username.</p></div>";
                        } else {
                            echo "<div class='w3-panel w3-pale-red w3-border w3-round'><p>Database error: " . $e->getMessage() . "</p></div>";
                        }
                    }
                }
            }
            ?>

            <form method="post" action="registration.php">
                <div class="w3-margin-bottom">
                    <label for="username" class="w3-text-black"><b>Username</b></label>
                    <input class="w3-input w3-border" type="text" name="username" id="username" placeholder="Enter your username" autofocus required>
                </div>
                <div class="w3-margin-bottom">
                    <label for="password" class="w3-text-black"><b>Password</b></label>
                    <input class="w3-input w3-border" type="password" name="password" id="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="w3-button w3-teal w3-round">Create Account</button>
            </form>

            <!-- Login Link -->
            <div class="form-link">
                <a href="login.php" class="w3-text-teal">I already have an Account</a>
            </div>
        </div>
    </div>
</body>
</html>
