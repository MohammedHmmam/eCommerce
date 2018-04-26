<?php
#ob_start();

// Categories PAge
session_start();
$pageTitle='Categories';
if(isset($_SESSION['username'])){
  include 'init.php';
  $do=isset($_GET['do'])? $_GET['do']:'Manage';
  if($do=='Manage'){


  }elseif($do=='Add'){

  }elseif($do=='Insert'){


  }elseif($do=='Edit'){


  }elseif($do=='Update'){

  }elseif($do=='Delete'){

  }
  include $tempDir.'footer.php';
}else{
  header('Location:index.php');
  exit();
}

#ob_end_flush();
?>
