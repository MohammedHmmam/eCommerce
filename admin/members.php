<?php

/*
  Mange Members page you can Edit || Add || Delete Members From here
*/

session_start();
$pageTitle ="Members";
if(isset($_SESSION['username'])){
  include 'init.php';

    // get Action in $do Variable if it isset
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    if($do == 'Manage'){
      $query= '';
      //check if the request comming from pending members url
      if(isset($_GET['page']) && $_GET['page'] === 'Pending'){
        $query = 'AND regStatus = 0';
      }
      // Get All users data
      $stmt = $con->prepare("SELECT * FROM users WHERE groupID !=1 $query");
      $stmt->execute();
      $rows = $stmt->fetchAll();
      ?>

         <h1 class="text-center">Wellcome in members manage page.</h1>

         <div class="container">
            <div class="table-responsive">

              <table class="main-table text-center table table-bordered">
                <tr>
                    <td>#ID</td>
                    <td>Username</td>
                    <td>Email</td>
                    <td>Full Name</td>
                    <td>Registerd Date</td>
                    <td>Control</td>
                </tr>
          <?php
            foreach($rows as $row){
              echo "<tr>";
                  echo "<td>". $row['userID'] ."</td>";
                  echo "<td>". $row['userName'] ."</td>";
                  echo "<td>". $row['email'] ."</td>";
                  echo "<td>". $row['fullName'] ."</td>";
                  echo "<td>". $row['registerDate']."</td>";
                  echo "<td> <a href='members.php?do=Edit&userID=".$row['userID']."'class='btn btn-success'>
                              <i class='fa fa-edit'></i>Edit</a>
                              <a href='members.php?do=Delete&userID=".$row['userID']."'class='btn btn-danger confirm'>
                              <i class='fa fa-close'></i>Delete</a>";
                              if($row['regStatus'] == 0){
                              echo "<a href='members.php?do=Activate&userID=".$row['userID']."'class='btn btn-info activate'>
                              <i class='fa fa-check'></i> Activate </a>";
                              }
                  echo "</td>";

              echo "</tr>";
            }
          ?>

              </table>

            </div>
            <a href='members.php?do=Add' class="btn btn-primary">
                <i class='fa fa-plus'></i>New Member</a>



         </div>





  <?php  }elseif($do == 'Edit'){// Edit Page

        $userId = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']) : 0 ;
        $stmt = $con->prepare("SELECT * FROM users WHERE userID= ? LIMIT 1");
        $stmt->execute(array($userId));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        if($count > 0){

            // Start edit user form
              ?>
            <h1 class="text-center">Edit Members</h1>
            <div class="container">

              <form class="form-horizontal" action = "?do=Update" method="POST">

                  <!-- user id !-->
                  <input type="hidden" name="userId" value="<?php echo $userId; ?>"/>
                  <!-- Start User name Control!-->
                  <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="username" value="<?php echo $row['userName']; ?>" class="form-control" autocomplete="off" required="required"/>
                    </div>
                  </div>
                  <!-- End User name Control!-->
                  <!-- Start Password Control!-->
                  <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10 col-md-6">
                      <input type="hidden" name="oldPassword" value="<?php echo $row['password']; ?>"/>
                        <input type="password" name="newPassword" class="form-control" autocomplete="off"/>
                    </div>
                  </div>
                  <!-- End Password Control!-->
                  <!-- Start Email Control!-->
                  <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="email" name="email" value="<?php echo $row['email']; ?>" class="form-control"required="required"/>
                    </div>
                  </div>
                  <!-- End Email Control!-->
                  <!-- Start Full name Control!-->
                  <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Fullname</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="fullname" value="<?php echo $row['fullName']; ?>" class="form-control" required="required"/>
                    </div>
                  </div>
                  <!-- End Full name Control!-->
                  <!-- Start Submit button Control!-->
                  <div class="form-group">
                    <div class="col-sm-offset-2  col-sm-10">
                        <input type="submit" Value="Save" class="btn btn-primary btn-lg"/>
                    </div>
                  </div>
                  <!-- End Submit button Control!-->
              </form>

            </div>

              <?php
            //End edit user form

        }else{
          $errorMsg =  "No Such as user ID";
          redirectHome('danger',$errorMsg);
        }



   }elseif($do == 'Update'){ // Update page
     echo "<h1 class='text-center'>Update Member</h1>";
     if($_SERVER['REQUEST_METHOD'] === 'POST'){

       $id    = $_POST['userId'];
       $user  = $_POST['username'];
       $email = $_POST['email'];
       $name  = $_POST['fullname'];

       $pass = empty($_POST['newPassword']) ? $_POST['oldPassword'] : sha1($_POST['newPassword']);

       $formErrors = array();

       if(empty($user)){
         $formErrors[] = "User name filed required";
       }
       if(empty($email)){
         $formErrors[] = "Email filed required</div>";
       }
       if(empty($name)){
         $formErrors[] = "Full name filed required</div>";
       }
       if(strlen($user) < 4){
         $formErrors[] = "User name can not be less than 4 Characters";
       }
       if(strlen($user) > 20){
         $formErrors[] = "User name can not be more than 4 Characters";
       }
       foreach($formErrors as $error){
         echo "<div class='alert alert-danger'>" . $error . "</div>";
       }
       if(empty($formErrors)){
         $stmt = $con->prepare("UPDATE users SET userName = ? , password = ? , email = ? , fullName = ? WHERE userID = ?");
         $stmt->execute([$user ,$pass, $email , $name , $id]);
         $count = $stmt->rowCount();
         if($count > 0 ){
           echo "<div class='alert alert-success'>". $count ."Rows has been updated</div>";
         }
       }


     }else{
      $errorMsg =  "You does not authorized to view this page";
      redirectHome($errorMsg);
     }

   }elseif($do == 'Add'){//Add New Member Form?>

     <h1 class="text-center">Add New Member</h1>
     <div class="container">

       <form class="form-horizontal" action = "?do=Insert" method="POST">

          <!-- Start User name Control!-->
           <div class="form-group form-group-lg">
             <label class="col-sm-2 control-label">Username</label>
             <div class="col-sm-10 col-md-6">
                 <input type="text" name="username" value="" class="form-control" autocomplete="off" required="required"/>
             </div>
           </div>
           <!-- End User name Control!-->
           <!-- Start Password Control!-->
           <div class="form-group form-group-lg">
             <label class="col-sm-2 control-label">Password</label>
             <div class="col-sm-10 col-md-6">

                 <input type="password" name="password" class="password form-control" autocomplete="off" required="required"/>
                 <i class="show-pass fa fa-eye fa-2x"></i>
             </div>
           </div>
           <!-- End Password Control!-->
           <!-- Start Email Control!-->
           <div class="form-group form-group-lg">
             <label class="col-sm-2 control-label">Email</label>
             <div class="col-sm-10 col-md-6">
                 <input type="email" name="email" value="" class="form-control"required="required"/>
             </div>
           </div>
           <!-- End Email Control!-->
           <!-- Start Full name Control!-->
           <div class="form-group form-group-lg">
             <label class="col-sm-2 control-label">Fullname</label>
             <div class="col-sm-10 col-md-6">
                 <input type="text" name="fullname" value="" class="form-control" required="required"/>
             </div>
           </div>
           <!-- End Full name Control!-->
           <!-- Start Submit button Control!-->
           <div class="form-group">
             <div class="col-sm-offset-2  col-sm-10">
                 <input type="submit" Value="Add member" class="btn btn-primary btn-lg"/>
             </div>
           </div>
           <!-- End Submit button Control!-->
       </form>

     </div>

  <?php }elseif($do == 'Insert'){
    //insert new member into database

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      echo "<h1 class='text-center'>New Member</h1>";
      //$id    = $_POST['userId'];
      $user  = $_POST['username'];
      $pass  = $_POST['password'];
      $email = $_POST['email'];
      $name  = $_POST['fullname'];

      $hashedPass = sha1($_POST['password']);

      $formErrors = array();

      if(empty($user)){
        $formErrors[] = "User name filed required";
      }
      if(empty($pass)){
        $formErrors[] = "Password name filed required";
      }
      if(empty($email)){
        $formErrors[] = "Email filed required</div>";
      }
      if(empty($name)){
        $formErrors[] = "Full name filed required</div>";
      }
      if(strlen($user) < 4){
        $formErrors[] = "User name can not be less than 4 Characters";
      }
      if(strlen($user) > 20){
        $formErrors[] = "User name can not be more than 4 Characters";
      }
      foreach($formErrors as $error){
        echo "<div class='alert alert-danger'>" . $error . "</div>";
      }
      if(empty($formErrors)){
          //Validation
            //Check if username exists
            if(checkItem('userName' , 'users' , $user) === 1){
              //if user exists redirect to
              redirectHome('Username already exists!' , 3 , 'members.php?do=Add');
            }elseif(checkItem('email' , 'users' , $email) === 1){//check if email was exists
              //if e-mail exists redirect to
              redirectHome('E-mail already exists!' , 3 , 'members.php?do=Add');
            }
          $stmt = $con->prepare("INSERT INTO users(userName , password , email , fullName,regStatus,registerDate) VALUES(:userName, :pass , :email , :fullName,1,now())");
          $stmt->execute(array(
              ':userName'  => $user ,
              ':pass'      => $hashedPass ,
              ':email'     => $email ,
              ':fullName'  => $name
          ));
          echo "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Inserted </div>";


      }


    }else{
      $errorMsg = "You does not authorized to view this page";
      redirectHome($errorMsg , 5);
    }

  }elseif($do == 'Delete'){

    $userId = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']) : 0 ;
    $stmt = $con->prepare("SELECT * FROM users WHERE userID= ? LIMIT 1");
    $stmt->execute(array($userId));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if($count > 0){
        $stmt = $con->prepare("DELETE FROM users WHERE userID = :userid");
        $stmt->bindParam(':userid' , $userId);
        $stmt->execute();
          echo "<div class='alert alert-success'>" . $stmt->rowCount() . " Record has Deleted </div>";

    }else{
      $errorMsg = "Id does not exists";
      redirectHome($errorMsg );
    }

  }elseif($do == 'Activate'){
    ?>
    <h1 class="text-center">Add New Member</h1>
    <div class="container">
      <?php
      //If action is Activate user
      $userId = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']) : 0 ;
      $stmt = $con->prepare("SELECT * FROM users WHERE userID= ? LIMIT 1");
      $stmt->execute(array($userId));
      $row = $stmt->fetch();
      $count = $stmt->rowCount();
      if($count > 0){
          $stmt = $con->prepare("UPDATE users SET regStatus = 1 WHERE userID = :userid");
          $stmt->bindParam(':userid' , $userId);
          $stmt->execute();

            $errorMsg = "User has been Activate";
            redirectHome('success' ,$errorMsg ,3,'members.php');
      }else{
        $errorMsg = "Id does not exists";
        redirectHome($errorMsg );
      }

  }

  include $tempDir.'footer.php';

}else{

  header("Location:index.php");
}



?>
