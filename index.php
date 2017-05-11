
<?php
 session_start();


  // Connect to database
  require_once('config/database.php');
  $database = new Database();
  $db = $database->getConnection();
include_once 'objects/product.php';
include_once 'objects/category.php';
// core.php holds pagination variables
include_once 'config/core.php';
//initalization
$product = new Product($db);
$category = new Category($db);

// query products
$stmt = $product->readAll($from_record_num, $records_per_page);
 
// specify the page where paging is used
$page_url = "index.php?";
 
// count total rows - used for pagination
$total_rows=$product->countAll();
  //Load user class
  require_once('objects/user.php');
  $user = new USER($db);
  // if (isset($_SESSION['user_session'])) {

  //   # code...
  //   $user->redirect('admin/products/index.php');
  // }
if(isset($_POST['btn-login']))
{

 $umail = $_POST['txt_uname_email'];
 $upass = $_POST['txt_password'];
  
 if($user->login($umail,$upass))
 {
  if (isset($_SESSION['user_session'])) {
  #redirect unauthorized user
  $user->redirect('test.php');
   
  }
  echo "UUUUUUhuu..Error!";  
  
 }
 else
 {
  $error = $umail."Wrong Details !";
 } 
}

  ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Network Marketing</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  

  <link href="libs/css/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="libs/js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="libs/css/bootstrap/dist/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Add a gray background color and some padding to the footer */
    footer {
      background-color: #f2f2f2;
      padding: 25px;
    }
    
  .carousel-inner img {
      width: 100%; /* Set width to 100% */
      margin: auto;
      min-height:200px;
  }
  .top-header{
  	 background-color: #00ffff;
    height: 40px;
  }
  /* Hide the carousel text when the screen is less than 600 pixels wide */
  @media (max-width: 600px) {
    .carousel-caption {
      display: none; 
    }
  }
   .btn {
      padding: 10px 20px;
      background-color: #333;
      color: #f1f1f1;
      border-radius: 0;
      transition: .2s;
  }
    .btn:hover, .btn:focus {
      border: 1px solid #333;
      background-color: #fff;
      color: #000;
  }

  li a:hover, a:focus{
  	      background-color: #fff;
      color: #000;
  }
  </style>
</head>
<body>
<div class="row">
<div class="top-header"> 
 <div class="container">
	<div class="col-lg-10">
		
	</div>
   <div class="col-lg-2">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="auth/sign-up.php">Sign up</a></li>
        <?php

          if (!isset($_SESSION['user_session'])) { 

            # code...
            ?>
            <li ><a href="auth/login.php" class="glyphicon glyphicon-log-in"><span data-toggle="modal" data-target="#myModal">&nbsp;Login</span> </a></li>
            <?php
            }

          else{
          ?>
          <li><a href="dashboard.php" class="glyphicon glyphicon-log-in"><span data-toggle="modal" data-target="#myModal">&nbsp;Dashboard</span> </a></li>
            <li><a href="auth/logout.php" class="glyphicon glyphicon-log-in"><span data-toggle="modal" data-target="#myModal">&nbsp;Logout</span> </a></li>
            <?php
          }
        ?>
        
      </ul>
	</div>
	</div>
	</div>
</div>


<div class="row">
   <div class="container">
	<div class="col-lg-10">
		
	</div>
   <div class="col-lg-2">
	
<form role='search' action='search.php'>
    <div class='input-group col-md-3 pull-left margin-right-1em'>
       
        <input type='text' class='form-control' name='s' id='srch-term' required/>
        <div class='input-group-btn'>";
            <button class='btn btn-primary' type='submit'><i class='glyphicon glyphicon-search'></i></button>
        </div>
    </div>
</form>| 
			<a href="#"><span class="glyphicon glyphicon-shopping-cart"></span></a>

		 <!-- Trigger the modal with a button -->
		
		<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h2 class="modal-title">Sign in.</h2>
      </div>
      <div class="modal-body">
        <form method="post">
            
            <?php
            if(isset($error))
            {
                  ?>
                  <div class="alert alert-danger">
                      <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
                  </div>
                  <?php
            }
            ?>
            <div class="form-group">
             <input type="text" class="form-control" name="txt_uname_email" placeholder="Username or E mail ID" required />
            </div>
            <div class="form-group">
             <input type="password" class="form-control" name="txt_password" placeholder="Your Password" required />
            </div>
            <div class="clearfix"></div><hr />
            <div class="form-group">
             <button type="submit" name="btn-login" class="btn btn-block btn-primary">
                 <i class="glyphicon glyphicon-log-in"></i>&nbsp;SIGN IN
                </button>
            </div>
            <br />
            <label>Don't have account yet ! <a href="auth/sign-up.php">Sign Up</a></label>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
	</div>
	</div>
</div>
<nav class="navbar navbar">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">Logo</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
 <div class="dropdown">
  <button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Tutorials
  <span class="caret"></span></button>
  <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
    <li role="presentation"><a role="menuitem" href="#">HTML</a></li>
    <li role="presentation"><a role="menuitem" href="#">CSS</a></li>
    <li role="presentation"><a role="menuitem" href="#">JavaScript</a></li>
    <li role="presentation" class="divider"></li>
    <li role="presentation"><a role="menuitem" href="#">About Us</a></li>
  </ul>
</div>
    </div>
  </div>
</nav>

<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <img src="public/img/1.png">
        <div class="carousel-caption">
          <h3>Sell $</h3>
          <p>Money Money.</p>
        </div>      
      </div>

      <div class="item">
        <img src="public/img/2.png" alt="Image">
        <div class="carousel-caption">
          <h3>More Sell $</h3>
          <p>Lorem ipsum...</p>
        </div>      
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
</div>
  
<div class="container text-center">    
  <h3>Featured Items</h3><br>
  <div class="row">
<?php
// display the products if there are any

if($total_rows>0){
  ?>
 <div class="row text-center">

 <?php
 while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $prodImg = 'admin/products/uploads/'.$row['image'];
 ?>
  <div class="col-sm-4">
    <div class="thumbnail">

      <img src="<?php echo $prodImg; ?>" alt="Paris">
      <p><strong><?php echo $row['name'];?></strong></p>
      <p><?php echo $row['description'];?></p>
      <a href="<?php echo $row['id']; ?>"><button class="btn">View</button></a>
      <button class="btn">Buy</button>
      <button class="btn">Add to Cart</button>

    </div>
  </div>

 <?php }
   }
   else {

    echo "No Product found!";
  }
 ?>
   
</div>
  </div>
</div><br>

<footer class="container-fluid text-center">
  <p>Footer Text</p>
</footer>

</body>
</html>
