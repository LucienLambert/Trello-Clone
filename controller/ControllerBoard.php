<?php

require_once 'model/User.php';
require_once 'model/Board.php';
require_once 'model/Column.php';
require_once 'model/Card.php';
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
        $tableNbColumnOther = [];
        foreach($tableBoard as $board){
            $tableNbColumn [] = count(Column::select_all_column_by_id_board($board));
        }
        foreach($tableOthersBoards as $board){
            $tableNbColumnOther [] = count(Column::select_all_column_by_id_board($board));
        }
        (new View("board"))->show(array("user" => $user, "tableBoard" => $tableBoard,
            "tableOthersBoards" => $tableOthersBoards, "tableNbColumn" => $tableNbColumn,
            "tableNbColumnOther" => $tableNbColumnOther,"error" => $error));
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
        //table à deux dimenssion [la colonnes][les cartes de la colonnes]
        $tableColumn = Column::select_all_column_by_id_board_ASC($board);
        $tableCardColumn = [];
        foreach ($tableColumn as $column){
            $tableCardColumn [$column->position] = Card::select_all_card_by_id_column_ASC($column->id);
        }
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
            "viewEditTitleBoard" => $viewEditTitleBoard, "modifDate" => $modifDate,
            "tableCardColumn"=> $tableCardColumn, "error" => $error));
    }

    //change le titre du board sur le quel on est
    public function edit_title_board()
    {
        $user = $this->get_user_or_redirect();
        //check si le param1 n'est pas null ou vide
        if (isset($_GET["param1"]) && $_GET["param1"] != "") {
            //recup le board depuis son titre
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

    //ajout d'une nouveau colonne au board sur lequel on est.
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
            $error = Column::valide_column($board, $column->title);

            if (count($error) == 0) {
                $column->inset_column($board);
            }
            $this->edit_board($error);
        }
    }

    //change le titre de la colonne sur laquelle on à cliqué.
    public function edit_Title_column()
    {
        $error = [];
        if(isset($_GET["param2"]) && $_GET["param2"] != 0 && isset($_GET["param1"]) && $_GET["param1"] != ""){
            $column = Column::select_column_by_id($_GET["param2"]);
            $board = Board::select_board_by_id($_GET["param1"]);
        }
        $title = $_POST["newTitleColumn"];
        $error = Column::valide_column($board, $title);
        if(count($error) == 0){
            $column->update_title_column($column->id, $title, new DateTime("now"));
            $this->redirect("board", "edit_board", $_GET["param1"]);
        } else {
            $this->edit_board($error);
        }
    }


    //switch les deux colonnes passé en paramètre.
    private function move_column($columnRigth = "", $columnLeft = "")
    {
        Column::move_column($columnRigth,$columnLeft);
        $this->redirect("board", "edit_board", $_GET["param1"]);

    }

    //déplace la colonne sur laquelle on est vers la droite.
    public function move_right_column()
    {
        //recup l'objet sur lequel on est
        $column = Column::select_column_by_id($_GET["param2"]);
        //recup la colonne de gauche.
        $columnToLeft = $column->select_column_by_board_and_position($column->board, $column->position+1);
        //appel la function move_column
        $this->move_column($column, $columnToLeft);
    }

    public function move_left_column()
    {
        //recup l'objet sur lequel on est
        $column = Column::select_column_by_id($_GET["param2"]);
        //recup la colonne de droite
        $columnToRight = $column->select_column_by_board_and_position($column->board, $column->position-1);
        //appel la function move_column
        $this->move_column($columnToRight, $column);
    }

    public function add_card(){
        $user = $this->get_user_or_false();
        $idColumn = $_GET["param2"];
        //contient les cartes de la colunne
        $tableCard = Card::select_all_card_by_id_column_ASC($idColumn);
        $positionCard = count($tableCard);
        $title = $_POST["titleCard"];
        $error = Card::valide_card($idColumn, $title);
        if (count($error) == 0) {
            $card = new Card(null, $title, null, $positionCard, null, null, $user->id, $idColumn);
            $card->insert_card();
            $this->redirect("board", "edit_board", $_GET["param1"]);
        }
        $this->edit_board($error);
    }

    public function view_card(){
        if (isset($_GET["param1"]) && $_GET["param1"] != 0) {
            $card = Card::select_card_by_id($_GET["param1"]);
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