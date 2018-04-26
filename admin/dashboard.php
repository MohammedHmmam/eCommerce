<?php
session_start();


if(isset($_SESSION['username'])){
  include 'init.php';

    // Start dashboard here
    ?>
    <div class="container home-stats text-center">
        <h1>Dashboard</h1>
        <div class="row">
            <div class="col-md-3">
                <div class="stat st-members">
                  <i class="fa fa-users"></i>
                  <div class="info">
                    Total Members
                    <span><a href="members.php"><?php echo countItems('userID' , 'users'); ?></a></span>
                  </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-pending">
                  <i class="fa fa-user-plus"></i>
                  <div class="info">
                    Pending Members
                    <span><a href="members.php?do=Manage&page=Pending"><?php echo checkItem('regStatus' , 'users' , 0);?></a></span>
                  </div>

                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-items">
                  <i class="fa fa-tag"></i>
                  <div class="info">
                    Total Items
                    <span><a href="items.php"><?php echo countItems('item_ID' , 'items'); ?></a></span>
                  </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-comments">
                  <i class="fa fa-comments"></i>
                  <div class="info">
                    Total Comments
                    <span>130</span>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container latest">
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                      <?php
                        $latestUser = 5;
                        $latestItems = 5;

                      ?>
                        <i class="fa fa-users"></i> Latest registerd <?php echo $latestUser;?> Users
                        <span class="toggle-info pull-right">
                            <i class="fa fa-plus fa-lg"></i>
                        </span>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled latest-users">
                        <?php
                            foreach(getLatest('*' , 'users' , 'userID' ,$latestUser) as $user){
                              ?>
                                  <li>
                                      <?= $user['userName']; ?>
                                      <span class="btn btn-success pull-right">
                                          <a href="members.php?do=Edit&userID=<?=$user['userID'];?>">
                                            Edit <i class='fa fa-edit'></i>
                                          </a>
                                      </span>
                                      <?
                                        if($user['regStatus'] == 0){
                                          ?>
                                          <span class="btn btn-info pull-right">
                                              <a href="members.php?do=Activate&userID=<?=$user['userID'];?>">
                                                Active <i class='fa fa-check'></i>
                                              </a>
                                          </span>
                                          <?
                                        }
                                      ?>
                                  </li>
                              <?php

                            }
                        ?>
                      </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-tag"></i> Latest <?php echo $latestItems . " Items";?>
                        <span class="toggle-info pull-right">
                            <i class="fa fa-plus fa-lg"></i>
                        </span>
                    </div>
                    <div class="panel-body">

                      <ul class="list-unstyled latest-users">
                        <?php
                            foreach(getLatest('*' , 'items' , 'item_ID' ,$latestItems) as $item){
                              ?>
                                  <li>
                                      <?= $item['Name']; ?>
                                      <span class="btn btn-success pull-right">
                                          <a href="items.php?do=Edit&itemId=<?=$item['item_ID'];?>">
                                            Edit <i class='fa fa-edit'></i>
                                          </a>
                                      </span>
                                      <?
                                        if($item['Approve'] == 0){
                                          ?>
                                           <span class="btn btn-info pull-right">
                                              <a href="items.php?do=Approve&itemId=<?=$item['item_ID'];?>">
                                                Approve <i class='fa fa-check'></i>
                                              </a>
                                          </span>
                                          <?
                                        }
                                      ?>
                                  </li>
                              <?php

                            }
                        ?>
                    </ul>

                    </div>
                </div>

        </div>
    </div>
    <?php
    //End dashboard here
  include $tempDir.'footer.php';

}else{

  header("Location:index.php");
}



?>
