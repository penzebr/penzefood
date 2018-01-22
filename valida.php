<?php
session_start();
include_once("utils/Biblioteca/BD/conn.php");
include_once("utils/Biblioteca/BD/functionsdb.php");
$btnLogin = filter_input(INPUT_POST, 'btnLogin', FILTER_SANITIZE_STRING);

if($btnLogin){
	//$usuario = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
	$usuario = $_POST['email'];
	$senhacookie = $_POST['senha'];
	$senha = sha1(filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING)) ;

        //echo "$usuario - $senha";
	if(!empty($usuario) AND (!empty($senha))){
		
		//Criptografia
		//echo sha1($senha);
		//Pesquisar usuario no db
		
		$result_usuario = "SELECT * FROM usuario WHERE email ='$usuario'";
		$resultado_usuario = mysqli_query($conn, $result_usuario);
			if($resultado_usuario){
					$row_usuario = mysqli_fetch_assoc($resultado_usuario);
					$senhahash = $row_usuario['senha'];
					
				if($senha == $senhahash){
					if(isset($_POST['lembreme'])){
						$horas = time() +36000;
						setcookie("login", $usuario, $horas );
						setcookie("senha", $senhacookie, $horas );
					}else {}	

						$_SESSION['avatar'] = $row_usuario['avatar'];
						$_SESSION['codpermissao'] = $row_usuario['codpermissao'];
						$_SESSION['Usuariologado'] = true;
						$_SESSION['nome'] = $row_usuario['nome'];
						$_SESSION['cod'] = $row_usuario['codusuario'];
					//	$_SESSION['usuario'] = $row_usuario['usuario'];
						$_SESSION['email'] = $row_usuario['email'];
						header("location: food/index.php");

						
		  /*$diahas = date('Y-m-d');
		  $dia = date('Ymd');
		  $selectalmoco = "SELECT * FROM almoco WHERE codusuario = $row_usuario[codusuario] AND dataalmoco = ".$dia; 
          $resultado_almoco = mysqli_query($conn, $selectalmoco);
		  $row_almoco = mysqli_num_rows($resultado_almoco);

          if ($row_almoco == 0) {
          
		  $sqlinsertalmoco = "UPDATE status_almoco set codstatus = '0' where codusuario = $_SESSION[cod]"; 
          $res = mysqli_query($conn, $sqlinsertalmoco);
        
            if(mysqli_query($conn, $sqlinsertalmoco)){

          
			
				}
			  }else {
           	header("location: food/index.php");
           
          
           
          }*/			
      
				}else{
						$_SESSION['msg'] = "Login ou senha incorretos<br><br>";
						header("Location: login.php");
						}
			}else{
					$_SESSION['msg'] = "Não há registros com esse nome de Usuário<br><br>";
					header("Location: login.php");
			}
	}else{
	$_SESSION['msg'] = "Por favor, preencha corretamente o login e a senha<br><br>";
	header("Location: login.php");
	}

}else{
	$_SESSION['msg'] = "Página não encontrada<br><br>";
	header("Location: login.php");
}


?>