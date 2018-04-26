<?php

session_start();

//die();

session_unset();

session_destroy();

header("Location: index.php");
exit();

?>
