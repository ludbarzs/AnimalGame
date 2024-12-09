<?php

require "../data/Collection.php";

class CollectionService {
    private Collection $collection;
    private string $table = "collections";
    
    public function insertCollection(PDO $conn, int $idUser, int $idAnimal) {
        if($this->getCollectionByAnimalIDAndUserID($conn, $idAnimal, $idUser)){
            return false;
        }
        
        $date = new DateTime();
        $objDate = $date->format("y.m.d H:i:s");

        $sql = "INSERT INTO " . $this->table . "(id_user, id_animal, date_added) VALUES (:idUser, :idAnimal, :dateAdded)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idUser', $idUser);
        $stmt->bindParam(':idAnimal', $idAnimal);
        $stmt->bindParam(':dateAdded', $objDate);
        
        return $stmt->execute();
    }
    
    public function updateColection(PDO $conn, int $id, int $newidUser, int $newidAnimal) {
        if ($newidUser == null || $newidAnimal == null) {
            return false;
        }
        
        $sql = "UPDATE $this->table SET id_user = :idUser, id_animal = :idAnimal WHERE collection_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idUser', $newidUser);
        $stmt->bindParam(':idAnimal', $newidAnimal);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
    
    public function getAllCollections(PDO $conn): array {
        $sql = "SELECT * FROM $this->table";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        $collections = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id = $row["collection_id"];
            $idUser = $row["id_user"];
            $idAnimal = $row["id_animal"];
            $dateAdded = $row["date_added"];
            
            $this->collection = new Collection($idUser, $idAnimal, $dateAdded);
            $this->collection->setColectionId($id);
            
            $collections[] = $this->collection;
        }
        return $collections;
    }

    public function getCollectionByAnimalIDAndUserID(PDO $conn, int $animalID, int $userID): Collection|bool {
        $sql = "SELECT collection_id, date_added FROM $this->table WHERE id_animal = :animalID AND id_user = :userID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":animalID", $animalID);
        $stmt->bindParam(":userID", $userID);
        $stmt->execute();
        
        if($stmt->rowCount() == 0){
            return false;
        }

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $id = $row["collection_id"];
        $dateAdded = $row["date_added"];
        
        $this->collection = new Collection($userID, $animalID, $dateAdded);
        $this->collection->setColectionId((int)$id);
        
        return $this->collection;
    }

    public function getCollectionByUserID(PDO $conn, int $userID): array|bool {
        $sql = "SELECT * FROM $this->table WHERE id_user = :userID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":userID", $userID);
        $stmt->execute();
        
        if($stmt->rowCount() == 0){
            return false;
        }

        $collections = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id = $row["collection_id"];
            $dateAdded = $row["date_added"];
            $animalID = $row["id_animal"];
            
            $this->collection = new Collection($userID, $animalID, $dateAdded);
            $this->collection->setColectionId($id);

            $collections[] = $this->collection;
        }
        
        return $collections;
    }
    
    public function deleteCollection(PDO $conn, int $id): bool {
        $sql = "DELETE FROM $this->table WHERE collection_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        
        return $stmt->execute();
    }
}
?>