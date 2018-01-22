<?php
	$servidor = "localhost";
	$usuario = "root";
	$senha = "Penze@alpha";
	$dbname = "penzefood";
	$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
	
	if(!$conn){
		die("Falha na conex«ªo" . msqli_connect_error());
	}else{
	}
?>