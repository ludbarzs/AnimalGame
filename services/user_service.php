<?php
include "../data/User.php";
class UserService{
    private User $user;
    private string $table = "users";

    public function getAllUsers(PDO $conn): array{
        $sql = "SELECT * FROM $this->table";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $users = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $id = $row['user_id'];
            $username = $row['username'];
            $email = $row['email'];
            $password = $row['password'];
            $role = $row['role'];

            $this->user = new User($username, $email, $password, $role);
            $this->user->setId($id);

            $users[] = $this->user;
        }

        return $users;
    }

    public function insertUser(PDO $conn, string $username, string $email, string $password, string $role, string $sessionId){
        $users = $this->getAllUsers($conn);

        foreach ($users as $user) {
            $username_taken = $user->getUsername();
            $email_taken = $user->getEmail();

            if($username == $username_taken || $email == $email_taken){
                return false;
            }
        }

        $sql = "INSERT INTO $this->table (username, email, password, role) VALUES (:username, :email, :password, :role)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);

        return $stmt->execute();
    }

    public function updateUser(PDO $conn, int $id, string $newUsername, string $newEmail, string $newPassword, string $role): bool{
        if($newUsername == null || $newEmail == null || $newPassword == null){
            return false;
        }
        
        $sql = "UPDATE $this->table SET username = :username, email = :email, password = :password, role = :role WHERE user_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $newUsername);
        $stmt->bindParam(':email', $newEmail);
        $stmt->bindParam(':password', $newPassword);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function deleteUser(PDO $conn, int $id): bool{
        $sql = "DELETE FROM $this->table WHERE user_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function selectUserFromEmail(PDO $conn, string $email): User|null{
        $sql = "SELECT username, password, role FROM $this->table WHERE email = :email";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if($stmt->rowCount() == 0){
            return null;
        }

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $username = $row["username"];
        $password = $row["password"];
        $role = $row["role"];

        $this->user = new User($username, $email, $password, $role);

        return $this->user;
    }

    public function selectUserFromUsername(PDO $conn, string $username): array|User|null{
        $sql = "SELECT email, password, role FROM $this->table WHERE username = :username";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        if($stmt->rowCount() == 0){
            return null;
        }

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $email = $row["email"];
        $password = $row["password"];
        $role = $row["role"];

        $this->user = new User($username, $email, $password, $role);

        return $this->user;
    }

    public function selectuserFromID(PDO $conn, int $id): User|null{
        $sql = "SELECT * FROM $this->table WHERE user_id = :id";

        $stmt = $conn->prepare(query: $sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        if($stmt->rowCount() == 0){
            return null;
        }

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $username = $row["username"];
        $password = $row["password"];
        $email = $row["email"];
        $role = $row["role"];

        $this->user = new User($username, $email, $password, $role);
        $this->user->setId($id);

        return $this->user;
    }

    public function selectUserID(PDO $conn, string $email): int|null{
        $sql = "SELECT user_id FROM $this->table WHERE email = :email";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if($stmt->rowCount() == 0){
            return null;
        }

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $id = $row["user_id"];

        return $id;
    }
}