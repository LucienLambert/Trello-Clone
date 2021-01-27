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
        if (isset($_POST["butonCancel"])) {
            $this->redirect("board", "index");
        } elseif (isset($_POST["butonDelete"])) {
            if (Column::delete_column_by_id($_GET["param1"])) {
                $resultat = "successful deletion.";
            } else {
                $resultat = "the column hasn't been deleted.";
            }
        }
        (new View("conf_delete"))->show(array("function"=>$function, "resultat" => $resultat,
            "object" => $object, "objectNotif" => $objectNotif, "user"=>$user));
    }

    //switch les deux colonnes passé en paramètre.
    private function move_column($columnRigth = "", $columnLeft = "")
    {
        Column::move_column($columnRigth, $columnLeft);
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

}