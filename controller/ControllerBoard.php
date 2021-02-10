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
    private function list_board($error = [])
    {
        //recup le user connecté
        $user = $this->get_user_or_redirect();
        //recup le mail du user
        $user = User::select_member_by_mail($user->getMail());
        //recup la liste des boards du user.
        $tableBoard = Board::select_board_by_user($user);
        //recup la liste des boards de TOUS LE MONDE
        $tableOthersBoards = Board::select_other_board($user);
        //table vide pour contenir le nombre de colonne de chaque table
        $tableNbColumn = [];
        $tableNbColumnOther = [];
        foreach ($tableBoard as $board) {
            $tableNbColumn [] = count(Column::select_all_column_by_id_board($board));
        }
        foreach ($tableOthersBoards as $board) {
            $tableNbColumnOther [] = count(Column::select_all_column_by_id_board($board));
        }
        try {
            (new View("board"))->show(array("user" => $user, "tableBoard" => $tableBoard,
                "tableOthersBoards" => $tableOthersBoards, "tableNbColumn" => $tableNbColumn,
                "tableNbColumnOther" => $tableNbColumnOther, "error" => $error));
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    //ouvre le board selectionné
    public function open_board()
    {
        //check le boutonBoard pour voir si on selectionne un board.
        if (isset($_POST["boutonBoard"])) {
            if (isset($_GET["param1"]) && $_GET["param1"] != 0) {
                $this->redirect("board", "board", $_GET["param1"]);
            }
        }
    }

    //se chargera d'afficher les contenues du board sur le quel on est
    public function board($error = [])
    {
        if (isset($_GET["param1"]) && $_GET["param1"] != "") {
            $board = Board::select_board_by_id($_GET["param1"]);
        }
        $user = $this->get_user_or_false();
        $viewEditTitleBoard = false;
        $owner = User::select_user_by_id($board->getOwner());
        $tableFormatDateCreation = $this->diffDateFormat($board->getCreatedAt());
        $diffDateModif = $board->getModifiedAt();
        $diffDate = $tableFormatDateCreation[0];
        $messageTime = $tableFormatDateCreation[1];
        $tableColumn = Column::select_all_column_by_id_board_ASC($board->getId());
        $tableCardColumn = [];
        foreach ($tableColumn as $column) {
            $tableCardColumn [] = Card::select_all_card_by_id_column_ASC($column->getId());
        }
        if ($board->getModifiedAt() == null) {
            $modifDate = false;
            $messageTimeModif = "Never modified";
        } else {
            $modifDate = true;
            $tableFormatDateModif = $this->diffDateFormat($board->getModifiedAt());
            $diffDateModif = $tableFormatDateModif[0];
            $messageTimeModif = $tableFormatDateModif[1];
        }
        if (isset($_POST["openViewModifTitle"])) {
            $viewEditTitleBoard = true;
        }
        try {
            (new View("edit_board"))->show(array("board" => $board, "diffDate" => $diffDate, "messageTime" => $messageTime,
                "diffDateModif" => $diffDateModif, "messageTimeModif" => $messageTimeModif,
                "fullName" => $owner->getFullName(), "tableColumn" => $tableColumn,
                "viewEditTitleBoard" => $viewEditTitleBoard, "modifDate" => $modifDate,
                "tableCardColumn" => $tableCardColumn, "error" => $error, "user"=>$user));
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    //ajoute un board à la liste.
    public function add_board()
    {
        $user = $this->get_user_or_redirect();
        //$user = User::select_member_by_mail($user->getMail());
        //check le boutonAdd pour voir si on a cliqué dessus
        if (isset($_POST["boutonAdd"])) {
            $title = $_POST["title"];
            $board = new Board(null, $title, $user, null, null);
            //check si le fomulaire répond aux conditions d'ajout
            $error = $board->valide_board();
            //check si pas error
            if (count($error) == 0) {
                //$board = new Board(null, $title, $user, null, null);
                $board->insert_board($user);
                //return sur list_board pour réafficher la liste des boards rafraîchir.
                $this->redirect("board", "index");
            } else {
                //rappel la function list_board pour affichier les erreur si besoin.
                $this->list_board($error);
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
            $column = new Column(null, $title, $positionColumn, null, null, $board->getId());
            $error = Column::valide_column($board, $column->getTitle());

            if (count($error) == 0) {
                $column->inset_column($board);
                $this->redirect("board", "board", $_GET["param1"]);
            }
            $this->board($error);
        }
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
        if($user->getId() === $board->getOwner()){
            if (isset($_POST["modifTitle"])) {
                $newTitle = $_POST["newTitleBoard"];
                $board->setTitle($newTitle);
                $error = $board->valide_board();

                if (count($error) == 0) {
                    $board->update_title_board(new DateTime("now"));
                    $this->redirect("board", "board", $_GET["param1"]);
                } else {
                    $this->board($error);
                }
            }
        } else {
            $this->redirect("board", "board", $_GET["param1"]);
        }
    }

    //change le titre de la colonne sur laquelle on à cliqué.
    public function edit_Title_column()
    {

        $error = [];
        if (isset($_GET["param2"]) && $_GET["param2"] != 0 && isset($_GET["param1"]) && $_GET["param1"] != "") {
            $column = Column::select_column_by_id($_GET["param2"]);
            $board = Board::select_board_by_id($_GET["param1"]);
        }
        if($this->get_user_or_false()->getId() === $board->getOwner()){
            $title = $_POST["newTitleColumn"];
            $error = Column::valide_column($board, $title);
            if (count($error) == 0) {
                $column->update_title_column($column->getId(), $title, new DateTime("now"));
                $this->redirect("board", "board", $_GET["param1"]);
            } else {
                $this->board($error);
            }
        } else {
            $this->board();
        }
    }

    public function delete_board()
    {
        $user = $this->get_user_or_false();
        $function = "board";
        $objectNotif = "board (the columns and cards will be deleted too)";
        $resultat = "";
        if (isset($_GET["param1"]) && $_GET["param1"] != "") {
            $object = Board::select_board_by_id($_GET["param1"]);
        }
        if($this->get_user_or_false()->getId() === $object->getOwner()){
            if (isset($_POST["butonCancel"])) {
                $this->redirect("board", "index");
            } elseif (isset($_POST["butonDelete"])) {
                if ($object->delete_board_by_id()) {
                    $resultat = "successful deletion.";
                } else {
                    $resultat = "the board hasn't been deleted.";
                }
            }
        }
        (new View("conf_delete"))->show(array("function"=>$function, "resultat" => $resultat,
            "object" => $object, "objectNotif" => $objectNotif, "user"=>$user));
    }

    public function add_card()
    {
        $user = $this->get_user_or_false();
        $user = User::select_member_by_mail($user->getMail());
        $column = Column::select_column_by_id($_GET["param2"]);
        $board = Board::select_board_by_id($_GET["param1"]);
        $idColumn = $column->getId();
        if($user->getId() === $board->getOwner()){
            //contient les cartes de la colunne
            $tableCard = Card::select_all_card_by_id_column_ASC($idColumn);
            $positionCard = count($tableCard);
            $title = $_POST["titleCard"];
            $error = Card::valide_card($column, $title);
            if (count($error) == 0) {
                $card = new Card(null, $title, '', $positionCard, null, null, $user->getId(), $idColumn);
                $card->insert_card();
                $this->redirect("board", "board", $_GET["param1"]);
            }
            $this->board($error);
        }else {
            $this->redirect("board", "board", $_GET["param1"]);
        }
    }

    private function diffDateFormat($date)
    {
        $tableFormatDate = [];
        $createdAt = new DateTime($date);
        $diffDate = $createdAt->diff(new DateTime("now"));
        if ($diffDate->m == 0) {
            if ($diffDate->d == 0) {
                if ($diffDate->h == 0) {
                    if ($diffDate->i == 0) {
                        if ($diffDate->s < 0) {
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