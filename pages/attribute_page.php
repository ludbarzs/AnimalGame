<?php
session_start();


include "../includes.php";
$host = "localhost";
$dbname = "web_projekts";
$username = "root";
$password = "";

$connection = new Connection($host, $dbname, $username, $password);
$connection->connect();
$connObj = $connection->getCoon();
$attrController = new AttributeService();

$errorsCreate = [];
$errorsUpdate = [];

if (isset($_POST['add'])) {
    $attributeName = $_POST["attributeName"];

    if (strlen($attributeName) <= 0) {
        $errorsCreate['name'] = "Name field is required.";
    }

    if (empty($errorsCreate)) {
        $result = $attrController->insertAtribute($connObj, $attributeName);

        if ($result) {
            header("Location: attribute_page.php");
        }
    }
}
if (isset($_POST['update'])) {
    $id = $_POST['attributeSelect'];
    $name = $_POST['nameUpdate'];

    if (strlen($name) <= 0) {
        $errorsUpdate['name'] = "Name field is required.";
    }

    if (empty($errorsUpdate)) {
        $result = $attrController->updateAttribute($connObj, $id, $name);

        if ($result) {
            header("Location: attribute_page.php");
        }
    }
}
if (isset($_POST['delete'])) {
    $id = $_POST['attributeSelect'];

    $result = $attrController->deleteAttribute($connObj, $id);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attributes</title>
    <link rel="stylesheet" href="../css/attribute_page.css">
    <script defer src="../scripts/attribute.js"></script>
</head>

<body>

    <?php include 'nav_bar.php'; ?>

    <main>
        <!-- Add Animal -->
        <div class="window">
            <form action="#" method="POST" onsubmit="return validateCreateAttribute()">
                <h1>Add atribute</h1>
                <div>
                    <label for="name">Attribute Name:</label>
                    <input type="text" id="name" name="attributeName" />
                    <span class="error" id="nameError">
                        <?php if (isset($errorsCreate["name"])): ?>
                            <?php echo $errorsCreate["name"] ?>
                        <?php endif; ?>
                    </span>
                </div>
                <input type="submit" value="add" name="add" class="accent-btn" >
            </form>
        </div>

        <form method="post" enctype="multipart/form-data">
            <div class="grid-container edit-delete">
                <!-- Select Atribute -->
                <div class="window combobox-container">
                    <h1>Update attribute</h1>
                    <div class="combobox-row">
                        <select id="attributeSelect" name="attributeSelect">
                            <?php
                            $attributes = $attrController->getAllAtributes($connObj);

                            foreach ($attributes as $attribute): ?>
                                <option id="<?php echo $attribute->getId(); ?>" name="attribute"
                                    value="<?php echo $attribute->getId(); ?>"
                                    data-name="<?php echo $attribute->getName(); ?>">
                                    <?php echo $attribute->getId();
                                    echo ". ";
                                    echo $attribute->getName();
                                    ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <input type="submit" name="delete" value="delete" class="accent-btn delete-btn" />
                    </div>

                </div>
                <!-- Edit Atribute -->
                <div class="window edit-window">
                    <h1>Update Attribute</h1>
                    <div enctype="multipart/form-data">
                        <label for="nameUpdate">Attribute name: </label>
                        <input type="text" name="nameUpdate" id="nameUpdate" placeholder="Enter Name" class="input-text" />
                    </div>
                    <input type="submit" name="update" value="Update" class="accent-btn" />
                </div>
            </div>
            </div>
        </form>
    </main>
</body>

</html>