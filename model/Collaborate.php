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

    public static function select_collaborator($idUser){

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

    public function delete_collaborator($board){
        self::execute("DELETE FROM collaborate WHERE user=:user AND board:=board",
            array(
                "user"=>$this->getId(),
                "board"=>$board->getId()
            ));
        return true;
    }
}