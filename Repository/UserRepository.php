<?php

require_once 'Repository.php';

class UserRepository extends Repository {
    public function getUsers(): ?array {
        $query = $this->database->connect()->prepare('
        SELECT * FROM users
        ');
        $query->execute();

        $users = $query->fetchAll(PDO::FETCH_ASSOC);
        //TODO close db collection
        return $users;
    }

    public function getUsersByEmail(string $email): ?array 
    {
        $query = $this->database->connect()->prepare('
        SELECT * FROM users WHERE email = :email
        ');
        $query->bindParam(':email', $email);
        $query->execute();

        $users = $query->fetch(PDO::FETCH_ASSOC);
        //TODO close db collection
        return $users ?: null;
    }

    public function createUser(
        string $email,
        string $hashedPassword,
        string $firstName,
        string $lastName,
        string $bio = ''
    ): void {
        $query = $this->database->connect()->prepare('
        INSERT INTO users (firstname, lastname, email, password, bio, enabled)
        VALUES (?, ?, ?, ?, ?, ?);');

        $query->execute([
            $firstName,
            $lastName,
            $email,
            $hashedPassword,
            $bio,
            true
        ]);
    }
}

