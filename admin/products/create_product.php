
<?php
// include database and object files
include_once '../../config/database.php';
include_once '../../objects/product.php';
include_once '../../objects/category.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// pass connection to objects
$product = new Product($db);
$category = new Category($db);
// set page headers
$page_title = "Create Product";
include('../../views/templates/header.php' ); 
$basedir = realpath(__DIR__);

// contents will be here
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-default pull-right'>Read Products</a>";
echo "</div>";

// if the form was submitted - PHP OOP CRUD Tutorial
if($_POST){
 
    // set product property values
    $product->name = $_POST['name'];
    $product->price = $_POST['price'];
    $product->description = $_POST['description'];
    $product->category_id = $_POST['category_id'];
    // $image=!empty($_FILES["image"]["name"])
    //         ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"]) : "";
    $image=!empty($_FILES["image"]["name"])
            ? basename($_FILES["image"]["name"]) : "";
    $product->image = $image;
   
    // create the product
    if($product->create()){
        echo "<div class='alert alert-success'>Product was created.</div>";
            //
    }
         // try to upload the submitted file

    // uploadPhoto() method will return an error message, if any.

    // if unable to create the product, tell the user

    else{
        echo "<div class='alert alert-danger'>Unable to create product.</div>";
    }
  echo $product->uploadPhoto();
    // if $file_upload_error_messages is still empty
  $oldpath = $_FILES['image']['tmp_name'];
  $newpath ="uploads/".$_FILES['image']['name'];
    if(empty($file_upload_error_messages)){
        // it means there are no errors, so try to upload the file
        if(move_uploaded_file($oldpath, $newpath)){
            // it means photo was uploaded
           
        }else{
                 $result_message.="<div class='alert alert-danger'>";
                $result_message.="<div>Unable to upload photo.</div>";
                $result_message.="<div>Update the record to upload photo.</div>";
                $result_message.="</div>";
        }
    }
     
    // if $file_upload_error_messages is NOT empty
    else{
        // it means there are some errors, so show them to user
        $result_message.="<div class='alert alert-danger'>";
            $result_message.="{$file_upload_error_messages}";
            $result_message.="<div>Update the record to upload photo.</div>";
        $result_message.="</div>";
    }
}
?>
 <!-- HTML form for creating a product -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
 
    <table class='table table-hover table-responsive table-bordered'>
 
        <tr>
            <td>Name</td>
            <td><input type='text' name='name' class='form-control' /></td>
        </tr>
 
        <tr>
            <td>Price</td>
            <td><input type='text' name='price' class='form-control' /></td>
        </tr>
 
        <tr>
            <td>Description</td>
            <td><textarea name='description' class='form-control'></textarea></td>
        </tr>
 
        <tr>
            <td>Category</td>
            <td>
            <?php
				// read the product categories from the database
				$stmt = $category->read();
				 
				// put them in a select drop-down
				echo "<select class='form-control' name='category_id'>";
				    echo "<option>Select category...</option>";
				 
				    while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)){
				        extract($row_category);
				        echo "<option value='{$id}'>{$cat_child_name}</option>";
				    }
				 
				echo "</select>";
				?>
            </td>
        </tr>
         <tr>
            <td>Photo</td>
            <td><input type="file" name="image" /></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Create</button>
            </td>
        </tr>
 
    </table>
</form>
<?php
// footer
include('../../views/templates/footer.php' );  
?>