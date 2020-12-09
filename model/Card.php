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

    public function gettitle()
    {
        return $this->title;
    }

    public function getbody()
    {
        return $this->body;
    }

    public function getposition()
    {
        return $this->position;
    }

    public function getcreatedAt()
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
        return $this->Column;
    }

    public function select_all_card_by_id_column_ASC($idColumn){
        $Cards = self::execute("SELECT * FROM Card WHERE column = :column ORDER BY position",array("column"=>$idColumn));
        $data = $Cards->fetchAll();
        $tableCards = [];
        foreach($data as $d){
            $tableCards[] = new Card($d["ID"],$d["Title"],$d["Body"],$d["Position"],$d["CreatedAt"],$d["ModifiedAt"],$d["Author"], $d["Column"]);
        }
        return $tableCards;
    }
}