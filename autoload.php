<?php
function custom_autoloader($class) {
  $class = delNames($class);
  include $_SERVER['DOCUMENT_ROOT'].'/'.$class.'.php';
}
function delNames($class)
{
  $class_arr = explode("\\", $class);
  unset($class_arr[0]);
  $class = implode("/", $class_arr);
  return $class;
}
spl_autoload_register('custom_autoloader');



?>