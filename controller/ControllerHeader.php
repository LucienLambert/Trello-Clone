<?php
class ControllerHeader extends Controller{

    public function index()
    {
       $user = $this->get_user_or_false();
        (new View("header"))->show(array("user"=>$user));
    }
}