<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>nav-bar</title>
    <link rel="stylesheet" href="../css/nav_bar.css">
    <script src="../scripts/nav_bar.js" defer></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Parkinsans:wght@300..800&display=swap" rel="stylesheet">
</head>
<body>
    <!-- nav -->
    <nav>
        <div class="mobile-nav">
            <div class="hamburger" id="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <div id="full-width-nav">
            <ul>
                <li>
                    <a href="home_page.php">
                        <p>Trade</p>
                    </a>
                </li>
                <li>
                    <a href="collection_page.php">
                        <p>Collection</p>
                    </a>
                </li>
                <li>
                    <a href="animal_page.php">
                        <p>Animals</p>
                    </a>
                </li>
                <li>
                    <a href="attribute_page.php">
                        <p>Attributes</p>
                    </a>
                </li>
                <li>
                    <a href="animal_attribute_page.php">
                        <p>Animal-attributes</p>
                    </a>
                </li>
                <li>
                    <a href="user_page.php" class="user">
                        <object id="user-icon" type="image/svg+xml" data="../icons/user-regular.svg"></object>
                        <p>User</p>
                    </a>
                </li>
                <li>
                    <form action="" method="POST">
                        <input type="submit" value="logout" name="logout" class="logout-btn" class="swipe-effect">
                    </form>
                </li>
            </ul>
        </div>
    </nav>
</body>
</html>