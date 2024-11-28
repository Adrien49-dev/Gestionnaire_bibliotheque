<?php

class Book {
    public $id;
    public $title;
    public $author;
    public $year;
    public $genre;
    public $isBorrowed;

    public function __construct($id, $title, $author, $year, $genre, $isBorrowed = false) {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->year = $year;
        $this->genre = $genre;
        $this->isBorrowed = $isBorrowed;
    }

    public function markAsBorrowed() {
        $this->isBorrowed = true;
    }

    public function markAsAvailable() {
        $this->isBorrowed = false;
    }
}
?>
