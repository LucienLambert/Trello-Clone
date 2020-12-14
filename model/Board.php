<?php

require_once "framework/Model.php";

class Board extends Model
{

    public $id;
    public $title;
    public $owner;
    public $createdAt;
    public $modifiedAt;

    public function __construct($id, $title, $owner, $createdAt, $modifiedAt)
    {
        $this->id = $id;
        $this->title = $title;
        $this->owner = $owner;
        $this->createdAt = $createdAt;
        $this->modifiedAt = $modifiedAt;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getOwner()
    {
        return $this->owner;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }


    //ajoute un board dans la DB
    public function insert_board($user)
    {
        self::execute("INSERT INTO Board(title,owner) VALUES(:title,:owner)", array("title" => $this->title, "owner" => $user->id));

        return true;
    }

    //verifie si l'ajout de la table respect bien les conditions
    public static function valide_board($title, $user)
    {
        //contiendra les erreurs
        $error = [];
        //recup la liste des board du user
        $tableBoard = self::select_all_board($user);
        //check si le titre n'est pas une string vide, si c'est bien une string, si c'est pas null
        if (!isset($title) || strlen($title) <= 0 || !is_string($title)) {
            $error [] = "You must enter a title for you board";
            //parcoure la table
        } elseif(strlen($title) < 3){
            $error [] = "Your title must contain 3 characters minimum.";
        }
        foreach ($tableBoard as $board) {
            //controler si une table ne porte pas déjà un titre identique (convertie les String en minuscule).
            if (strtolower($board->title) == strtolower($title)) {
                $error [] = "this table title is already used, please choose another title";
            }
        }
        return $error;
    }

    //récup la liste des boards via l'id du user
    public static function select_board_by_user($user)
    {
        //execute la requete sur (id = $user->id)
        $query = self::execute("SELECT * FROM Board where owner = :id", array("id" => $user->id));
        //recup les résultats (ATTENTION utiliser fetchAll() quand on récup plusieurs objets).
        $data = $query->fetchAll();
        //table vide
        $tableBoard = [];
        //parcoure le resultat et crée un new board pour chaque resultat trouvé
        foreach ($data as $d) {
            $tableBoard [] = new Board($d['ID'], $d['Title'], $d['Owner'], $d['CreatedAt'], $d['ModifiedAt']);
        }
        return $tableBoard;
    }

    //recup tout les boards de la DB
    public static function select_all_board()
    {
        $query = self::execute("SELECT * FROM Board", array());
        $data = $query->fetchALl();
        $tableBoard = [];
        foreach ($data as $d) {
            $tableBoard [] = new Board($d['ID'], $d['Title'], $d['Owner'], $d['CreatedAt'], $d['ModifiedAt']);
        }
        return $tableBoard;
    }

    //recup les bards de tous le monde sauf du user.
    public static function select_other_board($user)
    {
        $tableAllBoard = self::select_all_board();
        $tableOtherBoard = [];
        foreach ($tableAllBoard as $board) {
            if ($board->owner != $user->id) {
                $tableOtherBoard[] = $board;
            }
        }
        return $tableOtherBoard;
    }

    //recup le board via son titre.
    public static function select_board_by_title($title)
    {
        $query = self::execute("SELECT * FROM Board where title = :title", array("title" => $title));
        $data = $query->fetch();
        return new Board($data['ID'], $data['Title'], $data['Owner'], $data['CreatedAt'], $data['ModifiedAt']);;
    }

    //recup le board via son titre
    public static function select_board_by_id($id)
    {
        $query = self::execute("SELECT * FROM Board where id = :id", array("id" => $id));
        $data = $query->fetch();
        return new Board($data['ID'], $data['Title'], $data['Owner'], $data['CreatedAt'], $data['ModifiedAt']);;
    }

    public function update_title_board($title, $id, $modifiedAt)
    {
        self::execute("UPDATE Board SET title = :title, modifiedAt = :modifiedAt WHERE id = :id",
            array("title" => $title, "id" => $id, "modifiedAt" => $modifiedAt->format('Y-m-d H:i:s')));
        return true;
    }

    public static function delete_board_by_id($idBoard){
        if(isset($idBoard)){
            if(Column::delete_all_column_by_id_board($idBoard)){
                var_dump("OK ligne 147 board!");
                self::execute("DELETE FROM Board WHERE id= :id",array("id"=>$idBoard));
                return true;
            }
        }
        return false;
    }
}