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
        self::execute("INSERT INTO Card(title,position,author,`column`) VALUES(:title,:position,:author,:column)",
            array("title"=>$this->getTitle(), "position"=>$this->getPosition(),
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

    public static function select_card_by_id($idCard){
        $card = self::execute("SELECT * FROM Card WHERE id = :id",array("id"=>$idCard));
        $data = $card->fetch();
        return new Card($data["ID"],$data["Title"],$data["Body"],$data["Position"],$data["CreatedAt"],$data["ModifiedAt"],$data["Author"], $data["Column"]);
    }

    public static function valide_card($idColumn, $title){
        $error = [];
        if (!isset($title) || strlen($title) <= 0 || !is_string($title)) {
            $error [] = "you must enter a title.";
        } elseif (strlen($title) < 3) {
            $error [] = "Your title's card must contain 3 characters minimum.";
        }
        $tableCardColumn = self::select_all_card_by_id_column_ASC($idColumn);
        if(count($tableCardColumn) == 0){
            return $error;
        }
        foreach ($tableCardColumn as $column) {
            if (strtolower($column->title) == strtolower($title)) {
                $error [] = "this collumn contain already a card with that title.";
            }
        }
        return $error;
    }
}
?>