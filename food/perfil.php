<?php
session_start();
include_once("../utils/Biblioteca/BD/conn.php");

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
$cod = $_SESSION['cod'];
$nome = $_SESSION['nome'];
$email = $_SESSION['email'];
$imgperfil = $_SESSION['avatar'];



$resultado = "SELECT * FROM usuario WHERE codusuario ='$cod'";
$resultado = mysqli_query($conn, $resultado);
            //<div class="col-sm-4 alert alert-success alert-dismissible"> '.$statusalmoco.' </div>
			
if($resultado){
 $perfil = mysqli_fetch_assoc($resultado);
 
}



if (isset($_POST['mudarsenha'])){
    if($_POST['rnsenha'] == $_POST['nsenha']){
      $senhatest = sha1($_POST['senhaantiga']);

      if( $senhatest == $perfil['senha']){
           $cadnsenha = sha1($_POST['nsenha']);
        }else{
          $cadnsenha = null;
          $msg= 'Por favor, informe sua senha';
	
        }
			if(!is_null($cadnsenha)){
             $sql = "UPDATE usuario SET senha='".$cadnsenha."' WHERE codusuario =".$cod;
	
			}
              if (mysqli_query($conn, $sql)) {
                $msg = "Senha alterada com sucesso";
              } else {
				
				  //echo "Erro: " . $sql . "<br>" . mysqli_error($conn);  
              }
             }
        
	
  } else {
	 
  }




 if (isset($_POST['trocarfoto'])){
	if (!empty($_FILES['avatar']['name'])) {
			$avatar_path = $conn->real_escape_string('images/'.$_FILES['avatar']['name']);
		} else{
			//$avatar_path = 'images'.'/'.'user.png';
			$avatar_path = '';
		}


		if (!is_null($avatar_path)){

			if(preg_match("!image!", $_FILES['avatar']['type'])){
				
				if(copy($_FILES['avatar']['tmp_name'], $avatar_path)){

					$perfil['avatar']= $avatar_path;
					$_SESSION['avatar'] = $avatar_path;
					
				}
			}
		}
		else{
			//$avatar_path = 'images'.'/'.'user.png';
			$avatar_path = '';
		}
		
	
		$test = "UPDATE usuario SET avatar='".$perfil['avatar']."' WHERE codusuario =".$cod;
		$resultado_usuario = mysqli_query($conn, $test);	
	

}


if (isset($_POST['predefinido'])){
    $predefinido = $_POST['predefinido'];

      if(!is_null($predefinido)){
             $sql = "UPDATE usuario SET predefinido='".$predefinido."' WHERE codusuario =".$cod;
  
      } 
              if (mysqli_query($conn, $sql)) {
                $msgpredefinido = "Status Predefinido com sucesso";
              } else {
        
          //echo "Erro: " . $sql . "<br>" . mysqli_error($conn);  
              }
        }else {
   
  }



  if(isset($_POST['p1'])){
  $valorpredefinido = $_POST['p1'];
  if($valorpredefinido){
    $sqlupdate = "UPDATE usuario SET Predefinido='.$valorpredefinido.' WHERE  codusuario =$cod";
    if($resultupdate = $conn->query($sqlupdate)){
      $msgpredefinido = "Valor predefindido";
      }
    }
  }



//aquimesmo
if (isset($_POST['criapin'])){
    $pin = $_POST['pinarea'];

      if(!is_null($pin)){
             $sql = "UPDATE usuario SET pin =".$pin." WHERE codusuario =".$cod;
      } 
              if (mysqli_query($conn, $sql)) {
                $msgpin = "Pin modificado com sucesso";
              } else {
        
          //echo "Erro: " . $sql . "<br>" . mysqli_error($conn);  
              }
        }else {
   
  }
		
?>

<!DOCTYPE html>
<html>

<?php include("cabecalho.php");
include("sidebar.php");

?>
 <style>
 	
.image {
  opacity: 1;
  display: block;
  width: 100%;
  height: auto;
  transition: .5s ease;
  backface-visibility: hidden;
}

.middle {
  transition: .5s ease;
  opacity: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%)
}

.container:hover .image {
  opacity: 0.3;
}

.container:hover .middle {
  opacity: 1;
}

.text {
  background-color: white;
  color: black;
  font-size: 16px;
  padding: 16px 32px;
}
 	
        .card {
          margin-top: 20px;
          padding: 30px;
          background-color: rgba(214, 224, 226, 0.2);
          -webkit-border-top-left-radius:5px;
          -moz-border-top-left-radius:5px;
          border-top-left-radius:5px;
          -webkit-border-top-right-radius:5px;
          -moz-border-top-right-radius:5px;
          border-top-right-radius:5px;
          -webkit-box-sizing: border-box;
          -moz-box-sizing: border-box;
          box-sizing: border-box;
        }
        .card.hovercard {
          position: relative;
          padding-top: 0;
          overflow: hidden;
          text-align: center;
          background-color: #fff;
          background-color: rgba(255, 255, 255, 1);
        }
        .card.hovercard .card-background {
          height: 230px;
        }
        .card-background img {
          -webkit-filter: blur(15px);
          -moz-filter: blur(15px);
          -o-filter: blur(15px);
          -ms-filter: blur(15px);
          filter: blur(15px);
          margin-left: -100px;
          margin-top: -200px;
          min-width: 130%;
        }
        .card.hovercard .useravatar {
          position: absolute;
          top: 15px;
          left: 0;
          right: 0;
        }
        .card.hovercard .useravatar img {
          width: 200px;
          height: 200px;
          max-width: 200px;
          max-height: 200px;
          -webkit-border-radius: 10%;
          -moz-border-radius: 10%;
          border-radius: 10%;
          border: 5px solid rgba(255, 255, 255, 0.5);
        }
        .card.hovercard .card-info {
          position: absolute;
          bottom: 14px;
          left: 0;
          right: 0;
        }
        .card.hovercard .card-info .card-title {
          padding:0 5px;
          font-size: 20px;
          line-height: 1;
          color: #262626;
          background-color: rgba(255, 255, 255, 0.1);
          -webkit-border-radius: 4px;
          -moz-border-radius: 4px;
          border-radius: 4px;
        }
        .card.hovercard .card-info {
          overflow: hidden;
          font-size: 12px;
          line-height: 20px;
          color: #737373;
          text-overflow: ellipsis;
        }
        .card.hovercard .bottom {
          padding: 0 20px;
          margin-bottom: 17px;
        }
        .btn-pref .btn {
          -webkit-border-radius:0 !important;
        }


      </style>
	  
	  <style>
    .example-modal .modal {
      position: relative;
      top: auto;
      bottom: auto;
      right: auto;
      left: auto;
      display: block;
      z-index: 1;
    }

    .example-modal .modal {
      background: transparent !important;
    }
  </style>

<!-- Left side column. contains the logo and sidebar -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <!-- Content Header (Page header -->
  <section class="content-header">



    <h1>
      <i class="fa fa-user"></i> Perfil de Usuário
    <!--  <small><?php echo $nome ?></small> -->
    </h1>
    <!--<ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-user"></i>Perfil</a></li>
      <li class="active"><?php //echo $nome ?></li>
    </ol>-->
  </section>

  <!-- Main content -->
  <section class="content">

    <div class="row">
     
        <div class="col-md-12">

          <div class="box box-default" style="border-top:0px;">
            <!-- /.box-header -->
            <div class="box-body">
              <div class="col-md-12">
      <div class="card hovercard">
        <div class="card-background">
          <img class="card-bkimg" alt="" src="img/logo-penze-2017.png">
          <!-- http://lorempixel.com/850/280/people/9/ -->
        </div>
        <div class="container">
        <div class="useravatar">
        <img data-toggle="modal" data-target="#modal-default"  class="" src="<?= $perfil['avatar'] ?>">
		<div class="middle">
		<label data-toggle="modal" data-target="#modal-default" id="label" class="text">Trocar Foto</label>
		<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default" style="display:none;"></button>
        </div></div>
        </div>
        <div class="card-info"><span class="card-title"><?= $perfil['nome'] ?></span>

        </div>

      </div> 
	  
	 <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Trocar foto</h4>
              </div>
              <div class="modal-body">
			  <a for="imgInp" >
				
				<div class="col-md-12" >
				<form name="trocarfoto" id="trocarfoto" method="POST" action="" data-toggle="validator" role="form" enctype="multipart/form-data">
						<div class="avatar">
		
						<div class="box box-default" style="overflow: hidden;">
						<div class="image-holder" style="height:300px; width: 300px; min-height:100%;  min-width: 100%; object-fit: cover;">
						<img id="blah" src="images/user.png" style=" max-height:250px; max-width: 250px; "/>
						<input type="file" id="imgInp" name="avatar" accept="image/*"> <br>
						</div>
					</div></div>  
				</div>
				
			  </a>
			  </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-default pull-left" data-dismiss="modal" >Sair</button>
                <button type="submit" class="btn btn-primary" name="trocarfoto" value="trocarfoto">Salvar foto</button>
				</form>
              </div>
			 					
	
            </div>
          </div>
        </div>


		
		
		
		
    




</div></div></div></div>  <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">Atividade</a></li>
             <!-- <li><a href="#timeline" data-toggle="tab">Linha do tem</a></li> -->
              <li><a href="#settings" data-toggle="tab">Configurações</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                <!-- Post -->
                
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">
             
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="settings">
             
				       

          <div class="box box-default" style="border-top:0px;">
            <div class="box-header">
             <!-- <i class="fa fa-fw fa-user"></i> -->

              <h3 class="box-title">Deseja alterar sua senha?</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="col-md-12">
        <form name="mudarsenha" id="mudarsenha" method="POST" action="" data-toggle="validator" role="form" enctype="multipart/form-data">
              
        <!-- /.box-header -->
        <div class="box-body">
               <div class="form-group has-feedback col-md-12" style="padding-right:0px; padding-left:0px;">
                
                <input type="password" name="senhaantiga" placeholder="Senha antiga" class="form-control col-md-8" data-error="*Por favor, informe sua senha atual" required>
                <span class="glyphicon glyphicon-lock form-control-feedback col-md-12"></span>
                <div class="help-block with-errors col-md-12"></div>
              </div>

             <div class="form-group has-feedback col-md-12" style="padding-right:0px; padding-left:0px;">
                
                <input type="password" name="nsenha" placeholder="Nova Senha" class="form-control col-md-8" data-error="*Por favor, informe uma nova senha" required>
                <span class="glyphicon glyphicon-lock form-control-feedback col-md-12"></span>
                <div class="help-block with-errors col-md-12"></div>
              </div>

               <div class="form-group has-feedback col-md-12" style="padding-right:0px; padding-left:0px;">
                
                <input type="password" name="rnsenha" placeholder="Repita a nova senha" class="form-control col-md-8" data-error="*Por favor, repita a sua nova senha" required>
                <span class="glyphicon glyphicon-lock form-control-feedback col-md-12"></span>
                <div class="help-block with-errors col-md-12"></div>
              </div>
				<label><?php echo $msg ?></label>
                <button type="submit" value="mudarsenha" name="mudarsenha" class="btn btn-info pull-right">Alterar</button>
              <!-- /.box-footer -->
            
            </form>
          <!-- /.box -->
            </div>

          <div class="col-md-6">
            <div class="box-header">
             <!-- <i class="fa fa-fw fa-user"></i> -->

        <h3 class="box-title">Você sempre/nunca almoça na Penze?</h3>
        <p class="text-muted">Deixe seu status predefinido e economize tempo! :D</p>

            </div>
            
        <form name="predefinir" id="predefinir" method="POST" action="" data-toggle="validator" role="form" enctype="multipart/form-data">
              
        <!-- /.box-header -->
        <div class="box-body">
               <div class="form-group has-feedback col-md-12" style="padding-right:0px; padding-left:0px;">
                
                <input type="radio" name="p1" value="1" <?php if($perfil['Predefinido'] == 1){ echo "checked";} ?>> <label>Sempre almoço na Penze</label> <br>
                <input type="radio" name="p1" value="2" <?php if($perfil['Predefinido'] == 2){ echo "checked";} ?>> <label>Nunca almoço na Penze </label><br>
 <!--                <input type="radio" name="p1" value="0"> Limpar predefinido <br> -->
                <div class="help-block with-errors col-md-4"></div>
                  <label><?php echo $msgpredefinido ?></label>
                </div>
               <button type="submit" value="predefinir" name="predefinir" class="btn btn-info">Confirmar</button>
              </div>
              
              <!-- /.box-footer -->
            
            </form>
           </div> 

              <div class="col-md-6">
            <div class="box-header">
             <!-- <i class="fa fa-fw fa-user"></i> -->

        <h3 class="box-title"`>Área Pin</h3>
        <p class="text-muted">Aqui você pode criar ou alterar o seu pin de 4 a 6 números</p>
            </div>
            
        <form name="criapin" id="criapin" method="POST" action="" data-toggle="validator" role="form" enctype="multipart/form-data">
              
        <!-- /.box-header -->
        <div class="box-body">
             
                     <div class="form-group row">
                        <label for="Comentário" class="col-md-2 col-form-label">Pin</label>
                        <div class="col-md-8">
                          <input type="password" name="pinarea" maxlength="6" minlength="4" class="form-control" id="pinarea" placeholder="Insira o pin">
                        </div>
                      </div>
                       <button type="submit" value="criapin" name="criapin" class="btn btn-info">Confirmar</button>
          
              
              <!-- /.box-footer -->
            </div>
            </form>
           </div> 
        </div> 
                </div>
              </div>

			 
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col --></div>  </div> 
      
    <footer class="main-footer">
  <div class="pull-right hidden-xs">
    <b>Beta</b> 0.2.1
  </div>
  <strong>Direitos reservados © 2017 PenzeNetwork. Desenvolvido com muito  <i class="fa fa-heart" style="color: red;"></i>  em Assis por  <a style="color: violet;" href="http://www.Penze.com.br" target="_blank" rel="noopener"> Penze</a>.</strong> #Interior.
</footer>


<!-- /.content -->

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

</body></html>











