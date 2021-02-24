<?php

require_once "framework/Model.php";

class Card extends Model
{

    private $id;
    private $title;
    private $body;   //unique
    private $position;
    private $createdAt;
    private $modifiedAt; //unique
    private $author;
    private $column;
    private $dueDate;

    public function __construct($id, $title, $body, $position, $createdAt, $modifiedAt, $author, $column, $dueDate = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
        $this->position = $position;
        $this->createdAt = $createdAt;
        $this->modifiedAt = $modifiedAt;
        $this->author = $author;
        $this->column = $column;
        $this->dueDate = $dueDate;
    }

    public function getId()
    {
       return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getColumn(){
        return $this->column;
    }

    public function getDueDate(){
        return $this->dueDate;
    }

    public function getBoard(){
        $column = Column::select_column_by_id($this->getColumn());
        return $column->getBoard();
    }

    public function setPosition($position){
        $this->position = $position;
    }

    public function setTitle($title){
        $this->title = $title;
    }

    public function setBody($body){
        $this->body = $body;
    }

    public function setDueDate($dueDate){
        $this->dueDate = $dueDate;
    }

    public function insert_card(){
        self::execute("INSERT INTO Card(title,body,position,author,`column`) VALUES(:title,:body,:position,:author,:column)",
            array("title"=>$this->getTitle(), "body"=>$this->body,"position"=>$this->getPosition(),
                "author"=>$this->getAuthor(), "column"=>$this->getColumn()));
        return true;
    }

    public static function select_all_card_by_id_column_ASC($idColumn){
        $Cards = self::execute("SELECT * FROM Card WHERE `column` = :column ORDER BY position",array("column"=>$idColumn));
        $data = $Cards->fetchAll();
        $tableCards = [];
        foreach($data as $d){
            $tableCards[] = new Card($d["ID"],$d["Title"],$d["Body"],$d["Position"],$d["CreatedAt"],$d["ModifiedAt"],$d["Author"], $d["Column"], $d["DueDate"]);
        }
        return $tableCards;
    }

    //faire un appel DB pour récup toutes les colonnes du board -> faire un appel DB sur chaque colonne pour regarder si une carte avec le titre existe
    private static function check_card_with_title_exists_in_board($titleCard, $idBoard){
        $board = Board::select_board_by_id($idBoard);
        //j'ai recup toutes mes colonnes du board en question.
        $tableAllColumnBoard = Column::select_all_column_by_id_board_ASC($idBoard);
        foreach ($tableAllColumnBoard as $column){
            $checkCardTitle = self::execute("SELECT * FROM Card WHERE title = :title AND `column` = :column",array("title"=>$titleCard, "column"=>$column->getId()));
            if($checkCardTitle->rowCount() != 0){
                return true;
            }
        }
        return false;
    }

    public static function select_card_by_id($idCard){
        $card = self::execute("SELECT * FROM Card WHERE id = :id",array("id"=>$idCard));
        $data = $card->fetch();
        if($data == false){
            return null;
        }
        else{ 
            return new Card($data["ID"],$data["Title"],$data["Body"],$data["Position"],$data["CreatedAt"],$data["ModifiedAt"],$data["Author"], $data["Column"], $data["DueDate"]);
        }
    }

    //param1 = objet Colonne
    //param2 = String title
    public static function valide_card($column, $title){
        $cardTitle = Card::select_card_by_title($title, $column);
        $error = [];
        if (!isset($title) || strlen($title) <= 0 || !is_string($title)) {
            $error [] = "you must enter a title.";
        } elseif (strlen($title) < 3) {
            $error [] = "Your title's card must contain 3 characters minimum.";
        }

        //$trouverCard = Card::check_equals_title_card_by_column($cardTitle);
        if($cardTitle != null){
            $error [] ="the Column contains already a card with this title !";
        } else {
            $tableCardColumn = self::select_all_card_by_id_column_ASC($column->getId());
            foreach ($tableCardColumn as $card){
                if(strcasecmp($card->getTitle(),$title) == 0){
                    $error [] ="the Column contains already a card with this title";
                }
            }
        }
        return $error;
    }

    public static function select_card_by_title($title, $column){
        $query = self::execute("SELECT * FROM Card WHERE title=:title AND `column`=:column", array("title"=>$title, "column"=>$column->getId()));
        $d = $query->fetch();
        if($d == false){
            return null;
        }
        else{ 
            return new Card($d["ID"],$d["Title"],$d["Body"],$d["Position"],$d["CreatedAt"],$d["ModifiedAt"],$d["Author"], $d["Column"],$d["DueDate"]);
        }
    }

    public static function check_equals_title_card_by_column($card){
        $query = self::execute("SELECT * FROM Card WHERE title=:title AND id != :id AND `column`= :column", array("title"=>$card->getTitle(), "id"=>$card->getId(), "column"=>$card->getColumn()));
        $data = $query->fetchAll();
        if(count($data) == 0){
            return false;
        }
        return true;
    }

    //supprime toutes les cartes d'une colonne par rapport à l'id de la colonne.
    public function delete_all_card_by_Column(){
        if($this->getColumn() != null){
            self::execute("DELETE FROM Card WHERE `column` = :column",array("column"=>$this->getColumn()));
            return true;
        }
        return false;
    }

    //Cette méthode n'est plus utilisé.
    //est remplacé par update_card();
    public function update_card_modifiedAt(){
        $date = new DateTime("now");
        self::execute("UPDATE Card SET title = :title, body = :body, modifiedAt = :modifiedAt WHERE id = :id",array(
            "id"=>$this->getId(),
            "title"=>$this->getTitle(),
            "body"=>$this->getBody(),
            "modifiedAt"=>$date->format('Y-m-d H:i:s'),
        ));
        return true;
    }

    //update la carte current
    public function update_card(){
        $date = new DateTime("now");
        self::execute("UPDATE Card SET title = :title, body = :body, position = :position, createdAt = :createdAt, modifiedAt = :modifiedAt, author = :author, `column` = :column, dueDate= :dueDate WHERE id = :id",array(
            "id"=>$this->getId(),
            "title"=>$this->getTitle(),
            "body"=>$this->getBody(),
            "position"=>$this->getPosition(),
            "createdAt"=>$this->getCreatedAt(),
            "modifiedAt"=>$date->format('Y-m-d H:i:s'),
            "author"=>$this->getAuthor(),
            "column"=>$this->getColumn(),
            "dueDate"=>$this->getDueDate()
        ));
        return true;
    }

    public function move_card_and_add_last_position_right_or_left($newColumn){
        //recup le nombre de carte de la colonne
        $nbCardColumn = count(Card::select_all_card_by_id_column_ASC($newColumn->getId()));
        //recup toutes les cartes à partir de la position de la carte à déplacer
        $table = Card::select_all_card_from_position_modif($this);

        //déplace la carte vers l'autre colonne
        self::execute("UPDATE Card SET `column` = :column, position = :position WHERE id = :id",
            array("column"=>$newColumn->getId(), "id"=>$this->getId(), "position"=>$nbCardColumn));
        //parcours le tableau avec les cartes à update.
        for ($i = 0 ; $i < count($table); $i++){
            $currentCard = $table[$i];
            $currentCard->setPosition($currentCard->getPosition()-1);
            $currentCard->update_card();
        }
        return true;
    }

    //supprime la carte selectionné depuis son id et return la card supprimer si ok sinon false.
    public function delete_card_by_id(){
        $table = Card::select_all_card_from_position_modif($this);
        if($this != null){
            self::execute("DELETE FROM Card WHERE id= :id",array("id"=>$this->getId()));
            for ($i = 0 ; $i < count($table); $i++){
                $currentCard = $table[$i];
                $currentCard->setPosition($currentCard->getPosition()-1);
                $currentCard->update_card();
            }
            return true;
        }
        return false;
    }

    //return tableObject
    public static function select_all_card_from_position_modif($card){
        $query = self::execute("select * FROM Card WHERE position > :position AND `column` = :column", array(
            "position"=>$card->getPosition(),
            "column"=>$card->getColumn()
        ));
        $data = $query->fetchAll();
        $tableCard = [];
        foreach ($data as $d){
            $tableCard [] = new Card($d["ID"],$d["Title"],$d["Body"],$d["Position"],$d["CreatedAt"],$d["ModifiedAt"],$d["Author"], $d["Column"], $d["DueDate"]);
        }
        return $tableCard;
    }

    public function select_card_by_position_and_id_column($cardPosition, $column){
        $card = self::execute("SELECT * FROM Card WHERE position = :position AND `column` = :column",
            array("position"=>$cardPosition, "column"=>$column->getId()));
        $data = $card->fetch();
        return new Card($data["ID"],$data["Title"],$data["Body"],$data["Position"],$data["CreatedAt"],$data["ModifiedAt"],$data["Author"], $data["Column"], $data["DueDate"]);
    }

    public function move_card_up_or_down($newPositionCard){
        self::execute("UPDATE Card SET position = :position WHERE id= :id",
            array("id"=>$this->getId(), "position"=>$newPositionCard->getPosition()));

        self::execute("UPDATE Card SET position = :position WHERE id= :id",
            array("id"=>$newPositionCard->getId(), "position"=>$this->getPosition()));
        return true;
    }
}
?>