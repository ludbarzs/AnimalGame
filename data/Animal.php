<?php

class Animal
{
    private int $animalID;
    private string $name;
    private string $species;
    private string $image;
    private string $description;

    public function __construct(string $name, string $species, string $image, string $description)
    {
        $this->name = $name;
        $this->species = $species;
        $this->image = $image;
        $this->description = $description;
    }

    public function getAnimalID(): int
    {
        return $this->animalID;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSpecies(): string
    {
        return $this->species;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setAnimalID(int $animalID): void
    {
        $this->animalID = $animalID;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setSpecies(string $species): void
    {
        $this->species = $species;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

}