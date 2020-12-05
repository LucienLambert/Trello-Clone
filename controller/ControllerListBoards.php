<?php


class ControllerListBoards extends Controller {


    //Ceci est la 1er fonction qui sera appelé automatiquement
    //elle renvoie directement l'user vers la fonction listBoard()
    public function index(){
        $this->listeBoard();
    }

    //l'user est rediriger ici grâce à l'index,
    //
    public function listBoard() {
        //return l'user connecté ou redirige vers l'accueil si pas de user
        $user = $this->get_user_or_redirect();
        (new View("listeBoard"))->show();
    }

    public function listeBoards(){

    }
}