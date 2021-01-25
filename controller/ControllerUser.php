<?php
require_once 'model/User.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';

//ce controller va gerer le signup et le log in
class ControllerUser extends Controller {

    //check si un user est connecté si connecté redirege vesr la page board sinon vers l'index
    public function index(){
        if($this->user_logged()){
            $this->redirect("Board", "index");
        } else {
            (new View("index"))->show();
        }
    }

    //page du formulaire login du visiteur
    public function login(){
        $mail = '';
        $password = '';
        $error = [];

        //check si le formulaire n'est pas vide
        if(isset($_POST['mail']) && isset($_POST['password'])) {
            $mail = $_POST['mail'];
            $password = $_POST['password'];

            //check s'il y a eu des erreurs pendant le check-up du login
            $error = User::validate_login($mail, $password);

            //s'il y n'a pas eux d'erreurs, on log l'user et le redirige vers la page d'accueil.
            if(empty($error)){
                $this->log_user(User::select_member_by_mail($mail));
            }
        }

        //affiche la vue du login avec les erreurs s'il y en a
        (new View("login"))->show(array("mail" => $mail, "password" => $password, "error" => $error));
    }

    //page du fomulaire sign up du visiteur
    public function signup(){
        $fullName = '';
        $mail = '';
        $password = '';
        $conf_password = '';
        $error = [];

        if(isset($_POST['mail']) && isset($_POST['fullName']) && isset($_POST['password']) && isset($_POST['conf_password'])){
            $fullName = $_POST['fullName'];
            $mail = $_POST['mail'];
            $password = $_POST['password'];
            $conf_password = $_POST['conf_password'];
            $user = new User(null, $mail, $fullName, Tools::my_hash($password), null);
            $error = array_merge($error, $user->validate_signup($mail,$password,$conf_password, $fullName));
            //si pas d'erreur
            if(count($error) == 0){
                //créer l'utilisateur et l'joute à la DB
                $user->insert_user();
                //connecte l'utilisateur et le redirige vers l'accueil
                $this->log_user($user);
            }
        }
        (new View("signup"))->show(
            array("mail" => $mail, "fullName" => $fullName, "password" => $password, "conf_password" => $conf_password, "error" => $error));
    }
}