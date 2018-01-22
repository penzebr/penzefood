<?php
session_start();
include_once("../utils/Biblioteca/BD/conn.php");
date_default_timezone_set('America/Sao_Paulo');



if($_SESSION['codpermissao'] == 1 ){
}else{
	header("location: index.php");
}


if(!isset($_SESSION['Usuariologado'])){
	session_destroy();
	header("location: ../login.php");
	die();
}
if(isset($_GET['deslogar'])){
	session_destroy();
	header("location: ../login.php");
}

$msg = null;
$adm = null;

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

					$usuarioregistrado= $avatar_path;
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
		
		if(isset($_POST['datanasc']) AND $_POST['datanasc'] != " "){
			$datanasc= $conn->real_escape_string($_POST['datanasc']);	
		}else{
			$datanasc = null;
			$errodatanasc = 'Por favor, informe uma data de nascimento';
		
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
		
		if(isset($_POST['adm_conf'])){
		  $registraradm = $_POST['adm_conf'];
		  if($registraradm == 1){
		    $adm = 1;
		  }
		}else{
		    $adm = 0;
		  
		}
	
		//$test = "SELECT * FROM usuarios WHERE usuario ='$cadusu'";
		$test = "SELECT * FROM usuario WHERE email ='$cademail'";	
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
					$sql = "INSERT INTO usuario (nome, senha, email ,avatar, codpermissao, datanasc)
					VALUES ('$cadnome', '$cadsenha', '$cademail','$avatar_path' ,'$adm', '$datanasc')";

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


?>
<!DOCTYPE html>
<html>

<?php include("cabecalho.php");
include("sidebar.php");
?>
<!-- Left side column. contains the logo and sidebar -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header -->
	<section class="content-header">



		<h1>
			Painel Administrativo
			<small>Cadastrar Usuários</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i>Painel Administrativo</a></li>
			<li class="active">Cadastrar Usuários</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

		<div class="row">
			<div class="col-md-4">
				<div class="box box-default">
					<div class="box-header with-border">
						<i class="fa fa-fw fa-image"></i>

						<h3 class="box-title">Selecione uma foto para o perfil:</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div class="col-md-12" >
						<div class="box box-default" style="overflow: hidden;">
						<div class="image-holder" style=" max-height:100%;  min-width: 100%">
							<img id="blah" src="#" style=" max-height:300px; max-width: 300px; object-fit: cover;"/>
						</div>
						


					</div></div>
						<form name="cadastro" id="cadastro" method="POST" action="" data-toggle="validator" role="form" enctype="multipart/form-data">
							<div class="avatar"><input type="file" id="imgInp" name="avatar" accept="image/*"> <br>

						
  
						</div>
						<!-- /.box-body -->
					</div>
					<!-- /.box -->
				</div>
				<!-- /.col -->
			</div>
				<div class="col-md-8">

					<div class="box box-default">
						<div class="box-header with-border">
							<i class="fa fa-fw fa-user-plus"></i>

							<h3 class="box-title">Dados Pessoais</h3>

						</div>
						<!-- /.box-header -->
						<div class="box-body">



								<div class="form-group has-feedback col-md-9" style="padding-right:0px; padding-left:0px;">
								
								<input type="text" name="nome_usuario" placeholder="Nome" class="form-control col-md-8" data-error="*Por favor, informe um nome de usuario" required>
								<span class="glyphicon glyphicon-user form-control-feedback col-md-5"></span>
								<div class="help-block with-errors col-md-6"></div>
							</div>
							
							<div class="form-group has-feedback col-md-3" style="padding-right:0px;">
								
								<input type="date" name="datanasc" placeholder="Data de Nasc" class="form-control col-md-8" id="datepicker" data-error="*Por favor, informe um nome de usuario" >
								<span class="glyphicon glyphicon-calendar form-control-feedback col-md-5"></span>
								<div class="help-block with-errors col-md-6"></div>
							</div>
							
							<div class="form-group has-feedback col-md-12" style="padding-right:0px; padding-left:0px;">
								
								<input type="password" name="senha_usuario" placeholder="Senha" class="form-control col-md-12" data-error="*Por favor, digite uma senha" required>
								<span class="glyphicon glyphicon-lock form-control-feedback col-md-10"></span>
								<div class="help-block with-errors col-md-12"></div>
							</div>
							<div class="form-group has-feedback col-md-12" style="padding-right:0px; padding-left:0px;">
								
								<input type="password" name="confsenha_usuario" placeholder="Repita a Senha" class="form-control" data-error="*As senhas não batem" required>
								<span class="glyphicon glyphicon-lock form-control-feedback col-md-12"></span>
								<div class="help-block with-errors col-md-12"></div>
							</div>
							<div class="form-group has-feedback col-md-12" style="padding-right:0px; padding-left:0px;">
						        <input type="email" name="email_usuario" class="form-control col-md-12" placeholder="Email" data-error="*Por favor, informe um email valido" required>
						        <span class="glyphicon glyphicon-envelope form-control-feedback col-md-12"></span>
						        <div class="help-block with-errors col-md-12"></div>
						      </div>		
						      <div class="form-group has-feedback col-md-12" style="padding-right:0px; padding-left:0px;">	
						      <input data-width="150" name="adm_conf" value=1 data-height="50" type="checkbox" class="icheckbox_minimal-blue"> Administrador
							</div>
						</div>
						</div>
						<label><?php echo $msg ?></label>
					<input type="submit" class="pull-right btn btn-primary" name="Cadastrar" value="Cadastrar"><br>
					
				   
				      
				     </form>
				</div>	
</div>
<h2 class="page-header"> Usuários Cadastrados </h2>
<div class="row">

  <?php
                    $sql = 'SELECT * from usuario';
                    $result = $conn->query($sql);
                    while($row = $result->fetch_assoc()){
                   
                    if($row['codpermissao'] == 1 ){
			  $cargo = "Administrador";
			}else{
			  $cargo = "Usuário";
			}
			
		 if(empty($row['avatar'])){ 
		          $avatar2 = 'images'.'/'.'user.png';
		        }else{ 
		          $avatar2 = $row['avatar'];} 
		
echo '<div class="col-md-3">

 <!-- Profile Image -->';
          if ($row['codpermissao'] == 1){ 
          echo '<div class="box box-primary">';
          } else{
          echo '<div class="box">';
          }
          
          echo
            '<div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="'.$avatar2.'" alt="User profile picture" style="width:88px; height:88px;border-radius:10%;" >

              <h3 class="profile-username text-center">'.$row["nome"].'</h3>

              <p class="text-muted text-center">'.$cargo.'</p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>E-mail</b> <a class="pull-right">'.$row["email"].'</a>
                </li>
              </ul>
 <!--<a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
</div>';} ?>
</div>




</div>
			
		<footer class="main-footer">
	<div class="pull-right hidden-xs">
		<b>Beta</b> 0.2.1
	</div>
	<strong>Direitos reservados © 2017 PenzeNetwork. Desenvolvido com muito  <i class="fa fa-heart" style="color: red;"></i>  em Assis por  <a style="color: violet;" href="http://www.Penze.com.br" target="_blank" rel="noopener"> Penze</a>.</strong> #Interior.
</footer>
</div>

<!-- /.content -->

  <!-- ./wrapper -->

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
   <!-- daterange picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
  <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>




	




<script src="js/validator.js"></script>
<script src="js/validator.min.js"></script>
<script> $('#cadastro').validator(); </script>



  <script> 

	$("#fileUpload").on('change', function () {

     //Get count of selected files
     var countFiles = $(this)[0].files.length;

     var imgPath = $(this)[0].value;
     var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
     var image_holder = $("#image-holder");
     image_holder.empty();

     if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
         if (typeof (FileReader) != "undefined") {

             //loop for each file selected for uploaded.
             for (var i = 0; i < countFiles; i++) {

                 var reader = new FileReader();
                 reader.onload = function (e) {
                     $("<img />", {
                         "src": e.target.result,
                             "class": "thumb-image"
                     }).appendTo(image_holder);
                 }

                 image_holder.show();
                 reader.readAsDataURL($(this)[0].files[i]);
             }

         } else {
             alert("Este navegador não suporta o FileReader.");
         }
     } else {
         alert("Por favor selecione apenas imagens");
     }
 });

</script>


<script>

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInp").change(function(){
        readURL(this);
    }); 

</script>
<script>

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd'
    })
</script>

<script>

var url = window.location;

// for sidebar menu entirely but not cover treeview
$('ul.sidebar-menu a').filter(function() {
	 return this.href == url;
}).parent().addClass('active');

// for treeview
$('ul.treeview-menu a').filter(function() {
	 return this.href == url;
}).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');
</script>

<?php
//include("rodape.php");
?>

</body>
</html>