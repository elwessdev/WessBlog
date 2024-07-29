<?php 
// DataBase Connection credentials
$hostname="localhost";
$user="root";
$password="";
$database="blog";
// Check connection
$db= "";
try{
  $db = mysqli_connect($hostname,$user,$password,$database);
} catch(mysqli_sql_exception){
  echo "could not connect";
}
if($db){
  // echo "you are connect";
}

?>