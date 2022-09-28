<?php
define('HOST' ,'localhost' );
define('user' ,'root' );
define('pass' ,'' );
define('db' ,'php_backend' );

$connection = mysqli_connect(HOST , user ,pass , db )or die('unable connect')
?>