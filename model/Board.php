<?php

require_once "framework/Model.php";

class Board extends Model
{

    private $id;
    private $title;
    private $owner;
    private $createdAt;
    private $modifiedAt;

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

    public function setTitle($title){
        $this->title = $title;
    }


    //ajoute un board dans la DB
    public function insert_board($user)
    {
        self::execute("INSERT INTO Board(title,owner) VALUES(:title,:owner)", array("title" => $this->getTitle(), "owner" => $user->getId()));
        return true;
    }

    //verifie si l'ajout de la table respect bien les conditions
    public function valide_board()
    {
        //contiendra les erreurs
        $error = [];
        //recup la liste des board du user
        $tableBoard = self::select_all_board();
        //check si le titre n'est pas une string vide, si c'est bien une string, si c'est pas null
        if ($this->getTitle() == null || strlen($this->getTitle()) <= 0 || !is_string($this->getTitle())) {
            $error [] = "You must enter a title for you board";
            //parcoure la table
        } elseif(strlen($this->getTitle()) < 3){
            $error [] = "Your title must contain 3 characters minimum.";
        }
        foreach ($tableBoard as $board) {
            //controler si une table ne porte pas déjà un titre identique (convertie les String en minuscule).
            if (strtolower($board->getTitle()) == strtolower($this->getTitle())) {
                $error [] = "this table title is already used, please choose another title";
            }
        }
        return $error;
    }

    //récup la liste des boards via l'id du user
    public static function select_board_by_user($user)
    {
        //execute la requete sur (id = $user->id)
        $query = self::execute("SELECT * FROM Board where owner = :id", array("id" => $user->getId()));
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
            if ($board->getOwner() != $user->getId()) {
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
        if($data == false){
            return null;
        }
        else 
            return new Board($data['ID'], $data['Title'], $data['Owner'], $data['CreatedAt'], $data['ModifiedAt']);
    }

    //recup le board via son id
    public static function select_board_by_id($id)
    {
        $query = self::execute("SELECT * FROM Board where id = :id", array("id" => $id));
        $data = $query->fetch();
        return new Board($data["ID"], $data["Title"], $data["Owner"], $data["CreatedAt"], $data["ModifiedAt"]);
    }

    public function update_title_board($modifiedAt)
    {
        self::execute("UPDATE Board SET title = :title, modifiedAt = :modifiedAt WHERE id = :id",
            array("title" => $this->getTitle(), "id" => $this->getId(), "modifiedAt" => $modifiedAt->format('Y-m-d H:i:s')));
        return true;
    }

    public function delete_board_by_id()
    {
        if($this->getId() != null){
            $columnBoard = Column::select_all_column_by_id_board($this);
            foreach ($columnBoard as $column){
                $column->delete_all_column_by_id_board();
            }
            $collabo = new Collaborate($this->getOwner(), $this->getId());
            $collabo->delete_all_collaborator_by_board();
            self::execute("DELETE FROM Board WHERE id= :id",array("id"=>$this->getId()));
            return true;
        }
        return false;
    }

    public function uptdate_board_modiefiedAt($modifiedAt){
        self::execute("UPDATE Board SET modifiedAt = :modifiedAt WHERE id = :id",
        array("id" => $this->getId(),"modifiedAt" => $modifiedAt->format('Y-m-d H:i:s')));
    return true;
    }

    
}