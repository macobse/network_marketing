<?php
// Testing Breadcrumb functionality 
// Date: 7/5/2017 12:48

session_start();
require '../../objects/user.php';
require '../../objects/network.php';


// core.php holds pagination variables
include_once '../../config/core.php';
 
// include database and object files
include_once '../../config/database.php';

 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
$network = new NETWORK($db);
$user = new USER($db);
if (!isset($_SESSION['user_session'])) {
	#redirect unauthorized user
	$user->redirect("../../index.php");
   
}


// Find user detail relationship



$recordID = 12;
include('../../views/templates/header.php' );
?>
<div class="breadcrumb"><?php echo $network->showBreadcrumb($recordID);?></div>
<?php
$currentUser = ( $recordID ) ? $network->rRep($recordID, false) : null; 
$validate = $network->checkRecord($recordID, false);

$cID = ($validate) ? $currentUser->child_id : null; 
//Get user network information
$uProfile = $user->getUserInfo($cID);

echo "DEBUG::USER - ". $uProfile->fname . "<br>";

$userTree =  $network->getChildren(12) ;


var_dump($userTree);

echo $network->showLevel(31);



 
// footer.php holds our javascript and closing html tags

?>


 <?php
 include('../../views/templates/footer.php' );
?>