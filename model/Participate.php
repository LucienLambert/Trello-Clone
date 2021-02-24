<?php

require_once "framework/Model.php";

class Participate extends Model
{
    private $idParticipate;
    private $idCard;

    public function __construct($idParticipate,$idCard)
    {
        $this->idParticipate = $idParticipate;
        $this->idCard = $idCard;
    }

    public function getIdParticipate(){
        return $this->idParticipate;
    }

    public function getIdCard(){
        return $this->idCard;
    }

    public function getUser(){
        return User::select_user_by_id($this->getIdParticipate());
    }    

    

    public static function check_participate($user,$card){
        $query = self::execute("SELECT * FROM participate WHERE participant=:user AND card=:card ",array(
            "user"=>$user->getId(),
            "card"=>$card->getId()
        ));
        $data = $query->fetch();
        if(empty($data)){
            return false;
        }
        return true;
    }

    public static function select_all_participate_from_card($card){
        $query = self::execute("SELECT * FROM participate WHERE card=:card",array(
            "card"=>$card->getId()
        ));
        $data = $query->fetchAll();
        $tabParticipate = [];
        if(count($data) != 0){
            foreach($data as $d){
                $tabParticipate [] = new Participate($d["Participant"],$d["Card"]);
            }
        }
        return $tabParticipate;
    }

    public function insert_participant(){
        $query = self::execute("INSERT INTO Participate(participant,card) VALUES(:participant,:card)",array(
            "participant"=>$this->getIdParticipate(),
            "card"=>$this->getIdCard()
        ));
    }

    public function delete_participant(){
        $query = self::execute("DELETE FROM Participate WHERE Card=:card AND Participant=:participant",array(
            "card"=>$this->getIdCard(),
            "participant"=>$this->getIdParticipate()
        ));
        return true;
    }

    public function delete_all_participants(){
        $query = self::execute("DELETE FROM Participate WHERE Card=:card",array(
            "card"=>$this->getIdCard()
        ));
        return true;
    }
}