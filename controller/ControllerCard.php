<?php

require_once 'model/User.php';
require_once 'model/Board.php';
require_once 'model/Column.php';
require_once 'model/Card.php';
require_once 'model/Collaborate.php';
require_once 'model/Participate.php';
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
        $owner = User::select_user_by_id($board->getOwner());
        //check si le user est admin ou collaborateur ou owner
        if($owner->getId() != $user->getId() && User::check_collaborator_board($user,$board) == false && $user->getRole() != "admin"){
            $this->redirect("board","index");
        }
        $currentDate = new DateTime("now");
        $currentDate = $currentDate->format("Y-m-d");
        $fullName = User::select_user_by_id($card->getAuthor())->getFullName();
        $viewEditTitleCard = false;
        $tableFormatDateCreation = $this->diffDateFormat($card->getCreatedAt());
        $diffDateModif = $card->getModifiedAt();
        $diffDate = $tableFormatDateCreation[0];
        $messageTime = $tableFormatDateCreation[1];
        $tableParticipant = $this->participate();
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
            (new View("view_card"))->show(array("currentDate" => $currentDate, "card" => $card, "fullName" => $fullName, "viewEditTitleCard" => $viewEditTitleCard,
                "diffDate" => $diffDate, "messageTime" => $messageTime, "modifDate" => $modifDate, "diffDateModif" => $diffDateModif,
                "board" => $board, "column" => $column, "messageTimeModif" => $messageTimeModif, "user"=>$user,"tableParticipant"=>$tableParticipant));
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
        $owner = User::select_user_by_id($board->getOwner());
        //check si le user est admin ou collaborateur ou owner
        if($owner->getId() != $user->getId() && User::check_collaborator_board($user,$board) == false && $user->getRole() != "admin"){
            $this->redirect("board","index");
        }
        $authorCard = User::select_user_by_id($card->getAuthor());
        $tableFormatDateCreation = $this->diffDateFormat($card->getCreatedAt());
        $diffDateModif = $card->getModifiedAt();
        $diffDate = $tableFormatDateCreation[0];
        $messageTime = $tableFormatDateCreation[1];
        $tableCollabo = Collaborate::select_all_collaborator($board);
        $tableParticipant = $this->participate();
        $tablNotParti = $this->table_not_participant($board,$card);
        $tableParticipantValide = [];
        foreach($tableCollabo as $collabo){
            foreach($tablNotParti as $notParti){
                if($collabo->getUser() == $notParti){
                    $tableParticipantValide [] = $notParti;
                }
            }
        }
        if (!isset($diffDateModif)) {
            $modifDate = false;
            $messageTimeModif = "Never modified";
        } else {
            $modifDate = true;
            $tableFormatDateModif = $this->diffDateFormat($card->getModifiedAt());
            $diffDateModif = $tableFormatDateModif[0];
            $messageTimeModif = $tableFormatDateModif[1];
        }
        (new View("edit_card"))->show(array("user"=>$user, "card" => $card, "authorCard" => $authorCard,
            "diffDate" => $diffDate, "messageTime" => $messageTime, "modifDate" => $modifDate, "diffDateModif" => $diffDateModif,
            "board" => $board, "column" => $column, "messageTimeModif" => $messageTimeModif,"tableParticipant"=>$tableParticipant, "tablNotParti"=>$tablNotParti, "tableParticipantValide"=>$tableParticipantValide, "error" => $error));
    }

    private function move_card_right_or_left($card, $newColonne){
        $board = Board::select_board_by_id($newColonne->getBoard());
        var_dump($board);
        $user = $this->get_user_or_redirect();
        $owner = User::select_user_by_id($board->getOwner());
        //check si le user est admin ou collaborateur ou owner
        if($owner->getId() != $user->getId() && User::check_collaborator_board($user,$board) == false && $user->getRole() != "admin"){
            $this->redirect("board","index");
        }
        $card->move_card_and_add_last_position_right_or_left($newColonne);
        $board->uptdate_board_modiefiedAt(new DateTime("now"));
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
        $board = Board::select_board_by_id($newPosition->getBoard());
        $user = $this->get_user_or_redirect();
        $owner = User::select_user_by_id($board->getOwner());
        //check si le user est admin ou collaborateur ou owner
        if($owner->getId() != $user->getId() && User::check_collaborator_board($user,$board) == false && $user->getRole() != "admin"){
            $this->redirect("board","index");
        }
        $oldPosition->move_card_up_or_down($newPosition);
        $board->uptdate_board_modiefiedAt(new DateTime("now"));
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
            if($_POST["due_date"] != null){
                $dateCurrent = new DateTime("now");
                $dateCurrent = $dateCurrent->format('Y-m-d');
                if($dateCurrent > $_POST["due_date"]){
                    $error [] = "invalid due date.";

                } else {
                    $card->setDueDate($_POST["due_date"]);
                }
            }
            if(count($error) == 0){
                $card->setTitle($_POST["titleCard"]);
                $card->setBody($_POST["bodyCard"]);
                $card->update_card();
                $board = Board::select_board_by_id($column->getBoard());
                $board->uptdate_board_modiefiedAt(new DateTime("now"));
                $this->redirect("card", "view_card",$_GET["param2"]);
            }
            $this->edit_card($error);
        }
        if(isset($_POST["submit_participant"])){
            $this->add_participant();
            $this->redirect("card", "edit_card",$_GET["param2"]);
        }
    }

    public function delete_card()
    {
        $user = $this->get_user_or_false();
        $function = "card";
        $objectNotif = "card";
        if (isset($_GET["param1"]) && $_GET["param1"] != "") {
            $object = Card::select_card_by_id($_GET["param1"]);
            //recuperer le board
            $column = Column::select_column_by_id($object->getColumn());
            $board = Board::select_board_by_id($column->getBoard());
            $owner = User::select_user_by_id($board->getOwner());
            //check si le user est admin ou collaborateur ou owner
            if($owner->getId() != $user->getId() && User::check_collaborator_board($user,$board) == false && $user->getRole() != "admin"){
                $this->redirect("board","index");
            }
            /*$participants = Participate::select_all_participate_from_card($object);
            foreach($participants as $part){
                $part->delete_participant();
            }*/
            $participant = new Participate($object->getAuthor(),$object->getId());
            $participant->delete_all_participants();
        }
        
        if (isset($_POST["butonCancel"])) {
            $this->redirect("board", "board",$_GET["param2"]);
        } elseif (isset($_POST["butonDelete"])) {
            if ($object->delete_card_by_id()) {
                $board->uptdate_board_modiefiedAt(new DateTime("now"));
                $this->redirect("board", "board",$board->getId());
            }
        }
        (new View("conf_delete"))->show(array("function"=>$function,
            "object" => $object, "objectNotif" => $objectNotif, "user"=>$user, "board"=>$board));
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

    private function participate(){
        $user = $this->get_user_or_redirect();
        if(isset($_GET["param2"])){
            $card = Card::select_card_by_id($_GET["param2"]);
        }
        else{
            $card = Card::select_card_by_id($_GET["param1"]);
        }
        $tableParticipant = Participate::select_all_participate_from_card($card);
        return $tableParticipant;
    }

    private function table_not_participant($board,$card){
        $user = $this->get_user_or_redirect();
        $tablUser = $user->select_all_user($board);
        $tabNotParti = [];
        foreach($tablUser as $u){
            if(Participate::check_participate($u,$card) == false){
                $tabNotParti [] = $u; 
            }
        }
        return $tabNotParti;    
    }


    private function add_participant(){
        if(isset($_GET["param1"]) && isset($_GET["param2"])  && isset($_POST["participant_select"])){
            $idParticipant = $_POST["participant_select"];
            $idCard = $_GET["param2"];
            $user = $this->get_user_or_redirect();
            $card = Card::select_card_by_id($idCard);
            $board = Board::select_board_by_id($card->getBoard());
            if($board->getOwner() != $user->getId() && User::check_collaborator_board($user,$board) == false && $user->getRole() != "admin" && Participate::check_participate($user,$card)){
                $this->redirect("board","index");
            }
            $participant = new Participate($idParticipant,$idCard);
            $participant->insert_participant();
        }
    }

    public function del_participant(){
        if(isset($_GET["param1"]) && isset($_GET["param2"])){
            $idParticipant = $_GET["param1"];
            $idCard = $_GET["param2"];
            $user = $this->get_user_or_redirect();
            $card = Card::select_card_by_id($idCard);
            $board = Board::select_board_by_id($card->getBoard());
            if($board->getOwner() != $user->getId() && User::check_collaborator_board($user,$board) == false && $user->getRole() != "admin" && Participate::check_participate($user,$card)){
                $this->redirect("board","index");
            }
            $participant = new Participate($idParticipant,$idCard);
            $participant->delete_participant();
            $this->redirect("card","edit_card",$idCard);
        }    
    }

    public function del_due_date(){
        $cardDueDate = Card::select_card_by_id($_GET["param1"]);
        $cardDueDate->setDueDate(null);
        $cardDueDate->update_card();
        $this->redirect("card", "edit_card",$_GET["param1"]);
    }

    public function del_card_js(){
        $user = $this->get_user_or_false();
        $card = Card::select_card_by_id($_GET["param1"]);
        $board = Board::select_board_by_id($card->getBoard());
        if ($user->getId() === $board->getOwner()) {
            $participant = new Participate($card->getAuthor(),$card->getId());
            $participant->delete_all_participants();
            $card->delete_card_by_id();
            $board->uptdate_board_modiefiedAt(new DateTime("now"));
        }
        echo $board->getId();
    }

    public function move_card_js(){
        if (isset($_POST['update'])) {
            foreach($_POST['positions'] as $position) {
               $index = $position[0];
               $newPosition = $position[1];
               Card::move_card_up_and_down_js($index, $newPosition);         
            }
            exit('success');
        }
    }
}