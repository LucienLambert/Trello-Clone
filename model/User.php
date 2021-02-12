<?php
require_once "framework/Model.php";
require_once 'model/Participate.php';

class User extends Model
{
    private $id;
    private $mail;
    private $fullName;
    private $password;
    private $registeredAt;
    private $role;


    public function __construct($id, $mail, $fullName, $password, $registeredAt, $role=null)
    {
        $this->id = $id;
        $this->mail = $mail;
        $this->fullName = $fullName;
        $this->password = $password;
        $this->registeredAt = $registeredAt;
        $this->role = $role;
    }

    public function getFullName()
    {
        return $this->fullName;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRegisteredAt()
    {
        return $this->registeredAt;
    }

    public function getRole(){
        return $this->role;
    }

    public function setRole($role){
        $this->role = $role;
    }

    //ajoute un user à la DB
    public function insert_user()
    {
        self::execute("INSERT INTO User(mail,fullName,password) VALUES(:mail,:fullName,:password)",
            array("mail" => $this->getMail(), "fullName" => $this->getFullName(), "password" => $this->getPassword()));
        return $this;
    }

    //recupère un user depuis son mail
    public static function select_member_by_mail($mail)
    {
        //cherche l'user par rapport à son mail
        $query = self::execute("SELECT * FROM User where mail = :mail", array("mail" => $mail));
        //récupère le ou les résultats obtenue par la query (1 logiquement)
        $data = $query->fetch();
        //si pas résultat alors false sinon créer un user avec les infos récupéré
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new User($data["ID"], $data["Mail"], $data["FullName"], $data["Password"], $data["RegisteredAt"], $data["Role"]);
        }
    }

    public static function select_user_by_id($idUser){
        $query = self::execute("SELECT * FROM User where id = :id", array("id" => $idUser));
        $data = $query->fetch();
        if ($query->rowCount() == 0) {
            return null;
        } else {
            return new User($data["ID"], $data["Mail"], $data["FullName"], $data["Password"], $data["RegisteredAt"], $data["Role"]);
        }
    }

    //check les erreurs possible
    //return un tableau contenant les erreurs.
    //sinon un tableau vide
    public function validate_signup($mail, $password, $conf_password, $fullName)
    {
        $error = [];
        //check l'email
        if (!isset($mail) || !is_string($mail) || strlen($mail) <= 0) {
            $error[] = "Email is required";
        } elseif (self::select_member_by_mail($mail)) {
            $error[] = "this Email already exist";
        }
        //check le fullName
        //isset == null
        if (!isset($fullName) || !is_string($fullName) || $fullName == "") {
            if (strlen($fullName) <= 0) {
                $error[] = "Your full Name is required";
            } elseif (strlen($fullName) < 3) {
                $error[] = "Your full Name must contain between 3 and 16 letters";
            } elseif (preg_match("/^[a-zA-Z]*$/", $this->fullName)) {
                $error[] = "Your full Name must contain only letters";
            }
        }
        //check le password
        if (strlen($password) <= 8 || strlen($password) > 16) {
            $error[] = "Your password must contain between 8 and 16 charactères";
        } elseif ($password != $conf_password) {
            $error[] = "You entered two different password.";
        } elseif(!preg_match('/[0-9A-Za-z!]*$/', $password)){
            $error[] = "Your password must contain a special character";
        }
        if (!((preg_match("/[A-Z]/", $password)) && preg_match("/\d/", $password) && preg_match("/['\";:,.\/?\\-]/", $password))) {
            $errors[] = "Password must contain one uppercase letter, one number and one punctuation mark.";
        }
        return $error;
    }

    public static function validate_login($mail, $password)
    {
        $error = [];
        //check si email n'est pas vide
        if (!isset($mail) || !is_string($mail) || strlen($mail) <= 0) {
            $error[] = "Email is required";
            //check si email référence un user
        } elseif (self::select_member_by_mail($mail)) {
            //check si le password n'est pas vide
            if (!isset($password) || !is_string($password) || strlen($password) <= 0) {
                $error[] = "Your password is required";
                //check si le password entré(hasher) correspond au password hasher de l'utilisateur.
            } elseif (Tools::my_hash($password) != self::select_member_by_mail($mail)->password) {
                $error [] = "password incorrect";
            }
        } else {
            $error [] = "$mail invalid or does not exist";
        }
        return $error;
    }

    //check si un user est un collaborateur d'un board
    public static function check_collaborator_board($user,$board){
        $query = self::execute("SELECT * FROM Collaborate WHERE board=:board and collaborator=:user",array(
            "board" => $board->getId(),
            "user" => $user->getId()
        ));
        $data = $query->fetch();
        if(empty($data)){
            return false;
        }
        return true;
    }

    //recup tout les users sauf le proprio du board
    public function select_all_user($board){
        $query = self::execute("SELECT * FROM User WHERE id!= :id",array("id"=>$board->getOwner()));
        $data = $query->fetchAll();
        $tableUser = [];
        foreach ($data as $d){
            $tableUser[] = new User($d["ID"], $d["Mail"], $d["FullName"], $d["Password"], $d["RegisteredAt"], $d["Role"]);
        }
        return $tableUser;
    }

    //recup tous les users sauf le user connecté.
    public function select_all_users(){
        $query = self::execute("SELECT * FROM User WHERE id!= :id",array("id"=>$this->getId()));
        $data = $query->fetchAll();
        $tableUser = [];
        foreach ($data as $d){
            $tableUser[] = new User($d["ID"], $d["Mail"], $d["FullName"], $d["Password"], $d["RegisteredAt"], $d["Role"]);
        }
        return $tableUser;
    }
    
    //update role user
    public function update_role(){
        self::execute("UPDATE User SET role=:role WHERE id = :id",
            array(
                "role" =>$this->getRole(),
                "id" => $this->getId()
            ));
        return true;
    }

}

?>