<?php

include "../data/Animal.php";

class AnimalService {
    private Animal $animal;
    private string $table = "animals";

    public function getAllAnimals(PDO $conn): array {
        $sql = "SELECT * FROM $this->table";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        $animals = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id = $row["animal_id"];
            $name = $row["name"];
            $species = $row["species"];
            $image = $row["image"];
            $description = $row["description"];
            
            $this->animal = new Animal($name, $species, $image, $description);
            $this->animal->setAnimalID($id);
            
            $animals[] = $this->animal;
        }
        return $animals;
    }
    
    public function insertAnimal(PDO $conn, string $name, string $species, string $image, string $description) {
        $animals = $this->getAllAnimals($conn);
        
        foreach ($animals as $currentAnimal) {
            $animalName = $currentAnimal->getName();
            $animalSpecies = $currentAnimal->getSpecies();
            
            if ($animalName == $name && $animalSpecies == $species) {
                return false;
            }
        }
        
        $sql = "INSERT INTO " . $this->table . "(name, species, image, description) VALUES (:animalName, :animalSpecies, :animalImage, :animalDescription)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':animalName', $name);
        $stmt->bindParam(':animalSpecies', $species);
        $stmt->bindParam(':animalImage', $image);
        $stmt->bindParam(':animalDescription', $description);
        
        return $stmt->execute();
    }
    
    public function updateAnimal(PDO $conn, int $id, string $newName, string $newSpecies, string $newImage, string $newDescription) {
        if ($newName == null || $newSpecies == null || $newImage == null || $newDescription == null) {
            return false;
        }
        
        $sql = "UPDATE $this->table SET name = :newName, species = :newSpecies, image = :newImage, description = :newDescription WHERE animal_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':newName', $newName);
        $stmt->bindParam(':newSpecies', $newSpecies);
        $stmt->bindParam(':newImage', $newImage);
        $stmt->bindParam(':newDescription', $newDescription);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    public function getAnimalByID(PDO $conn, $id): Animal{
        $sql = "SELECT * FROM $this->table WHERE animal_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $name = $row["name"];
        $species = $row["species"];
        $image = $row["image"];
        $description = $row["description"];
        
        $this->animal = new Animal($name, $species, $image, $description);
        $this->animal->setAnimalID($id);
        
        return $this->animal;
    }
    
    public function deleteAnimal(PDO $conn, int $id): bool {
        $sql = "DELETE FROM $this->table WHERE animal_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        
        return $stmt->execute();
    }
}