<?php
class Collection {
    private $collectionId;
    private $userId;
    private $animalId;
    private $dateAdded;

    public function __construct($userId, $animalId, $dateAdded) {
        $this->userId = $userId;
        $this->animalId = $animalId;
        $this->dateAdded = $dateAdded;
    }

    public function getCollectionId() {
        return $this->collectionId;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getAnimalId() {
        return $this->animalId;
    }

    public function setCollectionId($collectionId) {
        $this->collectionId = $collectionId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setAnimalId($animalId) {
        $this->animalId = $animalId;
    }
}
?>