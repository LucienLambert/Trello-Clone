<?php
require_once "framework/Model.php";
require_once "controller/ControllerUser.php";

class Collaborate extends Model{
    private $idCollaborator;
    private $idBoard;

    public function __construct($idCollaborator, $idBoard){
        $this->idCollaborator = $idCollaborator;
        $this->idBoard = $idBoard;
    }

    public function getIdCollaborator(){
        return $this->idCollaborator;
    }

    public function getIdBoard(){
        return $this->idBoard;
    }

    public function getUser(){
        return User::select_user_by_id($this->getIdCollaborator());
    }

    public static function select_all_collaborator($board){
        $query = self::execute("SELECT * FROM Collaborate WHERE board= :board",array("board"=>$board->getID()));
        $data = $query->fetchAll();
        $table = [];
        if(count($data) == 0){
            return $table;
        }
        foreach ($data as $d){
            $table [] = new Collaborate($d["Collaborator"], $d["Board"]);
        }
        return $table;
    }

    public function insert_collaborator(){
        self::execute("INSERT INTO Collaborate(Collaborator,Board) VALUES (:idCollaborator, :idBoard)",
            array("idCollaborator"=>$this->getIdCollaborator(),
                "idBoard"=>$this->idBoard
            ));
        return true;
    }

    public function delete_collaborator(){
        self::execute("DELETE FROM Collaborate WHERE collaborator=:collaborator AND board= :board",
            array(
                "collaborator"=>$this->getIdCollaborator(),
                "board"=>$this->getIdBoard()
            ));
        return true;
    }

    public function delete_all_collaborator_by_board(){
        self::execute("DELETE FROM Collaborate WHERE board=:board", array("board"=>$this->getIdBoard()));
        return true;
    }

    public static function select_collaborator_by_board($idCollabo, $board){
        $query = self::execute("SELECT * FROM Collaborate WHERE board= :board AND collaborator= :collaborator", array(
           "board"=>$board->getId(),
           "collaborator"=>$idCollabo
        ));
        $data = $query->fetch();
        return new Collaborate($data["Collaborator"], $data["Board"]);
    }

    public static function list_board_collaboration_by_id_user($user){
        $query = self::execute("SELECT * FROM Collaborate WHERE collaborator=:user", array("user"=>$user->getId()));
        $data = $query->fetchAll();
        $tableCollaborator = [];
        if(empty($data)){
            return $tableCollaborator;
        } else {
            foreach ($data as $d) {
                $tableCollaborator [] = Board::select_board_by_id($d["Board"]);
                //$tableCollaborator [] = new Collaborate($d["Board"], $d["Collaborator"]);
            }
            return $tableCollaborator;
            /*
            $tableBoardCollaboration = [];
            foreach ($tableCollaborator as $collabo){
                $tableBoardCollaboration [] = Board::select_board_by_id($collabo->getIdBoard());
            }
            return $tableBoardCollaboration;
            */
        }
    }
}