<?php
    include "../includes.php";
    $config = parse_ini_file('../config.ini');

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

    $userService = new UserService();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/register_login_style.css">

    <!-- Scripts -->
    <script src="https://unpkg.com/swup@4" defer></script>
    <script src="register_login.js" defer></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Parkinsans:wght@300..800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="blob"></div>
    <main id="login-window">
        <form action="" method="POST">
            <h1>Login</h1>
            <div>
                <label for="email">Email: </label>
                <input type="email" name="email" id="email" required  class="text-input">
            </div>
            <div>
                <label for="password">Password: </label>
                <input type="password" name="password" id="password"  class="text-input">
            </div>

            <input type="submit" value="login" name="login" class="submit-btn">
        </form>
        <a href="register_page.php" class="switch-login-register">Register</a>
        <?php
            if(isset($_POST["login"])){
                $email = $_POST['email'];
                $password = $_POST['password'];

                $user = $userService->selectuserFromEmail($conn, $email);

                if($user == null){
                    echo "Tu Email";
                }else{
                    $passwordTest = password_verify($password, $user->getPassword());
                    if($passwordTest){
                        $_SESSION['user_id'] = $userService->selectUserID($conn, $email);
                        header("Location: homePage.php");   
                    }else{
                        echo "User not found";
                    }
                }
            }
        ?>
    </main>
</body>
</html>