<?php

require_once 'model/User.php';
require_once 'model/Board.php';
require_once 'model/Column.php';
require_once 'model/Card.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';

class ControllerCard extends Controller {

    public function index() {
        $this->view_card();
    }

    public function view_card()
    {
        $user = $this->get_user_or_redirect();
        if (isset($_GET["param1"]) && $_GET["param1"] != 0) {
            $card = Card::select_card_by_id($_GET["param1"]);
            $column = Column::select_column_by_id($card->getColumn());
        }
        $board = Board::select_board_by_id($column->getBoard());
        $fullName = User::select_user_by_id($card->getAuthor())->getFullName();
        $viewEditTitleCard = false;
        $tableFormatDateCreation = $this->diffDateFormat($card->getCreatedAt());
        $diffDateModif = $card->getModifiedAt();
        $diffDate = $tableFormatDateCreation[0];
        $messageTime = $tableFormatDateCreation[1];
        if (!isset($diffDateModif)) {
            $modifDate = false;
            $messageTimeModif = "Never modified";
        } else {
            $modifDate = true;
            $tableFormatDateModif = $this->diffDateFormat($card->getModifiedAt());
            $diffDateModif = $tableFormatDateModif[0];
            $messageTimeModif = $tableFormatDateModif[1];
        }
        if (isset($_POST["openViewModifTitle"])) {
            $viewEditTitleCard = true;
        }
        try {
            (new View("view_card"))->show(array("card" => $card, "fullName" => $fullName, "viewEditTitleCard" => $viewEditTitleCard,
                "diffDate" => $diffDate, "messageTime" => $messageTime, "modifDate" => $modifDate, "diffDateModif" => $diffDateModif,
                "board" => $board, "column" => $column, "messageTimeModif" => $messageTimeModif, "user"=>$user));
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function edit_card($error = [])
    {
        $user = $this->get_user_or_false();

        if (isset($_GET["param2"]) && $_GET["param2"] != 0) {
            $card = Card::select_card_by_id($_GET["param2"]);
            $column = Column::select_column_by_id($card->getColumn());
        } else {
            $card = Card::select_card_by_id($_GET["param1"]);
            $column = Column::select_column_by_id($card->getColumn());
        }

        $board = Board::select_board_by_id($column->getBoard());
        $fullName = $user->getFullName();
        $tableFormatDateCreation = $this->diffDateFormat($card->getCreatedAt());
        $diffDateModif = $card->getModifiedAt();
        $diffDate = $tableFormatDateCreation[0];
        $messageTime = $tableFormatDateCreation[1];
        if (!isset($diffDateModif)) {
            $modifDate = false;
            $messageTimeModif = "Never modified";
        } else {
            $modifDate = true;
            $tableFormatDateModif = $this->diffDateFormat($card->getModifiedAt());
            $diffDateModif = $tableFormatDateModif[0];
            $messageTimeModif = $tableFormatDateModif[1];
        }
        (new View("edit_card"))->show(array("user"=>$user, "card" => $card, "fullName" => $fullName,
            "diffDate" => $diffDate, "messageTime" => $messageTime, "modifDate" => $modifDate, "diffDateModif" => $diffDateModif,
            "board" => $board, "column" => $column, "messageTimeModif" => $messageTimeModif, "error" => $error));
    }

    private function move_card_right_or_left($card = "", $newColonne = ""){
        Card::move_card_and_add_last_position_right_or_left($card, $newColonne);
        if (isset($_GET["param1"]) && $_GET["param1"] != "") {
            $this->redirect("board","board", $_GET["param1"]);
        } else {
            $this->index();
        }
    }

    public function move_right_card(){
        //recup la colonne de la carte
        $column = Column::select_column_by_id($_GET["param2"]);
        //recup la carte de la colonne
        $card = Card::select_card_by_id($_GET["param3"]);
        //recup la colonne suivante (position + 1)
        $columnToRight = $column->select_column_by_board_and_position($column->getBoard(), $column->getPosition() + 1);
        $this->move_card_right_or_left($card, $columnToRight);
    }

    public function move_left_card(){
        //recup la colonne de la carte
        $column = Column::select_column_by_id($_GET["param2"]);
        //recup la carte de la colonne
        $card = Card::select_card_by_id($_GET["param3"]);
        //recup la colonne suivante (position + 1)
        $columnToLeft = $column->select_column_by_board_and_position($column->getBoard(), $column->getPosition() - 1);
        $this->move_card_right_or_left($card, $columnToLeft);
    }

    private function move_card_up_or_down($oldPosition, $newPosition){
        Card::move_card_up_or_down($oldPosition, $newPosition);
        $this->redirect("board", "board", $_GET["param1"]);
    }

    public function move_up_card(){
        //recup la colonne de la carte
        $column = Column::select_column_by_id($_GET["param2"]);
        //recup la carte sur laquel on est
        $card = Card::select_card_by_id($_GET["param3"]);
        //recup la carte juste en haut.
        $cardAbove = $card->select_card_by_position_and_id_column($card->getPosition() - 1, $column);
        $this->move_card_up_or_down($card, $cardAbove);
    }

    public function move_down_card(){
    //recup la colonne de la carte
        $column = Column::select_column_by_id($_GET["param2"]);
        //recup la carte sur laquel on est
        $card = Card::select_card_by_id($_GET["param3"]);
        //recup la carte juste en haut.
        $cardUnder = $card->select_card_by_position_and_id_column($card->getPosition() + 1, $column);
        $this->move_card_up_or_down($card, $cardUnder);
    }

    public function modif_card()
    {
        $error = [];
        if (isset($_POST["boutonCancel"])) {
            $this->redirect("card", "view_card", $_GET["param1"], $_GET["param2"]);
        } elseif (isset($_POST["boutonApply"])) {
            $card = Card::select_card_by_id($_GET["param2"]);
            $column = Column::select_column_by_id($_GET["param1"]);
            if (strcasecmp($card->getTitle(),$_POST["titleCard"]) != 0) {
                $error = Card::valide_card($column, $_POST["titleCard"]);
            }
            if(count($error) == 0){
                $card->setTitle($_POST["titleCard"]);
                $card->setBody($_POST["bodyCard"]);
                $card->update_card(new DateTime("now"));
                $this->redirect("card", "view_card",$_GET["param2"]);
            }
            $this->edit_card($error);
        }
    }

    public function delete_card()
    {
        $user = $this->get_user_or_false();
        $function = "card";
        $objectNotif = "card";
        $resultat = "";
        if (isset($_GET["param1"]) && $_GET["param1"] != "") {
            $object = Card::select_card_by_id($_GET["param1"]);
        }
        if (isset($_POST["butonCancel"])) {
            $this->redirect("board", "index");
        } elseif (isset($_POST["butonDelete"])) {
            if (Card::delete_card_by_id($object)) {
                $resultat = "successful deletion.";
            } else {
                $resultat = "the card hasn't been deleted.";
            }
        }
        (new View("conf_delete"))->show(array("function"=>$function,"resultat" => $resultat,
            "object" => $object, "objectNotif" => $objectNotif, "user"=>$user));
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