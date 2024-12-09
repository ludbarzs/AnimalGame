<?php
class User{
    private int $id;
    private string $username; 
    private string $email; 
    private string $password;
    private string $role;

    public function __construct($username, $email, $password, $role){
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    public function getID(): int {return $this->id;}
    
    public function getUsername(): string {return $this->username;}

	public function getEmail(): string {return $this->email;}

	public function getPassword(): string {return $this->password;}

    public function setID(int $id): void {$this->id = $id;}
    
	public function setUsername(string $username): void {$this->username = $username;}
    
	public function setEmail(string $email): void {$this->email = $email;}
    
	public function setPassword(string $password): void {$this->password = $password;}

    public function getRole(): string {return $this->role;}

    public function setRole(string $role): void {$this->role = $role;}
}