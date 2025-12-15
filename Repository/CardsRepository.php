<?php

require_once 'Repository.php';

class CardsRepository extends Repository {

    public function getCardsByTitle(string $searchString)
    {
        $searchString = '%' . strtolower($searchString) . '%';

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM cards
            WHERE LOWER(title) LIKE :search OR LOWER(description) LIKE :search
        ');
        $stmt->bindParam(':search', $searchString, PDO::PARAM_STR);
        $stmt->execute();

    
         $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $cards = [];

        foreach ($rows as $row) {
            $cards[] = new Card(
            $row['title'],
            $row['description'],
            $row['image'],
            (int)$row['id']
            );
        }

        return $cards;
    }
}