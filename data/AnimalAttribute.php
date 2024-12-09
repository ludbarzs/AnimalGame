<?php
class AnimalAttribute
{
	private int $animalAttribute_id;
	private int $id_animal;
	private int $id_attribute;
	private int $value;

	public function __construct(int $id_animal, int $id_attribute, int $value)
	{
		$this->id_animal = $id_animal;
		$this->id_attribute = $id_attribute;
		$this->value = $value;
	}
	public function getAnimalAttributeId(): int
	{
		return $this->animalAttribute_id;
	}

	public function getIdAnimal(): int
	{
		return $this->id_animal;
	}

	public function getIdAttribute(): int
	{
		return $this->id_attribute;
	}

	public function getValue(): int
	{
		return $this->value;
	}

	public function setAnimalAttributeId(int $animalAttribute_id): void
	{
		$this->animalAttribute_id = $animalAttribute_id;
	}

	public function setIdAnimal(int $id_animal): void
	{
		$this->id_animal = $id_animal;
	}

	public function setIdAttribute(int $id_attribute): void
	{
		$this->id_attribute = $id_attribute;
	}

	public function setValue(int $value): void
	{
		$this->value = $value;
	}



}