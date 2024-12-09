<?php
class Collection
{
    private int $colectionId;
    private int $userId;
    private int $animalId;
    private string $dateAdded;

    public function __construct(int $userId, int $animalId, string $dateAdded)
    {
        $this->userId = $userId;
        $this->animalId = $animalId;
        $this->dateAdded = $dateAdded;
    }
    public function getColectionId(): int
    {
        return $this->colectionId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getAnimalId(): int
    {
        return $this->animalId;
    }

    public function getDateAdded(): string
    {
        return $this->dateAdded;
    }

    public function setColectionId(int $colectionId): void
    {
        $this->colectionId = $colectionId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function setAnimalId(int $animalId): void
    {
        $this->animalId = $animalId;
    }

    public function setDateAdded(string $dateAdded): void
    {
        $this->dateAdded = $dateAdded;
    }


}