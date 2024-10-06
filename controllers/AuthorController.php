<?php
include_once("models/author.php");

class AuthorController
{
    public function getAuthors()
    {
        $author = new Author();
        $data = $author->getAuthors();
        return $data;
    }
}
?>