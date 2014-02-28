<?php
error_reporting(E_ALL ^ E_NOTICE);
$host = 'localhost';
$user_host = 'root';
$pass = '';
$database = 'uploader';
$conn = mysqli_connect($host, $user_host, $pass, $database) or die('Could not connect to DB');
?>
<?php
/*error_reporting(E_ALL ^ E_NOTICE);
$host = 'localhost';
$user_host = 'upload';
$pass = '123456';
$database = 'upload_file';
$conn = mysqli_connect($host, $user_host, $pass, $database) or die('Could not connect to DB');
*/?>
