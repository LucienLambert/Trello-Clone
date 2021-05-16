<?php

require_once 'model/User.php';
require_once 'model/Board.php';
require_once 'model/Column.php';
require_once 'model/Card.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';

class ControllerColumn extends Controller {

    public function index(){
        $this->redirect("board", "open_board");
    }

    public function delete_column() {
        $user = $this->get_user_or_false();
        $function = "column";
        $objectNotif = "column (the cards will be deleted too)";
        $resultat = "";
        if (isset($_GET["param1"]) && $_GET["param1"] != "") {
            $object = Column::select_column_by_id($_GET["param1"]);
        }
        $board = Board::select_board_by_id($object->getBoard());
        $owner = User::select_user_by_id($board->getOwner());
        //check si le user est admin ou collaborateur ou owner
        if($owner->getId() != $user->getId() && User::check_collaborator_board($user,$board) == false && $user->getRole() != "admin"){
            $this->redirect("board","index");
        }
       
        if (isset($_POST["butonCancel"])) {
            $this->redirect("board", "board",$_GET["param2"]);
        } elseif (isset($_POST["butonDelete"])) {
            if ($object->delete_column_by_id()) {
                $board->uptdate_board_modiefiedAt(new DateTime("now"));
                $this->redirect("board", "board",$board->getId());
            }
        }
        (new View("conf_delete"))->show(array("function"=>$function, "board" => $board,
            "object" => $object, "objectNotif" => $objectNotif, "user"=>$user));
    }

    //switch les deux colonnes passé en paramètre.
    private function move_column($columnRigth, $columnLeft = "")
    {
        $user = $this->get_user_or_redirect();
        $board = Board::select_board_by_id($columnRigth->getBoard());
        $owner = User::select_user_by_id($board->getOwner());
        //check si le user est admin ou collaborateur ou owner
        if($owner->getId() != $user->getId() && User::check_collaborator_board($user,$board) == false && $user->getRole() != "admin"){
            $this->redirect("board","index");
        }
        $columnRigth->move_column($columnLeft);
        $board->uptdate_board_modiefiedAt(new DateTime("now"));
        //Column::move_column($columnRigth, $columnLeft);
        $this->redirect("board", "board", $_GET["param1"]);
    }

    //déplace la colonne sur laquelle on est vers la droite.
    public function move_right_column()
    {
        //recup l'objet sur lequel on est
        $column = Column::select_column_by_id($_GET["param2"]);
        //recup la colonne de gauche.
        $columnToLeft = $column->select_column_by_board_and_position($column->getBoard(), $column->getPosition() + 1);
        //appel la function move_column
        $this->move_column($column, $columnToLeft);
    }

    public function move_left_column()
    {
        //recup l'objet sur lequel on est
        $column = Column::select_column_by_id($_GET["param2"]);
        //recup la colonne de droite
        $columnToRight = $column->select_column_by_board_and_position($column->getBoard(), $column->getPosition() - 1);
        //appel la private function move_column
        $this->move_column($columnToRight, $column);
    }

    public function del_column_js(){
        $user = $this->get_user_or_false();
        $column = Column::select_column_by_id($_GET["param1"]);
        $board = Board::select_board_by_id($column->getBoard());
        if ($user->getId() === $board->getOwner()) {
            $column->delete_column_by_id();
            $board->uptdate_board_modiefiedAt(new DateTime("now"));
        }
        echo $board->getId();
    }
    
    public function title_available_service(){
        $res = "true";
        if(isset($_POST["newTitleColumn"]) && $_POST["newTitleColumn"] !== "" && isset($_POST["board"]) && $_POST["board"] !== ""){
            $board = Board::select_board_by_id($_POST["board"]);
            $column = Column::select_column_by_title_and_board($_POST["newTitleColumn"],$board->getId());
            if($column){
                $res = "false";
            }
        }
        echo $res;
    }

    public function title_addColumn_available_service(){
        $res = "true";
        if(isset($_POST["title"]) && $_POST["title"] !== "" && isset($_POST["board"]) && $_POST["board"] !== ""){
            $board = Board::select_board_by_id($_POST["board"]);
            $column = Column::select_column_by_title_and_board($_POST["title"],$board->getId());
            if($column){
                $res = "false";
            }
        }
        echo $res;
    }
}