<?php
  include_once("../utils/Biblioteca/BD/conn.php");


if ($_SERVER['$REQUEST_METHOD'] == 'POST'){
  if(isset($_POST['nome_usuario']) AND $_POST['nome_usuario'] != " "){
  	$cadnome = $_POST['nome_usuario'];	
  }else{
  	$cadnome = null;
  	$erronome = 'Por favor, informe o seu nome';
  }

  if(isset($_POST['usuario_usuario']) AND $_POST['usuario_usuario'] != " "){
  	$cadusu = $_POST['usuario_usuario'];	
  }else{
  	$cadusu = null;
  	$errousu= 'Por favor, informe um usuario';
  }

  if(isset($_POST['senha_usuario']) AND $_POST['senha_usuario'] != " "){
  	$cadsenha = sha1($_POST['senha_usuario']);
  }else{
  	$cadsenha = null;
  	$errorsenha= 'Por favor, informe sua senha';
  }

  if(isset($_POST['email_usuario']) AND $_POST['email_usuario'] != " "){
  	$cademail = $_POST['email_usuario'];
  }else{
  	$cademail = null;
  	$erroemail= 'Por favor, informe um email';
  }

  $test = "SELECT * FROM usuarios WHERE usuario ='$cadusu'";	
  $resultado_usuario = mysqli_query($conn, $test);


  	if(!is_null($cadnome) AND !is_null($cadusu) AND !is_null($cadsenha) AND !is_null($cademail)){
		if ($resultado_usuario) {
		  	$row_usuario = mysqli_fetch_assoc($resultado_usuario);
			$user = $row_usuario['usuario'];
			
			if($user == $cadusu){
				echo "Não foi possivel cadastrar usuario!";
			
			}else{
				$sql = "INSERT INTO usuarios (nome, senha, email, usuario)
						VALUES ('$cadnome', '$cadsenha', '$cademail', '$cadusu')";

				if (mysqli_query($conn, $sql)) {
					echo "Cadastrado com sucesso!";
				} else {
					echo "Erro: " . $sql . "<br>" . mysqli_error($conn);	
				}
			}

		} else {
			$sql = "INSERT INTO usuarios (nome, senha, email, usuario)
			VALUES ('$cadnome', '$cadsenha', '$cademail', '$cadusu')";

			if (mysqli_query($conn, $sql)) {
			    echo "Cadastrado com sucesso!";
			} else {
			    echo "Erro: " . $sql . "<br>" . mysqli_error($conn);
			}
}
}else {
	echo "Há campos vazios ou invalidos, por favor preencha-os e tente novamente";
	}
}
	
mysqli_close($conn);

?>	