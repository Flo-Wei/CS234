<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        body {
            font-family: "Arial", sans-serif;
            background-color: #f5f5f5;
        }
        .login-container {
            max-width: 400px;
            margin: 50px auto;
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
    </style>
</head>
<body>
    <div class="w3-container">
        <div class="login-container w3-card">
            <h2 class="w3-center w3-text-teal">Login</h2>
            
            <!-- Display Message -->
            <?php if (isset($_GET["msg"])): ?>
                <div class="w3-panel w3-pale-red w3-border w3-round">
                    <?= htmlspecialchars($_GET["msg"]) ?>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form method="post" action="backend/login.php">
                <div class="w3-margin-bottom">
                    <label for="username" class="w3-text-black"><b>Username</b></label>
                    <input class="w3-input w3-border" type="text" name="username" id="username" placeholder="Enter your username" autofocus required>
                </div>
                <div class="w3-margin-bottom">
                    <label for="password" class="w3-text-black"><b>Password</b></label>
                    <input class="w3-input w3-border" type="password" name="password" id="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="w3-button w3-teal w3-round">Login</button>
            </form>

            <!-- Create Account Link -->
            <div class="form-link">
                <a href="registration.php" class="w3-text-teal">Create an Account</a>
            </div>
        </div>
    </div>
</body>
</html>
