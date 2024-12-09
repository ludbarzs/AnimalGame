<?php
class AnimalAttributeService{
    private AnimalAttribute $animalAttribute;
    private string $table = "animalattributes";

    public function insertAnimalAttribute(PDO $conn, int $id_animal, int $id_attribute, int $value){
        $animalAttributeExists = false;
        $animalAttributes = $this->getAllanimalAttributes($conn);

        foreach ($animalAttributes as $animalAttribute) {
            $animalAttributeAnimalID = $animalAttribute->getIdAnimal();
            $animalAttributeAttributeID = $animalAttribute->getIdAttribute();

            if($animalAttributeAnimalID == $id_animal && $animalAttributeAttributeID == $id_attribute){
                $animalAttributeExists = true;
                break;
            }
        }
        if($animalAttributeExists){
            return false;
        }

        $sql = "INSERT INTO $this->table (id_animal, id_attribute, value) VALUE (:id_animal, :id_attribute, :value)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_animal', $id_animal);
        $stmt->bindParam(':id_attribute', $id_attribute);
        $stmt->bindParam(':value', $value);

        return $stmt->execute();
    }

    public function updateAnimalAttribute(PDO $conn, int $id, int $newAnimalID, int $newAttributeID, int $newValue): bool{
        if($newAnimalID == null || $newAttributeID == null || $newValue == null){
            return false;
        }
        
        $sql = "UPDATE $this->table SET id_animal = :newAnimalID, id_attribute = :newAttributeID, value = :newValue WHERE animalAttribute_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':newAnimalID', $newAnimalID);
        $stmt->bindParam(':newAttributeID', $newAttributeID);
        $stmt->bindParam(':newValue', $newValue);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function deleteAnimalAttribute(PDO $conn, int $id): bool{
        $sql = "DELETE FROM $this->table WHERE animalAttribute_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function selectAnimalAttributeFromAnimalID(PDO $conn, int $id): array|null{
        $sql = "SELECT * FROM $this->table WHERE id_animal = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        if($stmt->rowCount() == 0){
            return null;
        }

        $animalAttributes = [];

        $rows = $stmt->fetch(PDO::FETCH_ASSOC);
        foreach($rows as $row){
            $this->animalAttribute = new AnimalAttribute($row["id_animal"], $row["id_attribute"], $row["value"]);
            $this->animalAttribute->setAnimalAttributeId($row["animalAttribute_id"]);
            $animalAttributes[] = $this->animalAttribute;
        }

        return $animalAttributes;
    }

    public function getAllAnimalAttributes(PDO $conn): array{
        $sql = "SELECT * FROM $this->table";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $animalAttributes = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $id = $row['animalAttribute_id'];
            $id_animal = $row['id_animal'];
            $id_attribute = $row['id_attribute'];
            $value = $row['value'];

            $this->animalAttribute = new AnimalAttribute($id_animal, $id_attribute, $value);
            $this->animalAttribute->setAnimalAttributeId($id);
            $animalAttributes[] = $this->animalAttribute;
        }

        return $animalAttributes;
    }
}