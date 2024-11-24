<?php

class Connection extends PDO{
    private string $host;
    private string $dbname;
    private string $username;
    private string $password;
    private PDO $conn;


    public function __construct(string $host, string $dbname, string $username, string $password){
        $this->host =$host;
        $this->dbname =$dbname;
        $this->username =$username;
        $this->password =$password;
    }

    public function connect(): void{
        try{
            $this->conn = new PDO(dsn: "mysql:host=$this->host;dbname=$this->dbname", username: $this->username, password: $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(PDOException $error){
            die("Connection failed: " . $error->getMessage());
        }
    }

    public function getCoon(): PDO{
        return $this->conn;
    }
}