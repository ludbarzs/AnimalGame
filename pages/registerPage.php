<?php
    $host = $config["servername"];
    $dbname = $config["dbname"];
    $username = $config["username"];
    $password = $config["password"];

    session_start();

    if(!empty($_SESSION['user_id'])){
        header("Location: ../index.php");
    }

    $connection = new Connection($host, $dbname, $username, $password);
    $connection->connect();
    $conn = $connection->getCoon();

    $errors = [];
    
    $userService = new UserService();

    if(isset($_POST["register"])){
        $usernameNew = str_replace(" ", "",$_POST["username"]);
        $emailNew = str_replace(" ", "",$_POST["email"]);
        $passwordNew = str_replace(" ", "",$_POST["password"]);

        if(strlen($usernameNew) <= 0){
            $errors['username'] = "Username field is required.";
        }

        if(!filter_var($emailNew, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = "Email field is required.";
        }

        if(strlen($passwordNew) < 6){
            $errors["password"] = "Password must be at least 6 characters long.";
        }

        if (empty($errors)){
            $stmt = $conn->prepare("SELECT * FROM Users WHERE username = :username OR email = :email");
            $stmt->execute([
                ':username' => $usernameNew,
                ':email' => $emailNew
            ]);

            if($stmt->rowCount() > 0){
                $errors["already_exists"] = "Username or email already exists.";
            }else{
                $passwordNew = password_hash($passwordNew, PASSWORD_DEFAULT, ["cost" => 12]);

                $result = $userService->insertUser($conn, $usernameNew, $emailNew, $passwordNew);

                if($result){
                    $_SESSION['user_id'] = $userService->selectUserID($conn, $emailNew);
                    header("Location: registerPage.php");
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regsiter</title>
    <script src="../scripts/register.js" defer></script>
    <link rel="stylesheet" href="styles/loginRegisterStyle.css">
    <script defer src="../scripts/stars.js"></script>
</head>
<body>
    <main>
        <header>
            <div id="minimize">🗕</div>
            <div id="restore">🗖</div>
            <div id="close">✕</div>
        </header>
        <form action="" method="POST" onsubmit="return validateRegistrationForm()">
            <h1>Register</h1>
            <div>
                <label for="username">Username: </label>
                <input type="text" name="username" id="username">
                <span class="error" id="usernameError">
                    <?php if(isset($errors["username"])): ?>
                    <?php echo $errors["username"]?>
                    <?php endif;?>
                </span>
            </div>
            <br>
            <div>
                <label for="email">Email: </label>
                <input type="email" name="email" id="email">

                <span class="error" id="emailError">
                    <?php if(isset($errors["email"])): ?>
                    <?php echo $errors["email"]?>
                    <?php endif;?>
                </span>
            </div>
            <br>
            <div>
                <label for="password">Password: </label>
                <input type="password" name="password" id="password">
                <span class="error" id="passwordError">
                    <?php if(isset($errors["password"])): ?>
                    <?php echo $errors["password"]?>
                    <?php endif;?>
                </span>
            </div>

            <br><br>
            <?php if(isset($errors["already_exists"])): ?>
                <span class="error"><?php echo $errors["already_exists"]?></span>
            <?php endif;?>
            <input type="submit" value="register" name="register">
        </form>
        <a href="loginPage.php">Login</a>
    </main>
</body>
</html>