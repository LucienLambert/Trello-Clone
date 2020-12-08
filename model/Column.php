<?php

require_once "framework/Model.php";

class Column extends Model
{

    public $id;
    public $title;
    public $position;
    public $createdAt;
    public $modifiedAt;
    public $board;

    public function __construct($id, $title, $position, $createdAt, $modifiedAt, $board)
    {
        $this->id = $id;
        $this->title = $title;
        $this->position = $position;
        $this->createdAt = $createdAt;
        $this->modifiedAt = $modifiedAt;
        $this->board = $board;
    }

    //ajoute une colonne dans le board entré en paramètre
    public function inset_column($board)
    {
        self::execute("INSERT INTO `Column`(title,position,board) VALUES(:title,:position,:board)",
            array("title" => $this->title, "position" => $this->position, "board" => $board->id));
    }

    //selectionne une  colonne via l'ID du board entré en paramètre
    public static function select_all_column_by_id_board($board)
    {
        $query = self::execute("SELECT * FROM `Column` where board = :id", array("id" => $board->id));
        $data = $query->fetchAll();
        $tableColumn = [];
        foreach ($data as $d) {
            $tableColumn [] = new Column($d["ID"], $d["Title"], $d["Position"], $d["CreatedAt"], $d["ModifiedAt"], $d["Board"]);
        }
        return $tableColumn;
    }

    //modifie la position de la colonne selectionnée
    public function update_position_column()
    {

    }

    //modifie le titre de la colonne selectionnée
    public function update_title_column()
    {

    }

    //supprime la colonne selectionnée (doit également supprimer les cartes contenues dans la colonne)
    public function delete_column()
    {

    }

    //verifie si l'ajout de la colonne respect bien les conditions
    public function valide_column($board)
    {
        $error = [];
        if (!isset($this->title) || strlen($this->title) <= 0 || !is_string($this->title)) {
            $error [] = "you must enter a title.";
        } elseif (strlen($this->title) < 3) {
            $error [] = "Your title must contain 3 characters minimum.";
        }
        $tableColumn = self::select_all_column_by_id_board($board);
        foreach ($tableColumn as $column) {
            if (strtolower($column->title) == strtolower($this->title)) {
                $error [] = "this board contain already a column with that title.";
            }
        }
        return $error;
    }
}