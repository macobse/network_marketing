<?php

class USER{
    // database connection
    private $db;
 
    function __construct($DB_con)
    {
      $this->db = $DB_con;
    }

    public function register($fname,$mname,$lname,$email,$password,$phone_num, $address, $profile_pic, $user_type)
    {
       try
       {
           $new_password = password_hash($password, PASSWORD_DEFAULT);
   
           $stmt = $this->db->prepare("INSERT INTO users(fname,mname,lname,email,password,phone_num,address,profile_pic,user_type) 
                                                       VALUES(:fname,:mname, :lname, :email, :upass, :phone_num, :address, :profile_pic, :user_type)");
              
           $stmt->bindparam(":fname", $fname);
           $stmt->bindparam(":mname", $mname);
           $stmt->bindparam(":lname", $lname);
           $stmt->bindparam(":email", $email);
           $stmt->bindparam(":upass", $new_password);
           $stmt->bindparam(":phone_num", $phone_num);
           $stmt->bindparam(":address", $address);
           $stmt->bindparam(":profile_pic", $profile_pic);
           $stmt->bindparam(":user_type", $user_type);            
           $stmt->execute(); 
   
           return $stmt; 
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }    
    }
 
    public function login($umail,$upass)
    {
       try
       {
          $stmt = $this->db->prepare("SELECT * FROM users WHERE email=:umail LIMIT 1");
          $stmt->execute(array(':umail'=>$umail));
          $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
          if($stmt->rowCount() > 0)
          {
             if(password_verify($upass, $userRow['password']))
             {
                $_SESSION['user_session'] = $userRow['id'];
                $_SESSION['user_name'] = $userRow['fname'];
                return true;
             }
             else
             {
                return false;
             }
          }
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }
   }
 
   public function is_loggedin()
   {
      if(isset($_SESSION['user_session']))
      {
         return true;
      }
   }
 
   public function redirect($url)
   {
       header("Location: $url");
   }
 
   public function logout()
   {
        session_destroy();
        unset($_SESSION['user_session']);
        return true;
   }
}
?>