<?php
session_start();

if(empty($_SESSION["user_id"])){
    header("Location: pages/register_page.php");
}
include "includes.php";

$host = "localhost";
$dbname = "web_projekts";
$username = "root";
$password = "";

$connection = new Connection($host, $dbname, $username, $password);
$connection->connect();
$connObj = $connection->getCoon();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
        <input type="submit" value="logout" name="logout">
    </form>
    <?php
        if(isset($_POST["logout"])){
            session_destroy();
            header("Location: pages/register_page.php");
        }
    ?>
</body>
</html>