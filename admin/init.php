<?php
/*
    session_set_cookie_params ( int $lifetime [, string $path [, string $domain [,
    bool $secure = FALSE [, bool $httponly = FALSE ]]]] )

*/


  // get database connection
  include 'connect.php';
// includes paths
  $funcDir    = 'includes/function/'; //function directory
  $langsDir   = 'includes/languages/'; //languages directory
  $libDir     = 'includes/libraries/'; //libraries directory
  $tempDir    ='includes/templates/'; //templates directory
// layout paths
  $cssDir     = 'layout/css/'; // css directory
  $fontsDir   = 'layout/fonts/'; // fonts directory
  $imagesDir  = 'layout/images/' ;//images directory
  $jsDir      = 'layout/js/';

// Website parst
include $langsDir . 'english.php';
include $funcDir  . 'functions.php';
include $tempDir.'header.php';
// include navbar
if(!isset($noNavbar)){
  include $tempDir.'navbar.php';
}

?>
