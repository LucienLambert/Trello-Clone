<?php
require_once "framework/Model.php";

class User extends Model {
    private $id;
    private $mail;
    private $fullName;
    private $password;
    private $registeredAt;


    public function __construct($id, $mail, $fullName, $password, $registeredAt) {
        $this->id = $id;
        $this->mail = $mail;
        $this->fullName = $fullName;
        $this->password = $password;
        $this->registeredAt = $registeredAt;
    }

    //ajoute un user à la DB
    public function insert_user(){
        self::execute("INSERT INTO User(mail,fullName,password) VALUES(:mail,:fullName,:password)",
            array("mail" => $this->mail, "fullName" => $this->fullName, "password" => $this->password));
        return $this;
    }

    //recupère un user depuis son mail
    public static function get_member_by_mail($mail) {
        //cherche l'user par rapport à son mail
        $query = self::execute("SELECT * FROM User where mail = :mail", array("mail" => $mail));
        //récupère le ou les résultats obtenue par la query
        $data = $query->fetch();
        //si pas résultat alors false sinon créer un user avec les infos récupéré
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new User($data["id"], $data["mail"], $data["fullName"], $data["password"], $data["registeredAt"]);
        }
    }

    //check les erreurs possible
    //return un tableau contenant les erreurs.
    //sinon un tableau vide
    public function validate_signup($mail, $password, $conf_password, $fullName) {
        $error = [];
        //check l'email
        if (!isset($mail) || !is_string($mail) || strlen($mail) <= 0) {
            $error[] = "Email is required";
        } elseif (self::get_member_by_mail($mail)) {
            $error[] = "this Email already exist";
        }
        //check le fullName
        if (!isset($fullName) || !is_string($fullName)) {
            if (strlen($fullName) <= 0) {
                $error[] = "Your full Name is required";
            } elseif (strlen($fullName) <= 3) {
                $error[] = "Your full Name must contain between 3 and 16 letters";
            } elseif (preg_match("/^[a-zA-Z]*$/", $this->fullName)) {
                $error[] = "Your full Name must contain only letters";
            }
        }
        //check le password
        if (strlen($password) < 8 || strlen($password) > 16) {
            $error[] = "Your password must contain between 8 and 16 charactères";
        } elseif ($password != $conf_password) {
            $error[] = "You entered two different password.";
        }
        return $error;
    }

    public static function validate_login($mail, $password){
        $error = [];
        //check si email n'est pas vide
        if (!isset($mail) || !is_string($mail) || strlen($mail) <= 0) {
            $error[] = "Email is required";
            //check si email référence un user
        } elseif(self::get_member_by_mail($mail)) {
            //check si le password n'est pas vide
            if(!isset($password) || !is_string($password) || strlen($password) <= 0){
                $error[] = "Your password is required";
                //check si le password entré(hasher) correspond au password hasher de l'utilisateur.
            } elseif(Tools::my_hash($password) != self::get_member_by_mail($mail)->password) {
                $error [] = "password incorrect";
            }
        } else {
            $error [] = "'' invalid or does not exist";
        }
        return $error;
    }

}

?>