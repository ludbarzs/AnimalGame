<?php

session_start();

// if (empty($_SESSION["user_id"])) {
//     header("Location: loginPage.php");
// }

require "../includes.php";
$host = "localhost";
$dbname = "web_projekts";
$username = "root";
$password = "";

$connection = new Connection($host, $dbname, $username, $password);
$connection->connect();
$conn = $connection->getCoon();

$animalService = new AnimalService();

$createErrors = [];
$updateErrors = [];

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $species = $_POST['species'];
    $description = $_POST['description'];

    if (strlen($name) <= 0) {
        $createErrors['name'] = "Name is required";
    }

    if (strlen($species) <= 0) {
        $createErrors['species'] = "Species is required";
    }

    if (strlen($description) <= 0) {
        $createErrors['desc'] = "Description is required";
    }

    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $errorCode = $_FILES['image']['error'];
        $createErrors['image'] = "Image upload has falied: $errorCode";
    }

    if (empty($createErrors)) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileData = file_get_contents($fileTmpPath);
        $encodedImage = base64_encode($fileData);

        $result = $animalService->insertAnimal($conn, $name, $species, $encodedImage, $description);

        if ($result) {
            header("Location: animal_page.php");
        }
    }
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['nameUpdate'];
    $species = $_POST['speciesUpdate'];
    $description = $_POST['descriptionUpdate'];
    $image = $animalService->getAnimalByID($conn, $id)->getImage();

    if (isset($_FILES['imgUpdate']) && $_FILES['imgUpdate']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['imgUpdate']['tmp_name'];
        $fileData = file_get_contents($fileTmpPath);
        $image = base64_encode($fileData);
    }

        $result = $animalService->updateAnimal($conn, $id, $name, $species, $image, $description);

        if ($result) {
            header("Location: animal_page.php");
        }
}
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $result = $animalService->deleteAnimal($conn, $id);

    if ($result) {
        header("Location: animal_page.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal</title>
    <link rel="stylesheet" href="../css/manage_page.css">

    <script defer src="../scripts/animal.js" defer></script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Parkinsans:wght@300..800&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Lines -->
    <div class="line"></div>
    <div class="line"></div>

    <?php include 'nav_bar.php'; ?>

    <main>
        <!-- Add Animal -->
        <div class="window">
            <form method="post" enctype="multipart/form-data" onsubmit="return validateCreateAnimal()" class="add-form">
                <h1>Add new animal</h1>
                <div>
                    <label for="name">Animal name:</label>
                    <input type="text" name="name" id="name" placeholder="Enter Name" class="input-text" />
                </div>
                <span class="error" id="nameError">
                    <?php if (isset($createErrors["name"])): ?>
                        <?php echo $createErrors["name"] ?>
                    <?php endif; ?>
                </span>
                <div>
                    <label for="species">Animal species: </label>
                    <input type="text" name="species" id="species" placeholder="Enter Species" class="input-text" />
                </div>
                <span class="error" id="speciesError">
                    <?php if (isset($createErrors["species"])): ?>
                        <?php echo $createErrors["species"] ?>
                    <?php endif; ?>
                </span>
                <div>
                    <label for="image" class="animal-img-label">Browse: </label>
                    <input type="file" name="image" id="image" placeholder="Enter Image" onchange="changeImage();" class="input-text input-image" />
                </div>
                <span class="error" id="imageError">
                    <?php if (isset($createErrors["image"])): ?>
                        <?php echo $createErrors["image"] ?>
                    <?php endif; ?>
                </span>
                <div>
                    <label for="image">Animal description: </label>
                    <textarea name="description" id="description" placeholder="Enter description" class="input-text"></textarea>
                </div>
                <span class="error" id="descError">
                    <?php if (isset($createErrors["desc"])): ?>
                        <?php echo $createErrors["desc"] ?>
                    <?php endif; ?>
                </span>
                <input type="submit" name="submit" value="Add" class="accent-btn" />
            </form>
        </div>
        <form method="post" enctype="multipart/form-data">
            <div class="grid-container edit-delete">
                <!-- Select Animal -->
                <div class="window combobox-container">
                    <h1>Select Animal to Configure</h1>
                    <div class="combobox-row">
                        <select id="animalSelect" name="id">
                            <?php
                            $animals = $animalService->getAllAnimals($conn);
                            foreach ($animals as $animal): ?>
                                <option id="<?php echo $animal->getAnimalId(); ?>" name="animal"
                                    value="<?php echo $animal->getAnimalId(); ?>" 
                                    data-name="<?php echo $animal->getName(); ?>"
                                    data-species="<?php echo $animal->getSpecies(); ?>"
                                    data-description="<?php echo $animal->getDescription(); ?>">
                                    <?php echo $animal->getAnimalId();
                                    echo ". ";
                                    echo $animal->getName();
                                    echo " - ";
                                    echo $animal->getSpecies(); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <input type="submit" name="delete" value="delete" class="accent-btn delete-btn" />
                    </div>
                    
                </div>
                <!-- Edit Animal -->
                <div class="window edit-window">
                    <h1>Update animal</h1>
                    <div enctype="multipart/form-data">
                        <label for="nameUpdate">Animal name: </label>
                        <input type="text" name="nameUpdate" id="nameUpdate" placeholder="Enter Name" class="input-text" />
                    </div>
                    <span class="error" id="nameErrorUpdate">
                        <?php if (isset($updateErrors["name"])): ?>
                            <?php echo $updateErrors["name"] ?>
                        <?php endif; ?>
                    </span>
                    <div>
                        <label for="speciesUpdate">Animal species: </label>
                        <input type="text" name="speciesUpdate" id="speciesUpdate" placeholder="Enter Species" class="input-text" />
                    </div>
                    <span class="error" id="speciesErrorUpdate">
                        <?php if (isset($updateErrors["species"])): ?>
                            <?php echo $updateErrors["species"] ?>
                        <?php endif; ?>
                    </span>
                    <div>
                        <label for="imgUpdate">Animal img: </label>
                        <input type="file" name="imgUpdate" id="imgUpdate" placeholder="Enter img" class="input-text input-image" />
                    </div>
                    <span class="error" id="imageErrorUpdate">
                        <?php if (isset($updateErrors["image"])): ?>
                            <?php echo $updateErrors["image"] ?>
                        <?php endif; ?>
                    </span>
                    <div>
                        <label for="descriptionUpdate">Animal description: </label>
                        <input type="text" name="descriptionUpdate" id="descriptionUpdate" placeholder="Enter Description" class="input-text" />
                    </div>
                    <span class="error" id="descErrorUpdate">
                        <?php if (isset($updateErrors["desc"])): ?>
                            <?php echo $updateErrors["desc"] ?>
                        <?php endif; ?>
                    </span>
                    <input type="submit" name="update" value="Update" class="accent-btn" />
                </div>
                <div class="images">
                    <?php
                    $animals = $animalService->getAllAnimals($conn);
                    $i = 0;
                    foreach ($animals as $animal) {
                        $image = $animal->getImage();
                        $name = $animal->getName();
                        $id = $animal->getAnimalID();

                        $selected = "hide";

                        if ($i == 0) {
                            $selected = "show";
                        }
                        echo "<img src='data:image/jpeg;base64,$image' alt='$name' id='$id-img' class='$selected animal-img'/>";
                        $i++;
                    }
                    ?>
                </div>
            </div>
            </div>
        </form>
    </main>

</body>

</html>