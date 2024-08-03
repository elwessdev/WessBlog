<?php 
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();
// DataBase Connection credentials
$hostname=$_ENV["DB_HOST"];
$database=$_ENV["DB_DATABASE"];
$user=$_ENV["DB_USERNAME"];
$password=$_ENV["DB_PASSWORD"];
// $hostname="php-myadmin.net";
// $database="if0_37029225_devosama";
// $user="if0_37029225";
// $password="ZIbz3w39xW8sH7";
// Check connection
$db= "";
try{
  $db = mysqli_connect($hostname,$user,$password,$database);
} catch(mysqli_sql_exception){
  echo "DB could not connect";
}
if($db){
  // echo "you are connect";
}

?>