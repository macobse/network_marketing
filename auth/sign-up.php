<?php
require_once '../config/database.php';
require_once '../objects/user.php';
$db = new Database();
$DB_con = $db->getConnection();
$user = new USER($DB_con);

if(isset($_POST['btn-signup']))
{
   $fname = trim($_POST['fname']);
   $mname = trim($_POST['mname']);
   $lname = trim($_POST['lname']);
   $email = trim($_POST['email']);
   $password = trim($_POST['password']);
   $phone_num = trim($_POST['phone_num']); 
   $address = trim($_POST['address']);
   $profile_pic = "pic.jpg";
 
   if($fname=="") {
      $error[] = "provide firstname !"; 
   }
   else if($email=="") {
      $error[] = "provide email id !"; 
   }
   else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error[] = 'Please enter a valid email address !';
   }
   else if($password=="") {
      $error[] = "provide password !";
   }
   else if(strlen($password) < 6){
      $error[] = "Password must be atleast 6 characters"; 
   }
   else
   {
      try
      {
         $stmt = $DB_con->prepare("SELECT email FROM users WHERE email=:umail");
         $stmt->execute(':umail',$email);
         $row=$stmt->fetch(PDO::FETCH_ASSOC);
    
         if($row['email']==$email) {
            $error[] = "sorry email id already taken!";
         }
         else
         {
            $user_type = "customer";
            if($user->register($fname,$mname,$lname,$email,$password,$phone_num,$address,$profile_pic,$user_type)) 
            {
                $user->redirect('sign-up.php?joined');
            }
            else{
              $error[] = "User data not inserted!";
            }
         }
     }
     catch(PDOException $e)
     {
        echo $e->getMessage();
     }
  } 
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sign up : Network Marketing</title>
<link rel="stylesheet" href="../libs/css/bootstrap/dist/css/bootstrap.min.css" type="text/css"  />
    <link href="../views/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container">
     <div class="form-container">
        <form method="POST">
            <h2>Sign up.</h2><hr />
            <?php
            if(isset($error))
            {
               foreach($error as $error)
               {
                  ?>
                  <div class="alert alert-danger">
                      <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
                  </div>
                  <?php
               }
            }
            else if(isset($_GET['joined']))
            {
                 ?>
                 <div class="alert alert-info">
                      <i class="glyphicon glyphicon-log-in"></i> &nbsp; Successfully registered <a href='index.php'>login</a> here
                 </div>
                 <?php
            }
            ?>
            <div class="form-group">
            <div class="form-group">
               <input type="text" class="form-control" name="fname" placeholder="First Name"" />
            </div>
            <div class="form-group">
               <input type="text" class="form-control" name="mname" placeholder="Middle Name"" />
            </div>
            <div class="form-group">
               <input type="text" class="form-control" name="lname" placeholder="Last Name"" />
            </div>

            <div class="form-group">
            <input type="text" class="form-control" name="email" placeholder="Enter E-Mail ID" value="<?php if(isset($error)){echo $email;}?>" />
            </div>

            <div class="form-group">
             <input type="password" class="form-control" name="password" placeholder="Enter Password" />
            </div>

            <div class="form-group">
                 <input type="text" class="form-control" name="phone_num" placeholder="Enter Phone Number" value="<?php if(isset($error)){echo $phone_num;}?>" />
            </div>
            <div class="form-group">
                <textarea name="address">
                  
                </textarea>
                 
            </div>
            <div class="form-group">
               <label>Upload image</label>
               <input type="file" name="profile_pic"" />
                 
            </div>
            <div class="clearfix"></div><hr />
            <div class="form-group">
             <button type="submit" class="btn btn-block btn-primary" name="btn-signup">
                 <i class="fa fa-check-circle fa-fw"></i>&nbsp;SIGN UP
                </button>
            </div>
            <br />
            <label>have an account ! <a href="login.php">Sign In</a></label>
        </form>
       </div>
</div>

</body>
</html>