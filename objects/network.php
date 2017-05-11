<?php

/**
* 
*/
class NETWORK 
{
	// database connection
    private $db;
    private $count = 0;

    private $table_name = "network";
    public $breadcrumb = 'Home';


    function __construct($DB_con)
    {
      $this->db = $DB_con;
    }


	//create parent tree
    public function createParent($parentID,$childID,$leg){
        try
       {

       	$stmt = $this->db->prepare("INSERT INTO " . $this->table_name . "(parent_id,child_id,leg) 
                                                       VALUES(:pid, :cid, :cleg)");
        $stmt->bindparam(":pid", $parentID);
        $stmt->bindparam(":cid", $childID);
        $stmt->bindparam(":cleg", $leg);       	
        $stmt->execute(); 
   
        return $stmt; 
  	  }
  	  catch(PDOException $e)
       {
           echo $e->getMessage();
       }    
        
    }

    //Display all parents
    public function allParents($from_record_num, $records_per_page)
    {
    	# code...
    	try {
    		$stmt = $this->db->prepare("SELECT * FROM ".$this->table_name."
    			WHERE parent_id = 0             

            LIMIT
                {$from_record_num}, {$records_per_page}");
		 
		    $stmt->execute();
		 
		    return $stmt;

    		
    	} catch (Exception $e) {
    		
    	}

    }

    // parents count

    public function countParents()
    {
    	# code...
    	$stmt = $this->db->prepare("SELECT COUNT(*) FROM network");
    	$stmt->execute(); 
   
        $num_rows = $stmt->fetchColumn();
        return $num_rows;
    }



        //retrieve rep
    //by record ID or rep ID
    public function rRep($id,$isRecord=true){
        
        $idType = ( $isRecord ) ? 'child_id' : 'id';

        $stmt = $this->db->prepare("SELECT * FROM " . $this->table_name . " WHERE ".$idType."='" .$id."'" );

        if (!$stmt->execute()) {
                print_r($stmt->errorInfo());
            }
        
        $num_rows = $stmt->rowCount();
        if($stmt->execute() && $num_rows > 0){
            
            $f = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $query = "SELECT * FROM ".$this->table_name." WHERE parent_id = '".$f['id']."'";
            
            $stmt2= $this->db->prepare($query);
            
         if (!$stmt2->execute()) {
                print_r($stmt2->errorInfo());
            }
            for( $x=0;$x<=$num_rows;$x++ ){
                
                $f['reps'][$x] = $stmt2->fetch(PDO::FETCH_ASSOC);

                
            }
            
            $json = json_encode($f);
            
            return json_decode($json);
            
        }else{
            
            return null;
            
        }
        
    }
    //breadcrumb links
     public function showBreadcrumb($recordID=0){
        
        if( $recordID == 0 ){
            
            return $this->breadcrumb;
            
        }
        

        $query = "SELECT parent_id, child_id FROM " . $this->table_name . " WHERE id='".$recordID."'";
        
        $r = $this->db->prepare($query);
         $r->execute();

         if (!$r)
                {
                    $error = 'Error fetching page structure, for nav menu generation.';
                    exit();
            }
            $f = $r->fetch(PDO::FETCH_ASSOC);
           
            
            $parentID = $f['parent_id'];
            $childID = $f['child_id'];
            // Get the user `fname` from users using childID from network table
            $query2 = "SELECT * FROM users WHERE id='".$childID."'";
            $r2 = $this->db->prepare($query2);
            $r2->execute();
            if (!$r2)
                {
                    $error = 'Error fetching page structure, for nav menu generation.2';
                    exit();
            }
               $f2 = $r2->fetch(PDO::FETCH_ASSOC);
               $breadcrumb = $f2['fname'];
             
            
            while( $parentID != 0 ){
                
                $query = "SELECT * FROM " . $this->table_name . " WHERE id='".$parentID."'";
                
                $ra = $this->db->prepare($query);
                $ra->execute();
                if (!$ra)
                {
                    $error = 'Error parent id not found!';
                    exit();
            }
                  $fa = $ra->fetch(PDO::FETCH_ASSOC);
                  $faChildID = $fa['child_id'];
                  
                $query2 = "SELECT * FROM users WHERE id='".$faChildID."'";
                $r2 = $this->db->prepare($query2);
                $r2->execute();
                if (!$r2)
                {
                    $error = 'Error from inner parent!';
                    exit();
            }
                   $f2 = $r2->fetch(PDO::FETCH_ASSOC);
                   $name = $f2['fname'];
                
                $breadcrumb = '<a href="?id='.$fa['id'].'">'.$name.'</a>'.' - '.$breadcrumb;
                
                $parentID = $fa['parent_id'];
                    
                
            }
    
        $this->breadcrumb = '<a href="'.$_SERVER['PHP_SELF'].'">'.$this->breadcrumb.'</a> - '.$breadcrumb;
        
        return $this->breadcrumb;
        
    }
// Create network relationship user
    //create Rep
    public function cUser($childID,$parentID,$leg){
        
        $query = "INSERT INTO " . $this->table_name . " SET 
            child_id = '".$childID."',
            parent_id= '".$parentID."',
            leg = '".$leg."'
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        return $this->db->lastInsertId();
        
    }
       //safely quote passed values
    public function quoteSmart($value){
        
        if( !is_numeric($value) ){
            $value = $this->db->mysqli_real_escape_string($value);
        }
        return $value;
        
    }

    //Check whether the recordID exists or not

    public function checkRecord($id, $isRecord=true){
        $idType = ( $isRecord ) ? 'child_id' : 'id';
        $query = "SELECT * FROM " . $this->table_name . " WHERE ".$idType."='" .$id."'";
        $stmt = $this->db->prepare($query);

        $stmt->execute();
        if (!$stmt->execute()) {
                print_r($stmt->errorInfo());
            }
        
        $num_rows = $stmt->rowCount();
        if ($num_rows > 0) {
            return true;
            # code...
        }
        else{
            return false;
        }

    }

            //retrieve rep
    //by record ID or rep ID
    public function dispNetwork($id){
        
        $idType = 'id';
        
        $stmt = $this->db->prepare("SELECT * FROM " . $this->table_name . " WHERE ".$idType."='" .$id."'" );
        $r = $stmt->execute();
        if (!$r) {
                print_r($stmt->errorInfo());
            }
       
        // Display parent info
        $num_rows = $stmt->rowCount();
       
        
            # code...
        
        if($num_rows > 0){
             
            $f = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $query = "SELECT * FROM ".$this->table_name." WHERE parent_id = '".$f['id']."'";
            
            $stmt2= $this->db->prepare($query);
            $r2 = $stmt2->execute();
            $rows = $stmt2->rowCount();
            
         if (!$r2) {
                print_r($stmt2->errorInfo());
            }
            if ($rows != 0) {
                # code...
                echo "DEBUG::".$rows."<br>";
                for( $x=0;$x<$rows;$x++ ){

                $f['reps'][$x] = $stmt2->fetch(PDO::FETCH_ASSOC);
                var_dump($f);
                $legN = $f['reps'][$x]['id'];
                // echo "DEBUG::LEG".$legN;

               $this->dispNetwork($legN);
               
                
            }
            
            }

            $json = json_encode($f);
            
            return json_decode($json);
            
        
        }else{
            
            return null;
            
        }
        
    }


  public function display_children($parent, $level) {
    $stmt = $this->db->prepare("SELECT a.id, a.child_id, a.leg, Deriv1.Count FROM `network` a LEFT OUTER JOIN (SELECT parent_id, COUNT(*) AS Count FROM `network` GROUP BY parent_id ) Deriv1 ON a.id = Deriv1.parent_id WHERE a.parent_id =" . $parent);

    $stmt->execute();
    // echo "<ul>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($row['Count'] > 0) {

            $query2 = "SELECT * FROM users WHERE id='".$row['child_id']."'";
                $r2 = $this->db->prepare($query2);
                $r2->execute();
                if (!$r2)
                {
                    $error = 'Error from inner parent!';
                    exit();
                    }
                   $f2 = $r2->fetch(PDO::FETCH_ASSOC);
                   $name = $f2['fname'];
                   $i =1;

            // echo "<li><a href='" . $row['child_id'] . "'>" . $name . "</a>";
            // $this->display_children($row['id'], $level + 1);
            // echo "</li>";
                 echo  '<div class="hv-item-child"> <div class="hv-item">

                                <div class="hv-item-parent">
                                    <p class="simple-card">'  . $name;
                                    
                                     echo "</p> </div>";
                          echo  '<div class="hv-item-children">';

                                  echo ' <div class="hv-item-child">
                                        <p class="simple-card">' .$this->display_children($row['id'], $level + 1);
                               echo " </p>
                                    </div>

                                </div>";
                                $i++;

                echo "</div></div>";
                        

            // echo  "<div class='hv-item-child'>
            //                 <p class='simple-card'>" . $name;
            //                 $this->display_children($row['id'], $level + 1);
            //             echo "</p> </div>";
        } elseif ($row['Count']==0) {
            $query2 = "SELECT * FROM users WHERE id='".$row['child_id']."'";
                $r2 = $this->db->prepare($query2);
                $r2->execute();
                if (!$r2)
                {
                    $error = 'Error from inner parent!';
                    exit();
            }
                   $f2 = $r2->fetch(PDO::FETCH_ASSOC);
                   $name = $f2['fname'];
            echo  '<div class="hv-item-child">
                            <p class="simple-card">' . $name . ' </p>
                        </div>';
            // echo "<li><a href='" . $row['child_id'] . "'>" . $name . "</a></li>";
        } 
    }
    // echo "</ul>";
}

// Display the number of children in user network

     public function getOneLevel($recordID)
    {
        # code...
       $children=array();
        $query = "SELECT * FROM " . $this->table_name . " WHERE parent_id ='".$recordID."'";
        
        $r = $this->db->prepare($query);
         $r->execute();

         if (!$r)
                {
                    $error = 'Error_001::Wrong query!.';
                    exit();
            }
           
           
          if ($r->rowCount() > 0) {
            while ( $f = $r->fetch(PDO::FETCH_ASSOC)) {
               # code...
               $children[] = $f['id'];

              

           }
              # code...
          }
           
            
           return $children; 
    }


    function getChildren($parent_id) {
    $tree = Array();
    if (!empty($parent_id)) {
        $tree = $this->getOneLevel($parent_id);
        foreach ($tree as $key => $val) {
            $ids = $this->getChildren($val);
            $tree = array_merge($tree, $ids);
        }
    }
    return $tree;
 }

// Accept the children of a user as input
 // return the level of the user
 public function showLevel($n)
 {
    if ($n == 0) {
        # code...
        return 0;
    }
     # code...$x = 1;
     $i = 1;
     $j = 1;
     $n0 = 2;

      while ($i < $n) {

         
          if ($n0 >= $n) {
              return $j;
          }
          $i = $i *2;
          $n0 = $n0 + $i*2;
          $j++;

      }
      return $j;
 }

}