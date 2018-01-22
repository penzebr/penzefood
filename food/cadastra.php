<?php
session_start();
include_once("../conn.php");
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


//$btncada = filter_input(INPUT_POST, 'Cadastrar', FILTER_SANITIZE_STRING);
$msg = null;

//if($btncada){
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	if($_POST['senha_usuario'] == $_POST['confsenha_usuario']){

		if (!empty($_FILES['avatar']['name'])) {

		
		$avatar_path = $conn->real_escape_string('images/'.$_FILES['avatar']['name']);
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

<?php include("cabecalho.php");
include("sidebar.php");
?>

	<!-- Left side column. contains the logo and sidebar -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="min-height:789.90px;">
  <!-- Content Header (Page header -->
  <section class="content-header">
    <h1>
      Inicio
      <small>PenzeFood</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">PenzeFood</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row" style="margin-bottom:1%;">


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
       </div>
        <!-- /.row -->
        <!-- /.row (main row) -->

      </section>
      <!-- /.content -->
    </div>

    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Beta</b> 0.1
      </div>
      <strong>Direitos reservados © 2017 PenzeNetwork. Desenvolvido com muito  <i class="fa fa-heart" style="color: red;"></i>  em Assis por  <a style="color: violet;" href="http://www.Penze.com.br" target="_blank" rel="noopener"> Penze</a>.</strong> #Interior.
    </footer>

    <!-- Control Sidebar -->

    <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->

</div>
<!-- ./wrapper -->
</form>
</section> </div>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="bower_components/raphael/raphael.min.js"></script>
<script src="bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="bower_components/moment/min/moment.min.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js">

</script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

</body>
</html>