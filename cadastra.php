<?php
include_once("conn.php");

session_start();
if(isset($_SESSION['Usuariologado'])){
	header("location: test/index.php");
}
//$btncada = filter_input(INPUT_POST, 'Cadastrar', FILTER_SANITIZE_STRING);
$msg = null;

//if($btncada){
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	if($_POST['senha_usuario'] == $_POST['confsenha_usuario']){

		if (!empty($_FILES['avatar']['name'])) {

		
		$avatar_path = $conn->real_escape_string('test/images/'.$_FILES['avatar']['name']);
		} else{
			//$avatar_path = 'images'.'/'.'user.png';
		$avatar_path = '';
		}


		if (!is_null($avatar_path)){

			if(preg_match("!image!", $_FILES['avatar']['type'])){
				
				if(copy($_FILES['avatar']['tmp_name'], $avatar_path)){

					$_SESSION['avatar'] = $avatar_path;
				}
			}
		}
		else{
			//$avatar_path = 'images'.'/'.'user.png';
		$avatar_path = '';
		}


		if(isset($_POST['nome_usuario']) AND $_POST['nome_usuario'] != " "){
			$cadnome = $conn->real_escape_string($_POST['nome_usuario']);	
		}else{
			$cadnome = null;
			$erronome = 'Por favor, informe o seu nome';
		}

		/*if(isset($_POST['usuario_usuario']) AND $_POST['usuario_usuario'] != " "){
			$cadusu = $conn->real_escape_string($_POST['usuario_usuario']);	
		}else{
			$cadusu = null;
			$errousu= 'Por favor, informe um usuario';
		}*/

		if(isset($_POST['senha_usuario']) AND $_POST['senha_usuario'] != " "){
			$cadsenha = sha1($_POST['senha_usuario']);
		}else{
			$cadsenha = null;
			$errorsenha= 'Por favor, informe sua senha';
		}

		if(isset($_POST['email_usuario']) AND $_POST['email_usuario'] != " "){
			$cademail = $conn->real_escape_string($_POST['email_usuario']);
		}else{
			$cademail = null;
			$erroemail= 'Por favor, informe um email';
		}

   	// mudar
	//	$test = "SELECT * FROM usuarios WHERE usuario ='$cadusu'";
		$test = "SELECT * FROM usuarios WHERE email ='$cademail'";	
		$resultado_usuario = mysqli_query($conn, $test);


		//if(!is_null($cadnome) AND !is_null($cadusu) AND !is_null($cadsenha) AND !is_null($cademail)){
		
		if(!is_null($cadnome) AND !is_null($cadsenha) AND !is_null($cademail)){
			if ($resultado_usuario) {

				$row_usuario = mysqli_fetch_assoc($resultado_usuario);
				$user = $row_usuario['email'];

				if($user == $cademail){
					$msg = "E-mail já cadastrado. Verfique!";

				}else{
				//	$sql = "INSERT INTO usuarios (nome, senha, email, usuario,avatar)
				//	VALUES ('$cadnome', '$cadsenha', '$cademail', '$cadusu','$avatar_path')";
				$sql = "INSERT INTO usuarios (nome, senha, email,avatar)
				VALUES ('$cadnome', '$cadsenha', '$cademail','$avatar_path')";

					if (mysqli_query($conn, $sql)) {
						$msg = "Cadastrado com sucesso!";
					} else {
						echo "Erro: " . $sql . "<br>" . mysqli_error($conn);	
					}
				}

			} else {
				$msg = "Há campos vazios!";

				if (mysqli_query($conn, $sql)) {
					$msg = "Cadastrado com sucesso!";
				} else {
					echo "Erro: " . $sql . "<br>" . mysqli_error($conn);
				}
			}
		}
	} else{
		$msg = "As senhas inseridas são diferentes";
	}

}
mysqli_close($conn);

?>	


<!DOCTYPE html>
<html>
<head>
	<title> Cadastro </title>
	<script
	src="https://code.jquery.com/jquery-3.2.1.js"
	integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
	crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.8.2/umd/popper.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</head>
<body>
	<h2> Cadastrar </h2>

	<form name="cadastro" id="cadastro" method="POST" action="" data-toggle="validator" role="form" enctype="multipart/form-data">
		<div class="form-group">
			<label>Nome</label>
			<input type="text" name="nome_usuario" placeholder="Digite o seu nome" data-error="*Por favor, informe um nome de usuario" required>
			<div class="help-block with-errors"></div>
		</div>
		<!--<div class="form-group">
			<label>Usuário</label>
			<input type="text" name="usuario_usuario" placeholder="Usuário para Login" data-error="*Por favor, informe um nome de usuario" required>
			<div class="help-block with-errors"></div>
		</div> -->
		<div class="form-group">
			<label>Senha</label>
			<input type="password" name="senha_usuario" placeholder="Digite sua senha" data-error="*Por favor, digite uma senha" required>
			<div class="help-block with-errors"></div>
		</div>
		<div class="form-group">
			<label>Confirmar Senha</label>
			<input type="password" name="confsenha_usuario" placeholder="Digite sua senha novamente" data-error="*As senhas dos campos estão diferentes" required>
			<div class="help-block with-errors"></div>
		</div>
		<div class="form-group">
			<label>Email</label>
			<input type="email" name="email_usuario" placeholder="Digite o seu Email" data-error="*Por favor, informe um email valido" required>
			<div class="help-block with-errors"></div>
		</div>
		<div class="avatar"><label>Selecione uma foto para o seu perfil: </label><input type="file" name="avatar" accept="image/*" </div><br>
		<input type="submit" name="Cadastrar" value="Cadastrar"><br>
		<label>Clique <a href="login.php">aqui </a> para voltar ao Login</label><br>
		<label><?php echo $msg ?></label>
	</form>

	<script src="js/validator.js"></script>
	<script src="js/validator.min.js"></script>
	<script> $('#cadastro').validator(); </script>
</body>
</html>