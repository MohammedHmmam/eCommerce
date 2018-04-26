<?php
#ob_start();

// Categories PAge
session_start();
$pageTitle='Categories';
if(isset($_SESSION['username'])){
  include 'init.php';
  $do=isset($_GET['do'])? $_GET['do']:'Manage';
  if($do=='Manage'){

      //Sort Results
      $sort_array = array("ASC","DESC");
      $sort = (isset($_GET['sort']) && in_array($_GET['sort'],$sort_array)) ? $_GET['sort'] : 'ASC';

      $stmt2 = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");
      $stmt2->execute();
      $cates = $stmt2->fetchAll();
    ?>
    <h1 class="text-center">Manage Categories</h1>
    <div class="container categories">
        <div class="panel panel-default">
          <div class="panel-heading">
            Manage Categories
            <div class="option pull-right">
              Order by :
              <a href="?sort=ASC" class="<?php if($sort=='ASC'){echo "active";}?>">ASC</a> |
              <a href="?sort=DESC" class="<?php if($sort=='DESC'){echo "active";}?>" >DESC</a>
              View :
              <span class="active" data-view="full">Full</span> |
              <span data-view="classic">Classic</span>
            </div>
          </div>
          <div class="panel-body">

              <?php

                foreach($cates as $cate){
              echo "<div class='cat'>";
                    //Category Control Buttons
                    echo "<div class='hidden-buttons'>";
                      echo "<a href='?do=Edit&cateId=".$cate['ID']."'class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>Edit</a>";
                      echo "<a href='?do=Delete&cateId=".$cate['ID']."' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i>Delete</a>";
                    echo "</div>";
                    echo "<h3>" . $cate['Name'] . "</h3>";
                    echo "<div class='full-view'>";
                      echo "<p>" ; if($cate['Description']==''){echo "Empty";}else{echo $cate['Description'];} "</p>";
                      if($cate['Visibility']==1){echo " <span class='visibility'><i class='fa fa-eye'></i>Hidden</span>";}
                      if($cate['Allow_comment']==1){echo " <span class='commenting'><i class='fa fa-close'></i>Comment Disabled</span>";}
                      if($cate['Allow_Ads']==1){echo " <span class='advertises'><i class='fa fa-close'></i>Ads Disabled</span>";}
                    echo "</div>";
              echo "</div>";
                  echo "<hr>";
                }

              ?>


          </div>

        </div>
        <a href="?do=Add" class="add-category btn btn-primary"><i class="fa fa-plus">Add new category</i></a>
    </div>
    <?php

  }elseif($do=='Add'){
    // Start Add Categories
    ?>

    <h1 class="text-center">Add New Category</h1>
    <div class="container">

      <form class="form-horizontal" action = "?do=Insert" method="POST">

         <!-- Start Category name Control!-->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="cateName" value="" class="form-control" autocomplete="off" required="required"/>
            </div>
          </div>
          <!-- End Category name Control!-->
          <!-- Start Description Control!-->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10 col-md-6">

                <input type="text" name="cateDescription" class="form-control" autocomplete="off" required="required"/>

            </div>
          </div>
          <!-- End Description Control!-->
          <!-- Start Category Order Control!-->
           <div class="form-group form-group-lg">
             <label class="col-sm-2 control-label">Ordering</label>
             <div class="col-sm-10 col-md-6">
                 <input type="text" name="cateOrder" value="" class="form-control" autocomplete="off" required="required"/>
             </div>
           </div>
           <!-- End Category Order Control!-->
          <!-- Start Visibility Control!-->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Visibility</label>
            <div class="col-sm-10 col-md-6">
                <div>
                    <input type="radio" id = "vis-yes" name="visibility" value="0" checked/>
                    <label for="vis-yes">Yes</label>
                </div>
                <div>
                    <input type="radio" id = "vis-no" name="visibility" value="1" />
                    <label for="vis-no">No</label>
                </div>
            </div>
          </div>
          <!-- End Visibility Control!-->
          <!-- Start Allow-commenting Control!-->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Allow-commenting</label>
            <div class="col-sm-10 col-md-6">
                <div>
                    <input type="radio" id = "com-yes" name="comment" value="0" checked/>
                    <label for="com-yes">Yes</label>
                </div>
                <div>
                    <input type="radio" id = "com-no" name="comment" value="1" />
                    <label for="com-no">No</label>
                </div>
            </div>
          </div>
          <!-- End Allow-commenting Control!-->
          <!-- Start Allow-Ads Control!-->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Allow-Ads</label>
            <div class="col-sm-10 col-md-6">
                <div>
                    <input type="radio" id = "ads-yes" name="ads" value="0" checked/>
                    <label for="ads-yes">Yes</label>
                </div>
                <div>
                    <input type="radio" id = "ads-no" name="ads" value="1" />
                    <label for="ads-no">No</label>
                </div>
            </div>
          </div>
          <!-- End Allow-Ads Control!-->
          <!-- Start Submit button Control!-->
          <div class="form-group">
            <div class="col-sm-offset-2  col-sm-10">
                <input type="submit" Value="Add Category" class="btn btn-primary btn-lg"/>
            </div>
          </div>
          <!-- End Submit button Control!-->
      </form>

    </div>

    <?php
    // End Add Categories
  }elseif($do=='Insert'){
    //Start Insert Category
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      echo "<h1 class='text-center'>New Category</h1>";
      //$id    = $_POST['userId'];
      $cateName         = $_POST['cateName'];
      $cateDescription  = $_POST['cateDescription'];
      $cateOrder        = $_POST['cateOrder'];
      $visibility       = $_POST['visibility'];
      $comment          = $_POST['comment'];
      $ads          = $_POST['ads'];


      $formErrors = "";

      if(empty($cateName)){
        $formErrors = "Category name filed required";
        echo "<div class='alert alert-danger'>".$formErrors."</div>";
      }



      if(empty($formErrors)){
          //Validation
            //Check if username exists
            if(checkItem('Name' , 'categories' , $cateName) === 1){
              //if user exists redirect to
              redirectHome('danger','Category Name already exists!' , 3 , 'categories.php?do=Add');
            }
          $stmt = $con->prepare("INSERT INTO categories(Name , Description , Ordering , visibility,Allow_comment,Allow_ads)
          VALUES(:cateName, :cateDesc , :order , :visibil,:comment,:ads)");
          $stmt->execute(array(
              ':cateName'   => $cateName ,
              ':cateDesc'   => $cateDescription ,
              ':order'      => $cateOrder ,
              ':visibil'    => $visibility,
              ':comment'    => $comment,
              ':ads'        =>  $ads
          ));
          echo "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Inserted </div>";


      }


    }else{
      $errorMsg = "You does not authorized to view this page";
      redirectHome($errorMsg , 5);
    }
    //End Insert Category

  }elseif($do=='Edit'){
    //Start Edit Form
    $cateId = isset($_GET['cateId']) && is_numeric($_GET['cateId']) ? intval($_GET['cateId']) : 0 ;
    $stmt = $con->prepare("SELECT * FROM categories WHERE ID= ? ");
    $stmt->execute(array($cateId));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if($count > 0){

        // Start edit user form
          ?>
        <h1 class="text-center">Edit Category</h1>
        <div class="container">

          <form class="form-horizontal" action = "?do=Update" method="POST">

              <!-- Category id !-->
              <input type="hidden" name="cateId" value="<?php echo $cateId; ?>"/>
              <!-- Start category name Control!-->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Category Name : </label>
                <div class="col-sm-10 col-md-6">
                    <input type="text" name="cateName" value="<?php echo $row['Name']; ?>" class="form-control" required="required"/>
                </div>
              </div>
              <!-- End Category name Control!-->
              <!-- Start Description Control!-->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Description : </label>
                <div class="col-sm-10 col-md-6">
                  <input type="text" name="description" class="form-control" value="<?php echo $row['Description']; ?>"/>
                </div>
              </div>
              <!-- End Category Description Control!-->
              <!-- Start Ordering Control!-->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Ordering</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text" name="ordering" value="<?php echo $row['Ordering']; ?>" class="form-control"required="required"/>
                </div>
              </div>
              <!-- End Ordering Control!-->
              <!-- Start Visibility Control!-->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Visibility</label>
                <div class="col-sm-10 col-md-6">
                    <div>
                        <input type="radio" id = "vis-yes" name="visibility" value="0" <?php if($row['Visibility']==0){echo 'checked';}?>/>
                        <label for="vis-yes">Yes</label>
                    </div>
                    <div>
                        <input type="radio" id = "vis-no" name="visibility" value="1"  <?php if($row['Visibility']==1){echo 'checked';}?>/>
                        <label for="vis-no">No</label>
                    </div>
                </div>
              </div>
              <!-- End Visibility Control!-->
              <!-- Start Allow-commenting Control!-->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Allow-commenting</label>
                <div class="col-sm-10 col-md-6">
                    <div>
                        <input type="radio" id = "com-yes" name="comment" value="0"  <?php if($row['Allow_comment']==0){echo 'checked';}?>/>
                        <label for="com-yes">Yes</label>
                    </div>
                    <div>
                        <input type="radio" id = "com-no" name="comment" value="1" <?php if($row['Allow_comment']==1){echo 'checked';}?>/>
                        <label for="com-no">No</label>
                    </div>
                </div>
              </div>
              <!-- End Allow-commenting Control!-->
              <!-- Start Allow-Ads Control!-->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Allow-Ads</label>
                <div class="col-sm-10 col-md-6">
                    <div>
                        <input type="radio" id = "ads-yes" name="ads" value="0" <?php if($row['Allow_Ads']==0){echo 'checked';}?>/>
                        <label for="ads-yes">Yes</label>
                    </div>
                    <div>
                        <input type="radio" id = "ads-no" name="ads" value="1" <?php if($row['Allow_Ads']==1){echo 'checked';}?>/>
                        <label for="ads-no">No</label>
                    </div>
                </div>
              </div>
              <!-- End Allow-Ads Control!-->
              <!-- Start Submit button Control!-->
              <div class="form-group">
                <div class="col-sm-offset-2  col-sm-10">
                    <input type="submit" Value="Update" class="btn btn-primary btn-lg"/>
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


    //End Edit Form

  }elseif($do=='Update'){
    //Start Update
    echo "<h1 class='text-center'>Update Categories</h1>";
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

      $cateId         = $_POST['cateId'];
      $cateName       = $_POST['cateName'];
      $cateDesc       = $_POST['description'];
      $ordering       = $_POST['ordering'];
      $visibility     = $_POST['visibility'];
      $allow_comment  = $_POST['comment'];
      $allow_ads      = $_POST['ads'];

      //Update category information
      $stmt = $con->prepare("UPDATE categories SET
                                                  Name=?,
                                                  Description = ?,
                                                  Ordering = ?,
                                                  Visibility=?,
                                                  Allow_comment=?,
                                                  Allow_Ads = ?
                                                  WHERE ID = ?");
      $stmt->execute(array($cateName,$cateDesc,$ordering,$visibility,$allow_comment,$allow_ads,$cateId));
      $successMsg = $stmt->rowCount()."Record Updated. ";
      redirectHome('success' ,$successMsg , 3 ,'categories.php');
    }else{
     $errorMsg =  "You does not authorized to view this page";
     redirectHome($errorMsg);
    }
    //End Update

  }elseif($do=='Delete'){
    //Start Delete Category
    $cateId = isset($_GET['cateId']) && is_numeric($_GET['cateId']) ? intval($_GET['cateId']) : 0 ;
    $stmt = $con->prepare("SELECT * FROM categories WHERE ID= ?");
    $stmt->execute(array($cateId));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if($count > 0){
        $stmt = $con->prepare("DELETE FROM categories WHERE ID = :cateId");
        $stmt->bindParam(':cateId' , $cateId);
        $stmt->execute();

        $successMsg = $stmt->rowCount() . " Record has Deleted";
        redirectHome('success' ,$successMsg ,3 ,'categories.php');


    }else{
      $errorMsg = "Id does not exists";
      redirectHome('danger',$errorMsg,2, 'categories.php');
    }

    //End Delete Category

  }
  include $tempDir.'footer.php';
}else{
  header('Location:index.php');
  exit();
}

#ob_end_flush();
?>
