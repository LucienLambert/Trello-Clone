<?php

require_once "framework/Model.php";

class Column extends Model
{

    private $id;
    private $title;
    private $position;
    private $createdAt;
    private $modifiedAt;
    private $board;

    public function __construct($id, $title, $position, $createdAt, $modifiedAt, $board)
    {
        $this->id = $id;
        $this->title = $title;
        $this->position = $position;
        $this->createdAt = $createdAt;
        $this->modifiedAt = $modifiedAt;
        $this->board = $board;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    public function getBoard()
    {
        return $this->board;
    }

    public function setPosition($position){
        $this->position = $position;
    }

    private function update_column(){
        self::execute("UPDATE `Column` SET title= :title, position= :position, createdAt= :createdAt, modifiedAt= :modifiedAt, board= :board WHERE id= :id", array(
            "id"=>$this->getId(),
            "title"=>$this->getTitle(),
            "position"=>$this->getPosition(),
            "createdAt"=>$this->getCreatedAt(),
            "modifiedAt"=>$this->getModifiedAt(),
            "board"=>$this->getBoard()
        ));
        return true;
    }

    //ajoute une colonne dans le board entré en paramètre
    public function inset_column($board)
    {
        self::execute("INSERT INTO `Column`(title,position,board) VALUES(:title,:position,:board)",
            array("title" => $this->getTitle(), "position" => $this->getPosition(), "board" => $board->getId()));
    }

    public static function select_column_by_id($id){
        $query = self::execute("SELECT * FROM `Column` WHERE id = :id", array("id"=>$id));
        $data = $query->fetch();
        return new Column($data["ID"], $data["Title"], $data["Position"], $data["CreatedAt"], $data["ModifiedAt"], $data["Board"]);
    }

    //selectionne une  colonne via l'ID du board entré en paramètre
    public static function select_all_column_by_id_board($board)
    {
        $query = self::execute("SELECT * FROM `Column` where board = :id", array("id" => $board->getId()));
        $data = $query->fetchAll();
        $tableColumn = [];
        foreach ($data as $d) {
            $tableColumn [] = new Column($d["ID"], $d["Title"], $d["Position"], $d["CreatedAt"], $d["ModifiedAt"], $d["Board"]);
        }
        return $tableColumn;
    }

    private static function select_all_column_from_position($column){
        $query = self::execute("SELECT * FROM `Column` WHERE position > :position AND board= :board",
            array("board"=>$column->getBoard(), "position"=>$column->getPosition()));
        $data = $query->fetchAll();
        $table = [];
        foreach ($data as $d){
            $table [] = new Column($d["ID"], $d["Title"], $d["Position"], $d["CreatedAt"], $d["ModifiedAt"], $d["Board"]);
        }
        return $table;
    }

    //modifie le titre de la colonne selectionnée
    public function update_title_column($idColumn, $newtitle, $modifiedAt){
        self::execute("UPDATE `Column` SET title = :title, modifiedAt = :modifiedAt WHERE id = :id",
            array("title"=>$newtitle, "modifiedAt"=>$modifiedAt->format('Y-m-d H:i:s'), "id"=>$idColumn));
        return true;
    }

    //supprime la colonne selectionnée (doit également supprimer les cartes contenues dans la colonne)
    public function delete_column_by_id()
    {
        //$column = Column::select_column_by_id($idColumn);
        $table = Column::select_all_column_from_position($this);
        if($this->getId() != null){
            $tableCard = Card::select_all_card_by_id_column_ASC($this->getId());
            foreach ($tableCard as $c){
                //supprime tous les participant d'un carte d'un tableau de carte avant de supprimer la carte
                $AllParticipant = Participate::select_all_participate_from_card($c);
                foreach($AllParticipant as $participant){
                    $participant->delete_participant();
                }
                $c->delete_all_card_by_Column($this->getId());
            }
            self::execute("DELETE FROM `Column` WHERE id= :id", array("id"=>$this->getId()));
            for($i = 0; $i < count($table); $i++){
                $current = $table[$i];
                $current->setPosition($current->getPosition() -1);
                $current->update_column();
            }
            return true;
        }
        return false;
    }

    public function delete_all_column_by_id_board(){
        $cardColumn = Card::select_all_card_by_id_column_ASC($this->getId());
        foreach ($cardColumn as $c){
            //supprime tous les participant d'un carte d'un tableau de carte avant de supprimer la carte
            $AllParticipant = Participate::select_all_participate_from_card($c);
            foreach($AllParticipant as $participant){
                $participant->delete_participant();
            }
            $c->delete_all_card_by_Column();
        }
        self::execute("DELETE FROM `Column` WHERE id= :id", array("id"=>$this->getId()));
        return true;
    }

    //verifie si l'ajout de la colonne respect bien les conditions
    public static function valide_column($board, $title = "")
    {
        $error = [];
        if (!isset($title) || strlen($title) <= 0 || !is_string($title)) {
            $error [] = "you must enter a title.";
        } elseif (strlen($title) < 3) {
            $error [] = "Your title must contain 3 characters minimum.";
        }
        $tableColumn = self::select_all_column_by_id_board($board);
        if(count($tableColumn) == 0){
            return $error;
        }
        foreach ($tableColumn as $column) {
            if (strtolower($column->getTitle()) == strtolower($title)) {
                $error [] = "this board contain already a column with that title.";
            }
        }
        return $error;
    }

    //recup la column en fonction de son board et de sa position
    public function select_column_by_board_and_position($idBoard, $postionColumn){
        $column = self::execute("SELECT * FROM `Column` where board = :board AND position = :positionColumn ",
            array("board"=>$idBoard, "positionColumn" =>$postionColumn));
        $data = $column->fetch();
        return new Column($data["ID"], $data["Title"], $data["Position"], $data["CreatedAt"], $data["ModifiedAt"], $data["Board"]);
    }

    public function move_column($columnL) {
        self::execute("UPDATE `Column` SET position = :position WHERE id = :id"
            ,array("position" =>$columnL->position, "id" =>$this->getId()));

        self::execute("UPDATE `Column` SET position = :position WHERE id = :id"
            ,array("position" =>$this->getPosition(), "id" =>$columnL->id));
        return true;
    }
    //recup toutes les colonnes d'un board->id mais trié par position
    public static function select_all_column_by_id_board_ASC($board){
        $query = self::execute("SELECT * FROM `Column` where board = :id ORDER BY position ", array("id" => $board));
        $data = $query->fetchAll();
        $tableColumn = [];
        foreach ($data as $d) {
            $tableColumn [] = new Column($d["ID"], $d["Title"], $d["Position"], $d["CreatedAt"], $d["ModifiedAt"], $d["Board"]);
        }
        return $tableColumn;
    }
    
    public static function select_column_by_title_and_board($title, $id){
        $query = self::execute("SELECT * FROM `Column` where title = :title AND board = :id", array("title" => $title, "id" => $id));
        $data = $query->fetch();
        if($data == false){
            return null;
        }
        else 
            return new Column($data["ID"], $data["Title"], $data["Position"], $data["CreatedAt"], $data["ModifiedAt"], $data["Board"]);
    }
}