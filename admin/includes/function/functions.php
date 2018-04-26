<?php

//Function to print page title if exists
function getTitle(){
  global $pageTitle;
  if(isset($pageTitle)){
    echo $pageTitle;
  }else{
    echo "Default";
  }
}

//Function to print error message and redirect to home page
function redirectHome($type ,$errorMsg , $secondes = 3 , $to = 'index.php'){
  echo "<div class='alert alert-$type '>$errorMsg</div>";
  echo "<div class='alert alert-info'>You will be redirect to Homepage After". $secondes." secondes</div>";

  header("refresh: $secondes; url=$to");
  exit();
}

//Function to check if Item is exists or not
function checkItem($select , $from , $value){
  global $con ;
  $statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
  $statement->execute(array($value));
  $count = $statement->rowCount();
  return $count;
}

//Function to get Item count in database
function countItems($item , $table){
  global $con;
  $stmt = $con->prepare("SELECT COUNT($item) FROM $table");
  $stmt->execute();
  return $stmt->fetchColumn();

}

/*
    function getLatest() V1.0
    - to get latest items from database(Users , Items , Comments)
    $select = fields
    $table = table name
    $order = field to order result Ex:(userId)
    $limit = number of returned data
*/
function getLatest($select , $table , $order , $limit = 5 ){
  global $con;
  $stmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
  $stmt->execute();
  return $stmt->fetchAll();
}


?>
