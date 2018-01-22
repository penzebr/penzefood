<?php 
date_default_timezone_set('America/Sao_Paulo');

if(!isset($_SESSION['Usuariologado'])){
  session_destroy();
  header("location: ../login.php");
  die();
}
if(isset($_GET['deslogar'])){
  session_destroy();
  header("location: ../login.php");
}
$permissao = $_SESSION['codpermissao'];
$cod = $_SESSION['cod'];


$sql = 'SELECT * from usuario';
$result = $conn->query($sql);

$usuario = $_SESSION['email'];
$result_busc = "SELECT * FROM status_usuario WHERE codusuario ='$cod'";
$resultado_busc = mysqli_query($conn, $result_busc);
$resultado_busc = utf8_encode_array($resultado_busc);
$statusalmoco = null; 


if($resultado_busc){
  $row_status = mysqli_fetch_assoc($resultado_busc); 
 

}
if($row_status['codstatus'] == 0){
  $statusalmoco = "Aguardando a confirmação...";
}
if($row_status['codstatus'] == 1){
  $statusalmoco = "Vai almoçar";
}
if($row_status['codstatus'] == 2){
  $statusalmoco = "Não almoçará";
}     
if($row_status['codstatus'] == 3){
  $statusalmoco = "Já almoçou";
}     

if($permissao == 1 ){
  $cargo = "Administrador";
}else{
  $cargo = "Usuário";
}

//botão reset p/ testes
/*
$_POST['reset'] = ''; 

$btnresetar = filter_input(INPUT_POST, 'btnresetar', FILTER_SANITIZE_STRING);
if($btnresetar){  
  $resetarstatus = $_POST['reset'];
    $sqlreset = "UPDATE status_almoco SET codstatus='0' WHERE  codusuario =$cod";
    if($resultreset = $conn->query($sqlreset)){
      $msgreset = "Reset realizado com sucesso";
  
}}

//endbotão 
*/
$btnregistrar = filter_input(INPUT_POST, 'btnregistrar', FILTER_SANITIZE_STRING);
if(isset($_POST['observacao'])){
  $observacao = $_POST['observacao'];
} else {
  $observacao = ' ';
}


$btnregistrar = filter_input(INPUT_POST, 'btnregistrar', FILTER_SANITIZE_STRING);

if($btnregistrar){  
  if(isset($_POST['r3'])){
  $registrarstatus = $_POST['r3'];
  if($registrarstatus == 1){
    $sqlupdate = "UPDATE status_almoco SET codstatus='1' WHERE  codusuario =$cod";
    if($resultupdate = $conn->query($sqlupdate)){
      $msgcabecalho = "Refeição confirmada!";
      $msgupdate = "Logo estará na mesa uma refeição quentinha e saborosa para você. Não deixe a comida esfriar. Bom rango!!";
    }

}else{
    $sqlupdate = "UPDATE status_almoco SET codstatus='2' WHERE  codusuario =$cod";
    if($resultupdate = $conn->query($sqlupdate)){
     $msgcabecalho = "Você não almoçará.";
      $msgupdate = "Status atualizado com sucesso";
    }

  }}
else if(isset($_POST['r4'])){
  $registrarstatus2 = $_POST['r4'];
  if($registrarstatus2 == 2){
    $sqlupdate = "UPDATE status_almoco SET codstatus='3' WHERE  codusuario =$cod";
    if($resultupdate = $conn->query($sqlupdate)){
      $msgcabecalho = "Obrigado por registrar o seu almoço.";
      $msgupdate = "É muito importante para que todos tenham uma refeição tranquila.
Não esqueça de avaliar.";
    }
  }} else {
    $sqlupdate = "UPDATE status_almoco SET codstatus='2' WHERE  codusuario =$cod";
    if($resultupdate = $conn->query($sqlupdate)){
    $msgcabecalho = "Você não almoçará.";
      $msgupdate = "Status atualizado com sucesso";
    }

  }
}
		?>