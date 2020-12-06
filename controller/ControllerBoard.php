<?php

require_once 'model/User.php';
require_once 'model/Board.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';

class ControllerBoard extends Controller {


    //Ceci est la 1er fonction qui sera appelé automatiquement
    //elle renvoie directement l'user vers la fonction listBoard()
    public function index(){
        $this->listBoard();
    }

    //l'user est rediriger ici grâce à l'index,
    //se chargera d'afficher tout les board.
    public function listBoard() {
        $error = [];

        //recupère le user connecté.
        $user = $this->get_user_or_redirect();
        $user = User::select_member_by_mail($user->mail);

        //check si le formulaire n'est pas vide
        if(isset($_POST["title"])){
            $title = $_POST["title"];
            $error = Board::valide_board($title, $user);

            //check si pas eu d'erreur
            if(count($error) == 0){
                $board = new Board(null, $title, $user, null, null);
                $board->insert_board($user);
            }
        }

        //recup la liste des boards du user.
        $tableBoard = Board::select_board_by_user($user);
        //recup la liste des boards de TOUS LE MONDE
        $tableOthersBoards = Board::select_other_board($user);

        //affiche la vue listeBoard avec l'user
        (new View("board"))->show(array("user" => $user, "tableBoard" => $tableBoard,
            "tableOthersBoards" => $tableOthersBoards,"error"=>$error));
    }
}