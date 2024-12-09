<?php
require "../includes.php";

$host = "localhost";
$dbname = "web_projekts";
$username = "root";
$password = "";

$connection = new Connection($host, $dbname, $username, $password);
$connection->connect();
$conn = $connection->getCoon();

$animalService = new AnimalService();
$userService = new UserService();
$collectionService = new CollectionService();
    if (isset($_POST['submit'])) {
        $animalID = intval($_POST['animalid']);
        $userID = intval($_POST['userid']);

        $result = $collectionService->insertCollection($conn, $userID, $animalID);
    }
    if (isset($_POST['update'])) {
        $collectionID = $_POST['collectionidUpdate'];
        $animalID = $_POST['animalUpdate'];
        $userID = $_POST['useridUpdate'];

        $result = $collectionService->updateColection($conn, $collectionID, $userID, $animalID);
    }
    if (isset($_POST['delete'])) {
        $collectionID = intval($_POST['collection']);
        $result = $collectionService->deleteCollection($conn, $collectionID);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collection Management</title>
    <link rel="stylesheet" href="../css/collection_page.css">
    <script defer src="../scripts/collection.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Parkinsans:wght@300..800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="line"></div>
    <div class="line"></div>

    <?php include 'nav_bar.php'; ?>

    <main>
        <div class="flex-container">
            <div class="window">
                <form method="post" enctype="multipart/form-data">
                    <h1>Add new collection</h1>
                    <div>
                        <label for="animalid">Select animal: </label>
                        <select id="animal" name="animalid">
                            <?php
                            $animals = $animalService->getAllAnimals($conn);
                            foreach ($animals as $animal): ?>
                                <option id="<?php echo $animal->getAnimalId(); ?>" name="animal"
                                    value="<?php echo $animal->getAnimalId(); ?>">
                                    <?php echo $animal->getAnimalId();
                                    echo ". ";
                                    echo $animal->getName();
                                    echo " ";
                                    echo $animal->getSpecies(); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="userid">Select user: </label>
                        <select id="user" name="userid">
                            <?php
                            $users = $userService->getAllUsers($conn);
                            foreach ($users as $user): ?>
                                <option id="<?php echo $user->getID(); ?>" name="user"
                                    value="<?php echo $user->getID(); ?>">
                                    <?php echo $user->getID();
                                    echo ". ";
                                    echo $user->getUsername();
                                    ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <input type="submit" name="submit" value="Add" class="accent-btn" />
                </form>
            </div>

            <div class="window">
                <form method="post" enctype="multipart/form-data">
                    <h1>Update selected collection</h1>
                    <div>
                        <label for="collectionidUpdate">Select collection: </label>
                        <select name="collectionidUpdate" id="collectionidUpdate">
                            <?php
                            $collections = $collectionService->getAllCollections($conn);
                            foreach ($collections as $collection): ?>
                                <option id="<?php echo $collection->getColectionId(); ?>" name="collection"
                                    value="<?php echo $collection->getColectionId(); ?>">
                                    <?php echo $collection->getColectionId();
                                    echo ". ";
                                    echo $userService->selectuserFromID($conn, $collection->getUserId())->getUsername();
                                    echo " " . $animalService->getAnimalByID($conn, $collection->getAnimalId())->getName(); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="animalidUpdate">Select animal: </label>
                        <select id="animalidUpdate" name="animalUpdate">
                            <?php
                            $animals = $animalService->getAllAnimals($conn);
                            foreach ($animals as $animal): ?>
                                <option id="<?php echo $animal->getAnimalId(); ?>" name="animal"
                                    value="<?php echo $animal->getAnimalId(); ?>">
                                    <?php echo $animal->getAnimalId();
                                    echo ". ";
                                    echo $animal->getName();
                                    echo " ";
                                    echo $animal->getSpecies(); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="useridUpdate">Select user: </label>
                        <select id="useridUpdate" name="useridUpdate">
                            <?php
                            $users = $userService->getAllUsers($conn);
                            foreach ($users as $user): ?>
                                <option id="<?php echo $user->getID(); ?>" name="user"
                                    value="<?php echo $user->getID(); ?>">
                                    <?php echo $user->getID();
                                    echo ". ";
                                    echo $user->getUsername();
                                    ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <input type="submit" name="update" value="Update" class="accent-btn" />
                </form>
            </div>

            <div class="window">
                <form method="post" enctype="multipart/form-data">
                    <h1>Delete selected collection</h1>
                    <div>
                        <label for="collectionid">Select collection: </label>
                        <select name="collection" id="collectionid">
                            <?php
                            $collections = $collectionService->getAllCollections($conn);
                            foreach ($collections as $collection): ?>
                                <option id="<?php echo $collection->getColectionId(); ?>" name="collection"
                                    value="<?php echo $collection->getColectionId(); ?>">
                                    <?php echo $collection->getColectionId();
                                    echo ". ";
                                    echo $userService->selectuserFromID($conn, $collection->getUserId())->getUsername();
                                    echo " ";
                                    echo $animalService->getAnimalByID($conn, $collection->getAnimalId())->getName(); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <input type="submit" name="delete" value="Delete" class="accent-btn delete-btn" />
                </form>
            </div>
    </main>
</body>
</html>