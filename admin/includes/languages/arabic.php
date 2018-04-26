<?php

function lang($phrase){
  static $lang = array(
      'MESSAGE' => 'أهلاً' ,
      'ADMIN'   =>  'المدير'
  );
  return $lang[$phrase];
}

?>
