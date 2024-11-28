<?php

class User {
    public $id;
    public $name;
    public $email;
    public $borrowedBooks = [];

    public function __construct($id, $name, $email) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    public function borrowBook($book) {
        $this->borrowedBooks[] = $book;
    }

    public function returnBook($bookId) {
        $this->borrowedBooks = array_filter($this->borrowedBooks, function($book) use ($bookId) {
            return $book->id !== $bookId;
        });
    }
}
?>
