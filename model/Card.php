<?php


class Card extends Model {

    public $id;
    public $title;
    public $body;   //unique
    public $position;
    public $createdAt;
    public $modifiedAt; //unique
    public $author;
    public $column;

    public function __construct($id, $title ,$body ,$position ,$createdAt ,$modifiedAt ,$author ,$column) {
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
        $this->position = $position;
        $this->createdAt = $createdAt;
        $this->modifiedAt = $modifiedAt;
        $this->author = $author;
        $this->column = $column;
    }

    //ajoute un carte dans la BD.
    public function insert_card(){

    }

}