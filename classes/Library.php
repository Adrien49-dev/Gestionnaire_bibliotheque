<?php

require_once 'Book.php';
require_once 'User.php';

class Library {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addBook($title, $author, $year, $genre) {
        $stmt = $this->pdo->prepare("INSERT INTO books (title, author, year, genre, isBorrowed) VALUES (?, ?, ?, ?, 0)");
        $stmt->execute([$title, $author, $year, $genre]);
    }

    public function addUser($name, $email) {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        $stmt->execute([$name, $email]);
    }

    public function borrowBook($userId, $bookId) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare("SELECT isBorrowed FROM books WHERE id = ?");
            $stmt->execute([$bookId]);
            $book = $stmt->fetch();

            if (!$book || $book['isBorrowed']) {
                throw new Exception("Le livre n'est pas disponible.");
            }

            $stmt = $this->pdo->prepare("UPDATE books SET isBorrowed = 1 WHERE id = ?");
            $stmt->execute([$bookId]);

            $stmt = $this->pdo->prepare("INSERT INTO loans (user_id, book_id) VALUES (?, ?)");
            $stmt->execute([$userId, $bookId]);

            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function returnBook($bookId) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare("UPDATE books SET isBorrowed = 0 WHERE id = ?");
            $stmt->execute([$bookId]);

            $stmt = $this->pdo->prepare("DELETE FROM loans WHERE book_id = ?");
            $stmt->execute([$bookId]);

            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
}
?>
