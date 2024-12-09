<?php
require "../includes.php";
$config = parse_ini_file('../config.ini');

$host = $config["servername"];
$dbname = $config["dbname"];
$username = $config["username"];
$password = $config["password"];

$connection = new Connection($host, $dbname, $username, $password);
$connection->connect();
$conn = $connection->getCoon();

$animalService = new AnimalService();
$attributeService = new AttributeService();
$animalAttributeService = new AnimalAttributeService();

$errorsCreate = [];
$errorsUpdate = [];

if (isset($_POST['submit'])) {
    $animalID = intval($_POST['animalid']);
    $attributeID = intval($_POST['attributeid']);
    $value = intval($_POST['value']);

    if(strlen($value) <= 0){
        $errorsCreate['value'] = "Value field is required.";
    }
    if(empty($errorsCreate)){
        $result = $animalAttributeService->insertAnimalAttribute($conn, $animalID, $attributeID, $value);

        if ($result) {
            header("Location: animalAttributesPage.php");
        }
    }
}

if (isset($_POST['update'])) {
    $animalAttributeID = intval($_POST['animalAttributeID']);
    $animalID = intval($_POST['animalid']);
    $attriubteid = intval($_POST['attriubteid']);
    $value = intval($_POST['valueUpdate']);

    if(strlen($value) <= 0){
        $errorsUpdate['value'] = "Value field is required.";
    }
    if(empty($errorsUpdate)){
        $result = $animalAttributeService->updateAnimalAttribute($conn, $animalAttributeID, $animalID, $attriubteid, $value);

        if ($result) {
            header("Location: animalAttributesPage.php");
        }
    }

}
if (isset($_POST['delete'])) {
    $animalAttributeID = intval($_POST['animalAttributeID']);

    $result = $animalAttributeService->deleteAnimalAttribute($conn, $animalAttributeID);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src="../scripts/animalAttributes.js"></script>
    <link rel="stylesheet" href="../css/animal_attribute_page.css">
    <title>Animal attributes</title>
</head>
<body>
    <?php include 'nav_bar.php'; ?>

    <!-- Select Animal -->
    <main>
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