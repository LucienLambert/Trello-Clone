<?php


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

    public function __construct($id, $title, $body, $position, $createdAt, $modifiedAt, $author, $column)
    {
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
        $this->position = $position;
        $this->createdAt = $createdAt;
        $this->modifiedAt = $modifiedAt;
        $this->author = $author;
        $this->column = $column;
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
            $tableCards[] = new Card($d["ID"],$d["Title"],$d["Body"],$d["Position"],$d["CreatedAt"],$d["ModifiedAt"],$d["Author"], $d["Column"]);
        }
        return $tableCards;
    }

    //TODO : TROUVER MEILLEUR SOLUTION SI POSSIBLE
    //faire un appel DB pour récup toutes les colonnes du board -> faire un appel DB sur chaque colonne pour regarder si une carte avec le titre existe
    private static function check_card_with_title_exists_in_board($titleCard, $idBoard){
        $board = Board::select_board_by_id($idBoard);
        //j'ai recup toutes mes colonnes du board en question.
        $tableAllColumnBoard = Column::select_all_column_by_id_board_ASC($idBoard);
        foreach ($tableAllColumnBoard as $column){
            $checkCardTitle = self::execute("SELECT * FROM Card WHERE title = :title AND `column` = :column",array("title"=>$titleCard, "column"=>$column->id));
            if($checkCardTitle->rowCount() != 0){
                return true;
            }
        }
        return false;
    }

    public static function select_card_by_id($idCard){
        $card = self::execute("SELECT * FROM Card WHERE id = :id",array("id"=>$idCard));
        $data = $card->fetch();
        return new Card($data["ID"],$data["Title"],$data["Body"],$data["Position"],$data["CreatedAt"],$data["ModifiedAt"],$data["Author"], $data["Column"]);
    }
    //param1 = objet Colonne
    //param2 = String title
    public static function valide_card($column, $title){
        $error = [];
        if (!isset($title) || strlen($title) <= 0 || !is_string($title)) {
            $error [] = "you must enter a title.";
        } elseif (strlen($title) < 3) {
            $error [] = "Your title's card must contain 3 characters minimum.";
        }
        $tableCardColumn = self::select_all_card_by_id_column_ASC($column->id);
        if(count($tableCardColumn) == 0){
            return $error;
        }
        $trouverCard = Card::check_card_with_title_exists_in_board($title, $column->board);
        if ($trouverCard) {
            $error [] = "this board contain already a card with that title.";
        }

        return $error;
    }

    //supprime la carte selectionné depuis son id et return la card supprimer si ok sinon false.
    public static function delete_card_by_id($idCard){
        if(isset($idCard)){
            self::execute("DELETE FROM Card WHERE id= :id",array("id"=>$idCard));
            return true;
        }
        return false;
    }
    //supprime toutes les cartes d'une colonne par rapport à l'id de la colonne.
    public static function delete_all_card_by_Column($idColumn){
        if(isset($idColumn)){
            self::execute("DELETE FROM Card WHERE `column` = :column",array("column"=>$idColumn));
        } else{
            return false;
        }
    }
}
?>