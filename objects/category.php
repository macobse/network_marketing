<?php
class Category{
 
    // database connection and table name
    private $conn;
    private $table_name = "categories";
 
    // object properties
    public $id;
    public $pname;
 
    public function __construct($db){
        $this->conn = $db;
    }
 
    // used by select drop-down list
    function read(){
        //select all data
        $query = "SELECT
                    id, cat_child_name
                FROM
                    " . $this->table_name . " WHERE cat_parent_name = 0
                ORDER BY
                    cat_parent_name";  
 
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
 
        return $stmt;
    }
    // used by select sub-category drop-down list
    function readSubCategory($cat_id)
    {
        # select all data
        $query = "SELECT
                    id, cat_child_name
                FROM
                    " . $this->table_name . " WHERE id = ". $cat_id . "
                ORDER BY
                    cat_child_name"; 
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
 
        return $stmt; 

    }
    // used to read category name by its ID
    function readName(){
     
        $query = "SELECT cat_child_name FROM " . $this->table_name . " WHERE cat_parent_name = 0 and id = ? limit 0,1";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
     
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
         
        $this->pname = $row['cat_child_name'];
    }

    // read all categories from database
    function readAll(){
 
    $query = "SELECT `id`, `cat_parent_name`, `cat_child_name`, `cat_description` FROM 
                " . $this->table_name . "
            ORDER BY
                cat_child_name ASC
            ";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
 
    return $stmt;
    }
}
?>