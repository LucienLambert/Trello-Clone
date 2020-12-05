<?php

require_once 'model/User.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';

class ControllerBoard extends Controller {


    //Ceci est la 1er fonction qui sera appelé automatiquement
    //elle renvoie directement l'user vers la fonction listBoard()
    public function index(){
        $this->listBoard();
    }

    //l'user est rediriger ici grâce à l'index,
    //
    public function listBoard() {
        //recupère le user connecté.
        $user = $this->get_user_or_redirect();
        //affiche la vue listeBoard avec l'user
        (new View("board"))->show(array("user" => $user));
    }

    public function listeBoards(){

    }
}