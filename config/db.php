<?php 
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();
// DataBase Connection credentials
$hostname=$_ENV["DB_HOST"];
$database=$_ENV["DB_DATABASE"];
$user=$_ENV["DB_USERNAME"];
$password=$_ENV["DB_PASSWORD"];
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