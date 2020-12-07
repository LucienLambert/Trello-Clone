<?php

require_once 'model/User.php';
require_once 'model/Board.php';
require_once 'model/Column.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';

class ControllerBoard extends Controller {


    //Ceci est la 1er fonction qui sera appelé automatiquement
    //elle renvoie directement l'user vers la fonction list_Board()
    public function index(){
        $this->list_Board();
    }

    //affiche tous les board
    public function list_Board($error = []) {
        //recup le user connecté
        $user = $this->get_user_or_redirect();
        //recup le mail du user
        $user = User::select_member_by_mail($user->mail);
        //recup la liste des boards du user.
        $tableBoard = Board::select_board_by_user($user);
        //recup la liste des boards de TOUS LE MONDE
        $tableOthersBoards = Board::select_other_board($user);

        (new View("board"))->show(array("user" => $user, "tableBoard" => $tableBoard,
            "tableOthersBoards" => $tableOthersBoards, "error"=>$error));
    }

    //ajoute un board à la liste.
    public function add_board(){
        $user = $this->get_user_or_redirect();
        $error = [];
        //check le boutonAdd pour voir si on a cliqué dessus
        if(isset($_POST["boutonAdd"])){
            $title = $_POST["title"];
            //check si le fomulaire répond aux conditions d'ajout
            $error = Board::valide_board($title, $user);
            //check si pas eu d'erreur
            if(count($error) == 0){
                $board = new Board(null, $title, $user, null, null);
                $board->insert_board($user);
                //retourne sur list_board afin d'afficher les erreurs trouvé lors de la création du board.
                $this->redirect("board", "list_board");
            } else {
                $this->list_Board($error);
            }
        }
    }

    //ouvre le selectionné
    public function open_board(){
        //check le boutonBoard pour voir si on selectionne un board.
        if(isset($_POST["boutonBoard"])){
            $this->redirect("board","edit_board", $_POST["boutonBoard"]);
        }
    }

    public function add_column(){
        //check si le param1 n'est pas null ou vide (param1 = 1er paramètre dans l'url)
        if (isset($_GET["param1"]) && $_GET["param1"] != "") {
            //recup le board depuis si titre
            $board = Board::select_board_by_title($_GET["param1"]);
        }
        $tableColumn = Column::select_all_column_by_id_board($board);
        if(isset($_POST["boutonAddColumn"])){
            $positionColumn = count($tableColumn);
            $title = $_POST["title"];
            $column = new Column(null, $title, $positionColumn,null,null, $board);
            $error = $column->valide_column($board);

            if(count($error) == 0){
                $column->inset_column($board);
            }
            $this->edit_board($error, $board);
        }
    }

    //se chargera d'afficher les contenues du board sur le quel on est
    public function edit_board($error = [], $board = ""){
        //check si le param1 n'est pas null ou vide (param1 = 1er paramètre dans l'url)
        if (isset($_GET["param1"]) && $_GET["param1"] != "") {
            //recup le board depuis si titre
            $board = Board::select_board_by_title($_GET["param1"]);
        }
        //recup l'user connecté
        $user = $this->get_user_or_redirect();
        //save le titre du board
        $nameBoard = $board->title;
        //recup le fullName
        $fullName = $user->fullName;
        //recup la date de modif du board
        $modifiedAt = $board->modifiedAt;
        //recup une table contenant les formats des date du board(va servir pour l'affichage)
        $tableFormatDate = $this->diffDateFormat($board);
        $diffDate = $tableFormatDate[0];
        $messageTime = $tableFormatDate[1];
        //recup les colonnes du board selectionné
        $tableColumn = Column::select_all_column_by_id_board($board);
        if(!isset($modifiedAt)){
            $modifiedAt = "Never modified";
        }
        (new View("edit_board"))->show(array("nameBoard"=>$nameBoard, "diffDate"=>$diffDate, "messageTime"=>$messageTime,
            "fullName"=>$fullName, "modifiedAt"=>$modifiedAt, "tableColumn"=>$tableColumn, "error"=>$error));
    }

    //calcule la différence de temps entre l'ajout et le dernière modif du board
    //return un tableau avec 2 valeurs.
    //[0] = diffTime = la différence de temps.
    //[1] = en fonction de la différence de temps convertie l'affichage pour correspondre au bon format.
    private function diffDateFormat($board){
        $tableFormatDate = [];
        $createdAt = new DateTime($board->createdAt);
        $diffDate = $createdAt->diff(new DateTime("now"));
        if($diffDate->m == 0){
            if($diffDate->d == 0){
                if($diffDate->h == 0){
                    $tableFormatDate[0] = $diffDate = $diffDate->s;
                    $tableFormatDate[1] = $messageTime = "Second";
                }else {
                    $tableFormatDate[0] = $diffDate = $diffDate->h;
                    $tableFormatDate[1] = $messageTime = "Hour";
                }
            }else {
                $tableFormatDate[0] = $diffDate = $diffDate->d;
                $tableFormatDate[1] = $messageTime = "Day";
            }
        } else {
            $tableFormatDate[0] = $diffDate = $diffDate->m;
            $tableFormatDate[1] = $messageTime = "Month";
        }
        return $tableFormatDate;
    }
}