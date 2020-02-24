<?php class Product{
    private $conn;
    private $table_name = "submission";

 // object properties
    public $id;
    public $name;
    public $description;
    public $category_id;
    public $category_name;
    public $created;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
}
?>
