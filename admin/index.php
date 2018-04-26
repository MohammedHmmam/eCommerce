<?php

session_start();

$noNavbar = '';
$pageTitle = 'Login';
include 'init.php';

#var_dump(session_get_cookie_params());


if(isset($_SESSION['username'])){

  header("Location: dashboard.php");
}


// Check if user click button
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username   = $_POST['username'];
    $password   = $_POST['password'];
    $hashedPass = sha1($password);
    $stmt = $con->prepare("SELECT userID ,userName , password FROM users WHERE
                                                                          userName = ?
                                                                          AND
                                                                          password = ?
                                                                           AND
                                                                          groupID = 1
                                                                          LIMIT 1
                                                                           ");

    $stmt->execute(array($username,$hashedPass));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();

    if($count > 0 ){
      $_SESSION['username'] = $username;
      $_SESSION['userID'] = $row['userID'];

      header("Location:dashboard.php");
      exit();
    }
}

?>
  <!-- Start Form Here !-->
  <form class="login" action ="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
    <h4 class="text-center"> Admin Login</h4>
    <input class="form-control input-lg" type="text" name="username" placeholder="Username" autocomplete="off"/>
    <input class="form-control input-lg" type="password" name ="password" placeholder="Password" autocomplete="off"/>
    <input class="btn btn-primary btn-block" type="submit" name="submit"  value="Login" />

  </form>
  <!-- End Form Here !-->


<?php
  include $tempDir.'footer.php';
?>
