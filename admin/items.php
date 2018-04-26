<?php
#ob_start();

// ITEMS PAge
session_start();
$pageTitle='Items';
if(isset($_SESSION['username'])){
  include 'init.php';
  $do=isset($_GET['do'])? $_GET['do']:'Manage';
  if($do=='Manage'){
        /****** Start Manage Page ******/
    /*=====================================*/


    /****** Start Manage Page ******/
    /*=====================================*/

    // Get All Items data
    $stmt = $con->prepare("SELECT items.* ,
                                  categories.Name AS Category_Name ,
                                  users.userName AS Member_Name
                           FROM items
                           INNER JOIN categories
                           ON categories.ID = items.Cat_ID
                           INNER JOIN users
                           ON users.userID = items.MemberID");
    $stmt->execute();
    $rows = $stmt->fetchAll();
    ?>

    <h1 class="text-center">Wellcome in Items manage page.</h1>

    <div class="container">
      <div class="table-responsive">

        <table class="main-table text-center table table-bordered">
          <tr>
              <td>#ID</td>
              <td>Name</td>
              <td>Description</td>
              <td>Price</td>
              <td>Adding Date</td>
              <td>Country</td>
              <!-- <td>Status</td> !-->
              <td>Category</td>
              <td>Member</td>
              <td>Control</td>
          </tr>
    <?php
      foreach($rows as $row){
        echo "<tr>";
            echo "<td>". $row['item_ID'] ."</td>";
            echo "<td>". $row['Name'] ."</td>";
            echo "<td>". $row['Description'] ."</td>";
            echo "<td>". $row['Price'] ."</td>";
            echo "<td>". $row['Add_Date']."</td>";
            echo "<td>". $row['Country_Made']."</td>";
            #echo "<td>". $row['Status']."</td>";
            echo "<td>". $row['Category_Name']."</td>";
            echo "<td>". $row['Member_Name']."</td>";

            echo "<td>
                        <a href='items.php?do=Edit&itemId=".$row['item_ID']."'class='btn btn-success'>
                          <i class='fa fa-edit'></i>Edit</a>
                        <a href='items.php?do=Delete&itemId=".$row['item_ID']."'class='btn btn-danger confirm'>
                          <i class='fa fa-close'></i>Delete</a>";
                        if($row['Approve']==0){
                          echo " <a href='?do=Approve&itemId=".$row['item_ID']."'
                                    class='btn btn-info active'>
                                    <i class='fa fa-check'></i>Approve
                                </a>";
                        }
            echo "</td>";

        echo "</tr>";
      }
    ?>

        </table>

      </div>
      <a href='items.php?do=Add' class="btn btn-xs btn-primary">
          <i class='fa fa-plus'></i>New Item</a>



    </div>

<?php


        /****** End Manage Page ******/
    /*=====================================*/
  }elseif($do=='Add'){
      /****** Start Add Page ******/
    /*=====================================*/
      // Start Add Item Form
      ?>

      <h1 class="text-center">Add New Item</h1>
      <div class="container">

        <form class="form-horizontal" action = "?do=Insert" method="POST">

           <!-- Start Item name Control!-->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text" name="itemName" value="" class="form-control" required="required"/>
                </div>
              </div>
            <!-- End Item name Control!-->
            <!-- Start Description Control!-->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Description</label>
                <div class="col-sm-10 col-md-6">

                    <input type="text" name="itemDescription"
                    class="form-control" autocomplete="off" required="required"/>

                </div>
              </div>
            <!-- End Description Control!-->
            <!-- Start Item Price Control!-->
               <div class="form-group form-group-lg">
                 <label class="col-sm-2 control-label">Price</label>
                 <div class="col-sm-10 col-md-6">
                     <input type="text" name="price" value=""
                     class="form-control" autocomplete="off" required="required"/>
                 </div>
               </div>
             <!-- End Item Price Control!-->

             <!-- Start Country Made Control!-->
                <div class="form-group form-group-lg">
                  <label class="col-sm-2 control-label">Country</label>
                  <div class="col-sm-10 col-md-6">
                      <input type="text" name="country" value=""
                      class="form-control"  required="required"/>
                  </div>
                </div>
              <!-- End Country Made Control!-->

              <!-- Start status Control!-->
                <div class="form-group form-group-lg">
                  <label class="col-sm-2 control-label">Status</label>
                  <div class="col-sm-10 col-md-6">
                    <select class="form-control" name = "status">
                      <option value="0">.......</option>
                      <option value="1">New</option>
                      <option value="2">Like New</option>
                      <option value="3">Used</option>
                    </select>
                  </div>
                </div>
              <!-- End status Control!-->

              <!-- Start Members Control!-->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Members</label>
                    <div class="col-sm-10 col-md-6">
                        <select class="form-control" name = "member">
                          <option value="0">.......</option>
                            <?php
                              $stmt = $con->prepare("SELECT * FROM users");
                              $stmt->execute();
                              $users = $stmt->fetchAll();
                              foreach($users as $user){
                                echo "<option value='".$user['userID']."'>".$user['userName']."</option>";
                              }
                            ?>
                        </select>
                    </div>
                </div>
              <!-- End Members Control!-->

              <!-- Start Categories Control!-->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Category</label>
                    <div class="col-sm-10 col-md-6">
                        <select class="form-control" name = "category">
                            <option value="0">.......</option>
                            <?php
                              $stmt = $con->prepare("SELECT * FROM categories");
                              $stmt->execute();
                              $cats = $stmt->fetchAll();
                              foreach($cats as $cat){
                                echo "<option value='".$cat['ID']."'>".$cat['Name']."</option>";
                              }
                            ?>
                        </select>
                    </div>
                </div>
              <!-- End Categories Control!-->

            <!-- Start Submit button Control!-->
            <div class="form-group">
              <div class="col-sm-offset-2  col-sm-10">
                  <input type="submit" Value="Add Item" class="btn btn-primary btn-xs"/>
              </div>
            </div>
            <!-- End Submit button Control!-->
        </form>

      </div>

      <?php
      // End Add Categories
      //End Add Item Form
      /****** End Add Page ******/
    /*=====================================*/
  }elseif($do=='Insert'){
    /****** Start INSERT Code ******/
/*=====================================*/

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  echo "<h1 class='text-center'>New Item</h1>";
  //$id    = $_POST['userId'];
  $itemName         = $_POST['itemName'];
  $itemDescription  = $_POST['itemDescription'];
  $itemPrice        = $_POST['price'];
  $country          = $_POST['country'];
  $status           = $_POST['status'];
  $cat              = $_POST['category'];
  $member           = $_POST['member'];


  $formErrors = array();

  if(empty($itemName)){
    $formErrors[] = "Item name filed <strong>required</strong>.";
  }
  if(empty($itemDescription)){
    $formErrors[] = "Item Description filed <strong>required</strong>.";
  }
  if(empty($itemPrice)){
    $formErrors[] = "Item Price filed <strong>required</strong>.";
  }
  if($status == 0){
    $formErrors[] = "You should Select <strong>Item Status</strong>.";
  }
  if($cat == 0){
    $formErrors[] = "You should Select <strong>The Category of this Items</strong>.";
  }
  if($member == 0){
    $formErrors[] = "You should Select <strong>Member</strong>.";
  }
  foreach($formErrors as $error){
    echo "<div class='alert alert-danger'>" . $error . "</div>";
  }
  if(empty($formErrors)){

      $stmt = $con->prepare("INSERT INTO items(Name , Description , Price , Add_Date, Country_Made, Status, Cat_ID,MemberID)
                              VALUES(:name, :description , :price , now(), :country, :status,:catId , :memberId)");
      $stmt->execute(array(
          ':name'        => $itemName,
          ':description' => $itemDescription,
          ':price'       => $itemPrice,
          ':country'     => $country,
          ':status'      => $status,
          ':catId'       => $cat,
          ':memberId'    => $member
      ));
      $successMsg= $stmt->rowCount() . " Record Inserted .";
      redirectHome('success' ,$successMsg , 3,'?do=Add' );

  }


}else{
  $errorMsg = "You does not authorized to view this page";
  redirectHome('danger' ,$errorMsg , 3 );
}


    /****** End INSERT Code ******/
/*=====================================*/

  }elseif($do=='Edit'){
    /****** Start Edit Page ******/
  /*=====================================*/

    $itemId = isset($_GET['itemId']) && is_numeric($_GET['itemId']) ? intval($_GET['itemId']) : 0 ;
    $stmt = $con->prepare("SELECT * FROM items WHERE item_ID= ? LIMIT 1");
    $stmt->execute(array($itemId));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if($count > 0){

        //Start Edit Form
          ?>
          <h1 class="text-center">Edit Item</h1>
          <div class="container">

            <form class="form-horizontal" action = "?do=Update" method="POST">

               <!-- Start Item name Control!-->
               <input type="hidden" name = "itemId" value="<?php echo $row['item_ID'] ?>"/>
                  <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="itemName"
                          value="<?php echo $row['Name'];?>"
                           class="form-control" required="required"/>
                    </div>
                  </div>
                <!-- End Item name Control!-->
                <!-- Start Description Control!-->
                  <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10 col-md-6">

                        <input type="text" name="itemDescription"
                          value="<?php echo $row['Description']; ?>"
                          class="form-control" autocomplete="off" required="required"/>

                    </div>
                  </div>
                <!-- End Description Control!-->
                <!-- Start Item Price Control!-->
                   <div class="form-group form-group-lg">
                     <label class="col-sm-2 control-label">Price</label>
                     <div class="col-sm-10 col-md-6">
                         <input type="text" name="price"
                          value="<?php echo $row['Price'];?>"
                          class="form-control" autocomplete="off" required="required"/>
                     </div>
                   </div>
                 <!-- End Item Price Control!-->

                 <!-- Start Country Made Control!-->
                    <div class="form-group form-group-lg">
                      <label class="col-sm-2 control-label">Country</label>
                      <div class="col-sm-10 col-md-6">
                          <input type="text" name="country"
                            value="<?php echo $row['Country_Made'];?>"
                            class="form-control"  required="required"/>
                      </div>
                    </div>
                  <!-- End Country Made Control!-->

                  <!-- Start status Control!-->
                    <div class="form-group form-group-lg">
                      <label class="col-sm-2 control-label">Status</label>
                      <div class="col-sm-10 col-md-6">
                        <select class="form-control" name = "status">
                          <option value="0" >.......</option>
                          <option value="1" <?php if($row['Status']==1){echo "Selected";} ?>  > New</option>
                          <option value="2" <?php if($row['Status']==2){echo "Selected";} ?>  > Like New</option>
                          <option value="3" <?php if($row['Status']==3){echo "Selected";} ?>  > Used</option>
                        </select>
                      </div>
                    </div>
                  <!-- End status Control!-->

                  <!-- Start Members Control!-->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Members</label>
                        <div class="col-sm-10 col-md-6">
                            <select class="form-control" name = "member">
                              <option value="0">.......</option>
                                <?php
                                  $stmt = $con->prepare("SELECT * FROM users");
                                  $stmt->execute();
                                  $users = $stmt->fetchAll();
                                  foreach($users as $user){
                                    echo "<option value='".$user['userID']."'";
                                     if($row['MemberID']  ==  $user['userID'])  {echo "Selected";}
                                     echo ">".$user['userName']."</option>";
                                  }
                                ?>
                            </select>
                        </div>
                    </div>
                  <!-- End Members Control!-->

                  <!-- Start Categories Control!-->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Category</label>
                        <div class="col-sm-10 col-md-6">
                            <select class="form-control" name = "category">
                                <option value="0">.......</option>
                                <?php
                                  $stmt = $con->prepare("SELECT * FROM categories");
                                  $stmt->execute();
                                  $cats = $stmt->fetchAll();
                                  foreach($cats as $cat){
                                    echo "<option value='".$cat['ID']. "'";
                                      if($row['Cat_ID'] == $cat['ID']){ echo "selected";}
                                    echo ">" . $cat['Name']."</option>";
                                  }
                                ?>
                            </select>
                        </div>
                    </div>
                  <!-- End Categories Control!-->

                <!-- Start Submit button Control!-->
                <div class="form-group">
                  <div class="col-sm-offset-2  col-sm-10">
                      <input type="submit" Value="Add Item" class="btn btn-primary btn-xs"/>
                  </div>
                </div>
                <!-- End Submit button Control!-->
            </form>

          </div>

          <?php

      //End Edit Form
    }else{
      $errorMsg =  "No Such as Item ID";
      redirectHome('danger',$errorMsg);
    }


    /****** End Edit Page ******/
  /*=====================================*/

  }elseif($do=='Update'){
    /****** Start UPDATE Code ******/
/*=====================================*/

echo "<h1 class='text-center'>Update Item</h1>";
if($_SERVER['REQUEST_METHOD'] === 'POST'){

  $id               = $_POST['itemId'];
  $itemName         = $_POST['itemName'];
  $itemDescription  = $_POST['itemDescription'];
  $itemPrice        = $_POST['price'];
  $country         = $_POST['country'];
  $status           = $_POST['status'];
  $member           = $_POST['member'];
  $category         = $_POST['category'];


  $formErrors = array();

  if(empty($itemName)){
    $formErrors[] = "Item name filed <strong>required</strong>.";
  }
  if(empty($itemDescription)){
    $formErrors[] = "Item Description filed <strong>required</strong>.";
  }
  if(empty($itemPrice)){
    $formErrors[] = "Item Price filed <strong>required</strong>.";
  }
  if($status == 0){
    $formErrors[] = "You should Select <strong>Item Status</strong>.";
  }
  if($category == 0){
    $formErrors[] = "You should Select <strong>The Category of this Items</strong>.";
  }
  if($member == 0){
    $formErrors[] = "You should Select <strong>Member</strong>.";
  }
  foreach($formErrors as $error){
    echo "<div class='alert alert-danger'>" . $error . "</div>";
  }

  if(empty($formErrors)){
    $stmt = $con->prepare("UPDATE items
                          SET
                            Name          = ? ,
                            Description   = ? ,
                            Price         = ? ,
                            Country_Made  = ? ,
                            Status        = ? ,
                            Cat_ID        = ? ,
                            MemberID     = ?
                          WHERE
                            item_ID = ?");
    $stmt->execute([
                    $itemName ,
                    $itemDescription,
                    $itemPrice ,
                    $country ,
                    $status,
                    $category,
                    $member,
                    $id
                  ]);
    $count = $stmt->rowCount();
    if($count > 0 ){
      echo "<div class='alert alert-success'>". $count ."Rows has been updated</div>";
    }
  }


}else{
 $errorMsg =  "You does not authorized to view this page";
 redirectHome($errorMsg);
}

    /****** End UPDATE Code ******/
/*=====================================*/
  }elseif($do=='Delete'){
    /****** Start DELETE Code ******/
/*=====================================*/

    $itemId = isset($_GET['itemId']) && is_numeric($_GET['itemId']) ? intval($_GET['itemId']) : 0 ;
    $stmt = $con->prepare("SELECT * FROM items WHERE item_ID= ? LIMIT 1");
    $stmt->execute(array($itemId));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if($count > 0){
        $stmt = $con->prepare("DELETE FROM items WHERE item_ID = :itemId");
        $stmt->bindParam(':itemId' , $itemId);
        $stmt->execute();
          echo "<div class='alert alert-success'>" . $stmt->rowCount() . " Record has Deleted </div>";

    }else{
      $errorMsg = "Id does not exists";
      redirectHome('danger' ,$errorMsg , 3 , 'items.php');

    }


    /****** End DELETE Code ******/
/*=====================================*/
  }elseif($do=='Approve'){
    /****** Start Approve Code ******/
/*=====================================*/

      ?>
      <h1 class="text-center">Approve Item</h1>
      <div class="container">
        <?php
        //If action is Activate user
        $itemId = isset($_GET['itemId']) && is_numeric($_GET['itemId']) ? intval($_GET['itemId']) : 0 ;
        $stmt = $con->prepare("SELECT * FROM items WHERE item_ID= ? LIMIT 1");
        $stmt->execute(array($itemId));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        if($count > 0){
            $stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE item_ID = :itemId");
            $stmt->bindParam(':itemId' , $itemId);
            $stmt->execute();

              $errorMsg = "Item has been Approved";
              redirectHome('success' ,$errorMsg ,3,'items.php');
        }else{
          $errorMsg = "Id does not exists";
          redirectHome($errorMsg );
        }


    /****** End Approve Code ******/
/*=====================================*/
  }
  include $tempDir.'footer.php';
}else{
  header('Location:index.php');
  exit();
}

#ob_end_flush();
?>
