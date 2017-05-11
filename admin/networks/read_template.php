

        <div>
        <label>Search User:</label>
            <form method="POST">
                <div class="form-group">
                     User ID: <input type="text" name="userID">
                     
                    <input type="hidden" name="formPosted" value="1">
                    <input type="hidden" name="action" value="getUser">
                    <input class="btn btn-primary" type="submit" value="Go">
                </div>
            </form>
        </div>
 <?php


if (!empty($errorMsg)) {
     # code...
    echo $errorMsg;
 }
// Display a user with relationship info

if (!empty($currentUser)) {
     # Get user first name from users table using child id from network table
  
    
        # code...

?>
       
        <table width="100%" border="1" class="table table-hover table-responsive table-bordered">
            <tr>
                <td colspan="2" align="center" border = "1"><?php echo "<strong>". $uProfile->fname."</strong>";?></td>
            </tr>
            <tr>
                <td width="50%" align="center">
<?php

    if( !empty($currentUser->reps) ){
        
        if(!empty($currentUser->reps[0]->leg)  ){
            
            $leftLeg = ( empty($currentUser->reps[1]) ) ? null : $currentUser->reps[1];
            $rightLeg = $currentUser->reps[0];
            
        }else{
            
            $leftLeg = $currentUser->reps[0];
            $rightLeg = ( empty($currentUser->reps[1]) ) ? null : $currentUser->reps[1];
            
        }
        
    }
    if( empty($leftLeg) ){

?>                 
                    <div style="text-align: left;">
                        <form method="POST">
                           <!-- <pre>Name:       <input type="text" name="name" value=""></pre> <br> -->
                           <pre>User ID: <input type="text" name="userID" value=""></pre>
                            <input class="form-control" type="hidden" name="formPosted" value="1">
                            <input class="form-control" type="hidden" name="action" value="addUser">
                            <input class="form-control" type="hidden" name="parentID" value="<?php echo $currentUser->id;?>">
                            <input class="form-control" type="hidden" name="leg" value="0">
                            <input class="btn btn-primary" type="submit" value="Add">
                        </form>
                    </div>
<?php
    }else{

         $profile = $user->getUserInfo($leftLeg->child_id);
?>
                    [<a href="?id=<?php echo $leftLeg->id;?>"><?php echo $profile->fname;?></a>]
<?php
    }
?>
                </td>
                <td width="50%" align="center">
<?php
    if( empty($rightLeg) ){

?>
                    <div style="text-align: left;">
                        <form method="POST">
                        
                           <!-- <pre>Name:    <input type="text" name="name" value=""></pre> <br> -->
                           <pre>User ID: <input type="text" name="userID" value=""></pre>
                            <input type="hidden" name="formPosted" value="1">
                            <input type="hidden" name="action" value="addUser">
                            <input type="hidden" name="parentID" value="<?php echo $currentUser->id;?>">
                            <input type="hidden" name="leg" value="1">
                            <div class="form-group">
                                <input type="submit" value="Add" class="btn btn-primary" align="center">
                            </div>
                        </form>
                    </div>
<?php
    }else{
        $profile = $user->getUserInfo($rightLeg->child_id);
?>
                    [<a href="?id=<?php echo $rightLeg->id;?>"><?php echo $profile->fname;?></a>]
<?php
    }
?>
                </td>
            </tr>
</table>
 <?php 
 } 
// Display parent users with details
else{
if($total_rows>0 && empty($currentUser)){
 echo "<div class='right-button-margin'>";
    echo "<a href='create_product.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-plus'></span> Add Parent";
    echo "</a>";
echo "</div>";
    echo "<table class='table table-hover table-responsive table-bordered'>";
        echo "<tr>";
            echo "<th>Parents</th>";
            echo "<th>Number of Children</th>";
            echo "<th>Purchase</th>";
            echo "<th>Network Purchase<?phpe</th>";
            echo "<th>Level</th>";
            echo "<th>Actions</th>";
        echo "</tr>";
 
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
           
            $uProfile = $user->getUserInfo($child_id);
            $userTree =  $network->getChildren($row['id']) ;
            $numChildren = sizeof($userTree);

            echo "<tr>";
                echo "<td><a href='?id={$id}'>$uProfile->fname</a></td>";
                echo "<td>".$numChildren."</td>";
                echo "<td>0 ETB</td>";
                echo "<td>0 ETB</td>";
                echo "<td> ".$network->showLevel($numChildren);
                        
                echo "</td>";
 
                echo "<td>";
 
                    // read product button
                    echo "<a href='read_one.php?id={$id}' class='btn btn-primary left-margin'>";
                        echo "<span class='glyphicon glyphicon-list'></span> View";
                    echo "</a>";
 
                    // edit product button
                    // echo "<a href='update_product.php?id={$id}' class='btn btn-info left-margin'>";
                    //     echo "<span class='glyphicon glyphicon-edit'></span> Edit";
                    // echo "</a>";
 
                    // delete product button
                    echo "<a delete-id='{$id}' class='btn btn-danger delete-object'>";
                        echo "<span class='glyphicon glyphicon-remove'></span> Delete";
                    echo "</a>";
 
                echo "</td>";
 
            echo "</tr>";
 
        }
 
    echo "</table>";
 
    // paging buttons
  //  include_once 'paging.php';

    ?>
<h4>Add User as parent</h4>
        <form method="POST">
<!--            <div class="form-group">
               Name: &nbsp;&nbsp;  <input type="text" name="name" value="">
           </div> -->
            <div class="form-group">
               User ID: <input type="text" name="userID" value=""><br>
           </div>
            
            <input type="hidden" name="formPosted" value="1">
            <input type="hidden" name="action" value="addParent">
            <input type="hidden" name="parentID" value="0">
            <input type="hidden" name="leg" value="0">
            <input type="submit" value="Add" class="btn btn-primary">
        </form>

    <?php
}

// tell the user there are no products
else{
   
        # code...
        echo "<div class='alert alert-danger'>No parent found.</div>";

             ?>
<h4>Add User as parent</h4>
        <form method="POST">
<!--            <div class="form-group">
               Name: &nbsp;&nbsp;  <input type="text" name="name" value="">
           </div> -->
            <div class="form-group">
               User ID: <input type="text" name="userID" value=""><br>
           </div>
            
            <input type="hidden" name="formPosted" value="1">
            <input type="hidden" name="action" value="addParent">
            <input type="hidden" name="parentID" value="0">
            <input type="hidden" name="leg" value="0">
            <input type="submit" value="Add" class="btn btn-primary">
        </form>

    <?php
}
}
        ?>

