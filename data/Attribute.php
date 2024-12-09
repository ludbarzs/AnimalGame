<?php
class Attributes{
    private string $name;
    private int $id;

    public function __construct($name){
        $this->name = $name;
    }

	public function getName(): string {return $this->name;}
    
	public function getId(): int {return $this->id;}

    public function setName(string $name): void {$this->name = $name;}

	public function setId(int $id): void {$this->id = $id;}


}