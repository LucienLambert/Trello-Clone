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

    public static function select_column_by_id($id){
        $query = self::execute("SELECT * FROM `Column` WHERE id = :id", array("id"=>$id));
        $data = $query->fetch();
        return new Column($data["ID"], $data["Title"], $data["Position"], $data["CreatedAt"], $data["ModifiedAt"], $data["Board"]);


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
    //recup les deux colonnes à déplacer
    //faire un upDate des deux colonne en switchant leurs position l'une avec l'autre.
    public function update_position_column($newPosition)
    {

    }

    //modifie le titre de la colonne selectionnée
    public function update_title_column($idColumn, $newtitle, $modifiedAt){
        self::execute("UPDATE `Column` SET title = :title, modifiedAt = :modifiedAt WHERE id = :id",
            array("title"=>$newtitle, "modifiedAt"=>$modifiedAt->format('Y-m-d H:i:s'), "id"=>$idColumn));
        return true;
    }

    //supprime la colonne selectionnée (doit également supprimer les cartes contenues dans la colonne)
    public function delete_column()
    {

    }

    //verifie si l'ajout de la colonne respect bien les conditions
    //upDateTitle est utilisier unique dans le cas d'une modification de titre.
    public function valide_column($board, $upDateTitle = "")
    {
        $error = [];
        //si le test passe alors on fait tout les tests suivant depuis le nouveau title sinon on on les fait sur le titre de la colonne
        if(isset($upDateTitle)){
            $title = $upDateTitle;
        }else{
            $title = $this->title;
        }
        if (!isset($title) || strlen($title) <= 0 || !is_string($title)) {
            $error [] = "you must enter a title.";
        } elseif (strlen($title) < 3) {
            $error [] = "Your title must contain 3 characters minimum.";
        }
        $tableColumn = self::select_all_column_by_id_board($board);
        foreach ($tableColumn as $column) {
            if (strtolower($column->title) == strtolower($title)) {
                $error [] = "this board contain already a column with that title.";
            }
        }
        return $error;
    }

    public function select_column_by_board_and_position($idBoard, $postionColumn){
        $column = self::execute("SELECT * FROM `Column` where board = :board AND position = :positionColumn ",
            array("board"=>$idBoard->id, "positionColumn" =>$postionColumn));
        if(!isset($column)){
          return null;
        }
        return new Column($column["ID"], $column["Title"], $column["Position"], $column["CreatedAt"], $column["ModifiedAt"], $column["Board"]);
    }

    public static function move_column($columnR, $columnL) {
        self::execute("UPDATE `Column` SET position = :position WHERE id = :id"
            ,array("position" =>$columnR->position, "array" =>$columnR->id));

        self::execute("UPDATE `Column` SET position = :position WHERE id = :id"
            ,array("position" =>$columnL->position, "array" =>$columnL->id));

        return true;
    }
}