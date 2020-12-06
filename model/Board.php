<?php

require_once "framework/Model.php";

class Board extends Model {

    public $id;
    public $title;
    public $owner;
    public $createdAt;
    public $modifiedAt;

    public function __construct($id, $title, $owner, $createdAt,$modifiedAt) {
        $this->id = $id;
        $this->title = $title;
        $this->owner = $owner;
        $this->createdAt = $createdAt;
        $this->modifiedAt = $modifiedAt;
    }

    //ajoute un board dans la DB
    public function insert_board($user){
        //insert un board
        //$this->title recup le titre de l'objet            : ref = $board = new Board(null, $title, $user->id, null, null);
        //$this->id recup le id du user qui crée le board   : ref = $board = new Board(null, $title, $user->id, null, null);
        self::execute("INSERT INTO Board(title,owner) VALUES(:title,:owner)", array("title"=>$this->title, "owner"=>$user->id));

        return true;
    }

    //verifie si l'ajout de la table respect bien les conditions
    public static function valide_board($title, $user){
        //contiendra les erreurs
        $error = [];
        //recup la liste des board du user
        $tableBoard = self::select_board_by_user($user);
        //check si le titre n'est pas une string vide, si c'est bien une string, si c'est pas null
        if(!isset($title) || strlen($title) <= 0 || !is_string($title)){
            $error [] = "You must enter a title for you board";
            //parcoure la table
        } foreach ($tableBoard as $board){
            //controler si une table ne porte pas déjà un titre identique (convertie les String en minuscule).
            if(strtolower($board->title) == strtolower($title)){
                $error [] = "this table title is already used, please choose another title";
            }
        }
        return $error;
    }

    //récup la liste des boards via l'id du user
    public static function select_board_by_user($user){
        //execute la requete sur (id = $user->id)
        $query = self::execute("SELECT * FROM Board where owner = :id", array("id" => $user->id));
        //recup les résultats (ATTENTION utiliser fetchAll() quand on récup plusieurs objets).
        $data = $query->fetchAll();
        //table vide
        $tableBoard = [];
        //parcoure le resultat et crée un new board pour chaque resultat trouvé
        foreach ($data as $d){
            $tableBoard [] = new Board($d['ID'], $d['Title'], $d['Owner'], $d['CreatedAt'], $d['ModifiedAt']);
        }
        return $tableBoard;
    }

    //recup tout les boards de la DB
    public static function select_board(){
        $query = self::execute("SELECT * FROM Board", array());
        $data = $query->fetchALl();
        $tableBoard = [];
        foreach ($data as $d){
            $tableBoard [] = new Board($d['ID'], $d['Title'], $d['Owner'], $d['CreatedAt'], $d['ModifiedAt']);
        }
        return $tableBoard;
    }

    //recup uniquement les board des autres users
    public static function select_other_board($user){
        //execute la requete sur (id = $user->id)
        $query = self::execute("SELECT * FROM Board where owner != :id", array("id" => $user->id));
        //recup les résultats (ATTENTION utiliser fetchAll() quand on récup plusieurs objets).
        $data = $query->fetchAll();
        //table vide
        $tableBoard = [];
        //parcoure le resultat et crée un new board pour chaque resultat trouvé
        foreach ($data as $d){
            $tableBoard [] = new Board($d['ID'], $d['Title'], $d['Owner'], $d['CreatedAt'], $d['ModifiedAt']);
        }
        return $tableBoard;
    }

}