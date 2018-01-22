  <?php
include_once("conn.php");

session_start();


  if(isset($_SESSION['Usuariologado'])){
   header("location: food/index.php");
   //echo "<body style='margin:0px'><iframe src='http://192.168.2.152/app' style='width:100%;height:100%;box-sizing: border-box;'> </iframe></body>";
   
 }
 else{
 	header("location: login.php");
 	//echo "<body style='margin:0px'><iframe src='http://192.168.2.152/app/login.php' style='width:100%;height:100%;box-sizing: border-box;'> </iframe></body>";
  }
  
?>