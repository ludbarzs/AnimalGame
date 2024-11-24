<?php
class UserService{
    private User $user;
    private string $table = "users";

    public function insertUser(PDO $conn, string $username, string $email, string $password){
        $userExists = false;
        $users = $this->getAllUsers($conn);

        foreach ($users as $user) {
            // $userFirstName = $user->getFirstName();
            // $userusername = $user->getusername();
            // $useremail = $user->getemail();
            $userEmail = $user->getEmail();

            if($userEmail == $email){
                $userExists = true;
                break;
            }
        }
        if($userExists){
            return false;
        }

        $sql = "INSERT INTO $this->table (username, email, password) VALUE (:username, :email, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        return $stmt->execute();
    }

    public function updateUser(PDO $conn, int $id, string $newUsername, string $newemail, string $newpassword): bool{
        if($newUsername == null || $newemail == null || $newpassword == null){
            return false;
        }
        
        $sql = "UPDATE $this->table SET username = :newusername, email = :newemail, password = :newpassword WHERE user_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':newusername', $newUsername);
        $stmt->bindParam(':newemail', $newemail);
        $stmt->bindParam(':newpassword', $newpassword);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function deleteUser(PDO $conn, int $id): bool{
        $sql = "DELETE FROM $this->table WHERE user_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function selectuserFromEmail(PDO $conn, string $email): array|User|null{
        $sql = "SELECT username, password FROM $this->table WHERE email = :email";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if($stmt->rowCount() == 0){
            return null;
        }

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $username = $row["username"];
        $password = $row["password"];

        $this->user = new User($username, $email, $password);

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

        $this->user = new User($username, $email, $password);
        $this->user->setId($id);

        return $this->user;
    }

    public function selectUserID(PDO $conn, string $email): int{
        $sql = "SELECT user_id FROM $this->table WHERE email = :email";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $id = $row["user_id"];

        return $id;
    }

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

            $this->user = new User($username, $email, $password);
            $this->user->setId($id);

            $users[] = $this->user;
        }

        return $users;
    }
}