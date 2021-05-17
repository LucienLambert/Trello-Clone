<?php

require_once 'model/User.php';
require_once 'model/Board.php';
require_once 'model/Card.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';
require_once "model/Collaborate.php";

class ControllerCalendar extends Controller{
    
    public function index(){
        $user = $this->get_user_or_redirect();
        $tablBoard = [];
        $AllBoard = Board::select_all_board();
        if($user->getRole() === 'admin'){
            $tablBoard = $AllBoard;
        }
        else{
            foreach($AllBoard as $board){
                if(User::check_collaborator_board($user,$board)){
                    $tablBoard [] = $board;
                }
                if($user->getId() == $board->getOwner() ){
                    $tablBoard [] = $board;
                }
            }
        }
        

        
        (new view("calendar"))->show(array("user"=>$user, "tablBoard"=>$tablBoard));
    }
}
?>