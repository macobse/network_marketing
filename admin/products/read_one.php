<?php
// set page headers
// get ID of the product to be read
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
 
// include database and object files
include_once '../../config/database.php';
include_once '../../objects/product.php';
include_once '../../objects/category.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare objects
$product = new Product($db);
$category = new Category($db);
 
// set ID property of product to be read
$product->id = $id;
 
// read the details of product to be read
$product->readOne();
//page info
$page_title = "Read One Product";
include('../../views/templates/header.php' );
 
// read products button
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-list'></span> Read Products";
    echo "</a>";
echo "</div>";
 // HTML table for displaying a product details
echo "<table class='table table-hover table-responsive table-bordered'>";
 
    echo "<tr>";
        echo "<td>Name</td>";
        echo "<td>{$product->name}</td>";
    echo "</tr>";
 
    echo "<tr>";
        echo "<td>Price</td>";
        echo "<td>&#36;{$product->price}</td>";
    echo "</tr>";
 
    echo "<tr>";
        echo "<td>Description</td>";
        echo "<td>{$product->description}</td>";
    echo "</tr>";
 
    echo "<tr>";
        echo "<td>Category</td>";
        echo "<td>";
            // display category name
            $category->id=$product->category_id;
            $category->readName();
            echo $category->pname;
        echo "</td>";
    echo "</tr>";
	 echo "<tr>";
	    echo "<td>Image</td>";
	    echo "<td>";
	        echo $product->image ? "<img src='uploads/{$product->image}' style='width:300px;' />" : "No image found.";
	    echo "</td>";
	echo "</tr>";
echo "</table>";
// set footer
include('../../views/templates/footer.php' );
?>