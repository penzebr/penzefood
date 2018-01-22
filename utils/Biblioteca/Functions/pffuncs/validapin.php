<?php
var_dump($_POST);
date_default_timezone_set('America/Sao_Paulo');


include_once("../../BD/conn.php");

	if(isset($_POST['codusu']) AND $_POST['codusu'] != " "){
			$codusu = $_POST['codusu'];
		   echo $_POST['codusu'];

		}else{
			echo "Erro";
			$codusu = null;
			$errocod = 'Erro!';
	 	}if(isset($_POST['codstatus']) AND $_POST['codstatus'] != " "){
	 		echo $_POST['codstatus'];
	 		$codstatus= $_POST['codstatus'];	
	 	}else{
	 		echo "erro2";
	 		$codstatus = null;
	 		$errocodstatus = 'Erro no codigo do status!';
	 	}

	 	if(isset($_POST['pin']) AND $_POST['pin'] != " "){
			$pin = $_POST['pin'];
			echo $_POST['pin'];
	 	}else{
	 		echo "erro3";
			$pin = null;
			$errorpin = 'Por favor, informe seu Pin';
		}

	 	if(isset($_POST['comentario'])){
			$comentario = $_POST['comentario'];
			echo $_POST['comentario'];
	 	}else{
	 		$comentario = null;
			echo $comentario;
	}

	 	$test = "SELECT * FROM usuario WHERE codusuario =$codusu";	
	 	//echo $test;
	 	//var_dump($conn);
	 	 $resultado = mysqli_query($conn, $test);

	 	 	if ($resultado) {

	 	 		$row = mysqli_fetch_assoc($resultado);
	 	 	
	 			$userpin = $row['pin'];

	 	 		if($userpin == $pin){
	 	 	//		echo "deu";		


	 	 			//estava tentando resolver a sql3, fazer o dataalmoco funcionar par q possa inserir os dados no banco
 

	 	 $dia = date('Y-m-d');
	 	 if ($codstatus == 3) {
	 	 	$sql3 = "UPDATE almoco SET statusalmoco = 1, comentario = '$comentario' WHERE codusuario = $codusu AND dataalmoco = '$dia'";

	 	 }
	 	 else{
	 	 	$sql3 = "UPDATE almoco SET statusalmoco = 0, comentario = '$comentario' WHERE codusuario = $codusu AND dataalmoco = '$dia'";
	 	 }	
	 			// echo $sql3;

	 				
				if (mysqli_query($conn, $sql3)) {
	 					// echo "Atualizado com sucesso!";
	 					$sql4 = "UPDATE status_almoco SET codstatus = $codstatus WHERE codusuario = $codusu";
	 					if (mysqli_query($conn, $sql4)) {
	 					//	echo "Atualizado com sucesso2!";
	 					}else{	
	 					}
	 				} else {
		 				// echo "deunao";	
	 			}
	 	 	}
	 	 	header('Location: ../../../../food/indexnovo.php');
	 	 }
	 

	





?>