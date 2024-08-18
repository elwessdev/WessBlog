<?php 
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();
// DataBase Connection credentials
$DB_SERVER=$_ENV["DB_SERVER"];
$DB_PORT=$_ENV["DB_PORT"];
$DB_NAME=$_ENV["DB_NAME"];
$DB_USERNAME=$_ENV["DB_USERNAME"];
$DB_PASSWORD=$_ENV["DB_PASSWORD"];
// Check connection
$db= "";
try{
  $db = mysqli_connect($DB_SERVER,$DB_USERNAME,$DB_PASSWORD,$DB_NAME,$DB_PORT);
} catch(mysqli_sql_exception){
  echo "DB could not connect";
}
if($db){
  // echo "you are connect";
}

?>