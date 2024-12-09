<?php
include "../data/Attribute.php";

class AttributeService{
    private Attributes $attribute;
    private string $table = "attributes";

    public function insertAtribute(PDO $conn, string $name){
        $attributeExists = false;
        $attributes = $this->getAllAtributes($conn);

        foreach ($attributes as $attribute) {
            $attributeName = $attribute->getName();

            if($attributeName == $name){
                $attributeExists = true;
                break;
            }
        }
        if($attributeExists){
            return false;
        }

        $sql = "INSERT INTO $this->table (name) VALUE (:name)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);

        return $stmt->execute();
    }

    public function updateAttribute(PDO $conn, int $id, string $newName): bool{
        if($newName == null){
            return false;
        }
        
        $sql = "UPDATE $this->table SET name = :newname WHERE attribute_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':newname', $newName);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function deleteAttribute(PDO $conn, int $id): bool{
        $sql = "DELETE FROM $this->table WHERE attribute_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getAllAtributes(PDO $conn): array{
        $sql = "SELECT * FROM $this->table";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $attributes = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $id = $row['attribute_id'];
            $name = $row['name'];

            $this->attribute = new Attributes($name);
            $this->attribute->setId($id);

            $attributes[] = $this->attribute;
        }

        return $attributes;
    }

    public function getAttributeByID(PDO $conn, $id): Attributes{
        $sql = "SELECT * FROM $this->table WHERE attribute_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $name = $row["name"];
        
        $this->attribute = new Attributes($name);
        $this->attribute->setId($id);
        
        return $this->attribute;
    }
}