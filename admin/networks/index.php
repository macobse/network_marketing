<?php
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



$recordID = empty($_GET['id']) ? null : $_GET['id'];

$currentUser = ( $recordID ) ? $network->rRep($recordID, false) : null; 
//Get child id

$validate = $network->checkRecord($recordID, false);

$cID = ($validate) ? $currentUser->child_id : null; 
//Get user network information
$uProfile = $user->getUserInfo($cID);

// specify the page where paging is used
$page_url = "index.php?";
$stmt = $network->allParents($from_record_num, $records_per_page);
// count total rows - used for pagination
$total_rows=$network->countParents();
$errorMsg = "";



// Check actions
if( !empty($_REQUEST['formPosted']) ){
    
    switch( $_REQUEST['action'] ){
    		case 'getUser':
	            if( !empty($_REQUEST['userID']) ){
	                $rID =  $_REQUEST['userID'];
	                // echo "Child ID::". $rID;

	                $currentUser = $network->rRep($_REQUEST['userID'],true);
	                //Just for testing purpose
	                // var_dump($currentUser);
	                //echo "<br>";

	                $validate = $network->checkRecord($rID);
	                // echo "VALIDATION::".$validate;
	                 $userID = (empty($validate)) ? 0 : $currentUser->child_id;
	                 // echo "";
	                 $recordID = ( empty($currentUser) || $userID == 0) ? 0 : $currentUser->id; // null to zero
	               // $uid = $user->getUserInfo($userID);
	                 $uProfile = $user->getUserInfo($userID);
	                 // var_dump($uProfile);
	                
	            }
	            else{
	            	$errorMsg = "<div class='alert alert-danger'>User ID not Found!</div>";

	            }
	            break;
            // add user as a parent
    	    case 'addParent':
	    	    if ($user->checkUser($_REQUEST['userID']) == true) {
	    	    	# inset new user relationship to network table
	    	    	$recordID = $network->cUser($_REQUEST['userID'], $_REQUEST['parentID'],$_REQUEST['leg']);
	                // echo $recordID;//1
	    	    	$currentUser = $network->rRep($_REQUEST['userID'],true);//Mesay 3
	    	    	// var_dump($currentUser);
	    	    	$userID = ( empty($currentUser) ) ? 0 : $currentUser->child_id; // userID=3
	               // $uid = $user->getUserInfo($userID);
	                 $uProfile = $user->getUserInfo($userID);
	    	    }
	            else{
	            	$errorMsg = "<div class='alert alert-danger'>User ID not Found!</div>";

	            }
	            
	            break;
	        case 'addUser':
	            $last_id = $network->cUser($_REQUEST['userID'],$_REQUEST['parentID'],$_REQUEST['leg']);
	            $currentUser = $network->rRep($_REQUEST['parentID'], false);
	            // var_dump($currentUser);
	            $recordID = $_REQUEST['parentID'];
	            $uProfile = $user->getUserInfo($currentUser->child_id);
	            break;

 	}
}

$page_title = "Network Admin";

include('../../views/templates/header.php' );
?>
<div class="breadcrumb"><?php echo $network->showBreadcrumb($recordID);?></div>
<?php
// read_template.php controls how the product list will be rendered
include_once "read_template.php";
 
// footer.php holds our javascript and closing html tags
include('../../views/templates/footer.php' );
?>