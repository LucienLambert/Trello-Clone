<?php

require_once 'model/User.php';
require_once 'model/Board.php';
require_once 'model/Column.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';

class ControllerBoard extends Controller
{


    //Ceci est la 1er fonction qui sera appelé automatiquement
    //elle renvoie directement l'user vers la fonction list_Board()
    public function index()
    {
        $this->list_board();
    }

    //affiche tous les board
    public function list_board($error = [])
    {
        //recup le user connecté
        $user = $this->get_user_or_redirect();
        //recup le mail du user
        $user = User::select_member_by_mail($user->mail);
        //recup la liste des boards du user.
        $tableBoard = Board::select_board_by_user($user);
        //recup la liste des boards de TOUS LE MONDE
        $tableOthersBoards = Board::select_other_board($user);
        //table vide pour contenir le nombre de colonne de chaque table
        $tableNbColumn = [];
        foreach($tableBoard as $board){
            $tableNbColumn [] = count(Column::select_all_column_by_id_board($board));
        }
        (new View("board"))->show(array("user" => $user, "tableBoard" => $tableBoard,
            "tableOthersBoards" => $tableOthersBoards, "tableNbColumn" => $tableNbColumn,
            "error" => $error));
    }

    //ajoute un board à la liste.
    public function add_board()
    {
        $user = $this->get_user_or_redirect();
        $error = [];
        //check le boutonAdd pour voir si on a cliqué dessus
        if (isset($_POST["boutonAdd"])) {
            $title = $_POST["title"];
            //check si le fomulaire répond aux conditions d'ajout
            $error = Board::valide_board($title, $user);
            //check si pas eu d'erreur
            if (count($error) == 0) {
                $board = new Board(null, $title, $user, null, null);
                $board->insert_board($user);
                //retourne sur list_board pour réafficher la liste des boards rafraîchir.
                $this->redirect("board", "list_board");
            } else {
                //rappel la function list_board pour affichier les erreur si besoin.
                $this->list_board($error);
            }
        }
    }

    //ouvre le board selectionné
    public function open_board()
    {
        //check le boutonBoard pour voir si on selectionne un board.
        if (isset($_POST["boutonBoard"])) {
            if (isset($_GET["param1"]) && $_GET["param1"] != 0) {
                $this->redirect("board", "edit_board", $_GET["param1"]);
            }
        }
    }

    //se chargera d'afficher les contenues du board sur le quel on est
    public function edit_board($error = [])
    {
        if (isset($_GET["param1"]) && $_GET["param1"] != "") {
            $board = Board::select_board_by_id($_GET["param1"]);
        }
        $viewEditTitleBoard = false;
        $user = $this->get_user_or_redirect();
        $tableFormatDateCreation = $this->diffDateFormat($board->createdAt);
        $diffDateModif = $board->modifiedAt;
        $diffDate = $tableFormatDateCreation[0];
        $messageTime = $tableFormatDateCreation[1];
        $tableColumn = Column::select_all_column_by_id_board($board);
        if (!isset($board->modifiedAt)) {
            $modifDate = false;
            $messageTimeModif = "Never modified";
        } else {
            $modifDate = true;
            $tableFormatDateModif = $this->diffDateFormat($board->modifiedAt);
            $diffDateModif = $tableFormatDateModif[0];
            $messageTimeModif = $tableFormatDateModif[1];
        }
        if (isset($_POST["openViewModifTitle"])) {
            $viewEditTitleBoard = true;
        }
        (new View("edit_board"))->show(array("board" => $board, "diffDate" => $diffDate, "messageTime" => $messageTime,
            "diffDateModif" => $diffDateModif, "messageTimeModif" => $messageTimeModif,
            "fullName" => $user->fullName, "tableColumn" => $tableColumn,
            "viewEditTitleBoard" => $viewEditTitleBoard, "modifDate" => $modifDate, "error" => $error));
    }

    public function edit_title_board()
    {
        $user = $this->get_user_or_redirect();
        //check si le param1 n'est pas null ou vide (param1 = 1er paramètre dans l'url)
        if (isset($_GET["param1"]) && $_GET["param1"] != "") {
            //recup le board depuis si titre
            $board = Board::select_board_by_id($_GET["param1"]);
        }
        if (isset($_POST["modifTitle"])) {
            $newTitle = $_POST["newTitleBoard"];
            $error = Board::valide_board($newTitle, $user);

            if (count($error) == 0) {
                $board->update_title_board($newTitle, $board->id, new DateTime("now"));
                $this->redirect("board", "edit_board", $_GET["param1"]);
            } else {
                $this->edit_board($error);
            }
        }
    }

    public function add_column()
    {
        //check si le param1 n'est pas null ou vide (param1 = 1er paramètre dans l'url)
        if (isset($_GET["param1"]) && $_GET["param1"] != "") {
            //recup le board depuis si titre
            $board = Board::select_board_by_id($_GET["param1"]);
        }
        $tableColumn = Column::select_all_column_by_id_board($board);
        if (isset($_POST["boutonAddColumn"])) {
            $positionColumn = count($tableColumn);
            $title = $_POST["title"];
            $column = new Column(null, $title, $positionColumn, null, null, $board->id);
            $error = $column->valide_column($board);

            if (count($error) == 0) {
                $column->inset_column($board);
            }
            $this->edit_board($error);
        }
    }

    public function edit_Title_column()
    {
        $error = [];
        if(isset($_GET["param2"]) && $_GET["param2"] != 0){
            $column = Column::select_column_by_id($_GET["param2"]);
            $board = Board::select_board_by_id($_GET["param1"]);
        }

        if(isset($_POST["modifTitle"])){
            if(isset($_POST["newTitleColumn"])){
                $title = $_POST["newTitleColumn"];
                $error = $column->valide_column($board, $_POST["newTitleColumn"]);
                if(count($error) == 0){
                    $column->update_title_column($column->id, $title, new DateTime("now"));
                    var_dump($column);
                    $this->redirect("board", "edit_board", $_GET["param1"]);
                } else {
                    $this->edit_board($error);
                }
            }
        }
    }

    public function delete_board()
    {

    }

    public function delete_column()
    {

    }

    //calcule la différence de temps entre l'ajout et maintenant
    //return un tableau avec 2 valeurs.
    //[0] = diffTime = la différence de temps.
    //[1] = format sur lequel elle doit s'afficher.
    private function diffDateFormat($date)
    {
        $tableFormatDate = [];
        $createdAt = new DateTime($date);
        $diffDate = $createdAt->diff(new DateTime("now"));
        if ($diffDate->m == 0) {
            if ($diffDate->d == 0) {
                if ($diffDate->h == 0) {
                    if ($diffDate->i == 0) {
                        if($diffDate->s < 0){
                            $tableFormatDate[0] = $diffDate->s;
                            $tableFormatDate[1] = "Second";
                        }
                    }
                    $tableFormatDate[0] = $diffDate->i;
                    $tableFormatDate[1] = "min";
                } else {
                    $tableFormatDate[0] = $diffDate->h;
                    $tableFormatDate[1] = "Hour";
                }
            } else {
                $tableFormatDate[0] = $diffDate->d;
                $tableFormatDate[1] = "Day";
            }
        } else {
            $tableFormatDate[0] = $diffDate->m;
            $tableFormatDate[1] = "Month";
        }
        return $tableFormatDate;
    }
}