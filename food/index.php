<?php
session_start();
include_once("../utils/Biblioteca/BD/conn.php");
include_once("../utils/Biblioteca/BD/functionsdb.php");
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
if(isset($_POST['avaliacao'])){
  $avaliacao = $_POST['avaliacao'];
} else {
  $avaliacao = ' ';
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
  header("Location: index.php");
}      
?>
<!DOCTYPE html>
<html>

<?php include("cabecalho.php");
include("sidebar.php");
?>
<body id="index">
<!-- Left side column. contains the logo and sidebar -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header -->
  <section class="content-header">
    <h1>
      PenzeFood
      <small>Dashboard</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-fw fa-cutlery"></i>PenzeFood</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->




    <?php if(isset($msgupdate)){
     echo  
     "<!-- /.box-header -->
     
     <div class='alert alert-info alert-dismissible'>
     <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
     <h4><i class='icon fa fa-info'></i>  $msgcabecalho </h4>
     $msgupdate
     </div>
    ";
   }
   ?>


   <div class="row" style="margin-bottom:1%;">
    <div class="col-md-6">
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-fw fa-hand-peace-o"></i>

          <h3 class="box-title">Bem-vindo <?= $_SESSION['nome'] ?>!</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

          <!-- datetime() -->
          <h3 style="margin-top:10px;">Dados da alimentação<h3>
            <h4>Dia: <?php echo date('d/m/Y') ?></h4> 
            <h4>Descrição: Almoço Padrão </h4>
            <h4>Fornecedor: Bistecão</h4>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- ./col -->



      <?php 
    
        $usuario = $_SESSION['email'];
        $result_busc = "SELECT * FROM status_usuario WHERE codusuario ='$cod'";
        $resultado_busc = mysqli_query($conn, $result_busc);
            //<div class="col-sm-4 alert alert-success alert-dismissible"> '.$statusalmoco.' </div>
        if($resultado_busc){
         $row_status = mysqli_fetch_assoc($resultado_busc); 
      echo  
      '<div class="col-md-6">
        <!-- Horizontal Form -->
        <form class="form-horizontal" id="" name="atualizastatus" method="POST" action="">';
       if($row_status['codstatus'] == 3){ 
         echo '<div class="box box-success collapsed-box">';
       }else if($row_status['codstatus'] == 1){ 
        echo '<div class="box box-warning collapsed-box">';
       }else if($row_status['codstatus'] == 0){ 
         echo '<div class="box box-info collapsed-box">';
       }else if($row_status['codstatus'] == 2){ 
        echo '<div class="box box-danger collapsed-box">';
       } 
        		
        echo '<div class="box-header with-border">

        <h3 class="box-title">Status da refeição</h3> 
        </div>

        <div class="col-sm-4"> '; ?>  
         

 <?php     
          
        if($row_status['codstatus'] == 3){ 
         
          $statusalmoco = "Já almoçou";
           echo "</div><div class='col-1 alert alert-success alert-dismissible' style='border-bottom-width: 0px;margin-bottom: 0px; border-bottom-left-radius:0px;'> $statusalmoco </div>";
          $dia = date('Y-m-d');
          $horaconfirmacao = date('G:i:s');
          $selectalmoco = "SELECT * FROM almoco WHERE codusuario = '$cod' AND dataalmoco = '$dia'"; 
          $resultado_almoco = mysqli_query($conn, $selectalmoco);
		      //$resultado_almoco = utf8_encode_array($resultado_almoco);

          if ($resultado_almoco) {
          $row_almoco = mysqli_fetch_assoc($resultado_almoco);
          
          if ($row_almoco['dataalmoco'] == $dia ) {  

             $sqlinsertalmoco = "UPDATE almoco set statusalmoco = '1', comentarioava ='.$avaliacao.' where codusuario = '$cod' AND dataalmoco = '$dia'"; 
          
        
            if(mysqli_query($conn, $sqlinsertalmoco)){

            }
           }
           
           
          }

       }else if($row_status['codstatus'] == 1){ 
        $statusalmoco = "Vai almoçar";

        $dia = date('Y-m-d');
          $horaconfirmacao = date('G:i:s');
          $selectalmoco = "SELECT * FROM almoco WHERE codusuario = '$cod' AND dataalmoco = '$dia'"; 
          $resultado_almoco = mysqli_query($conn, $selectalmoco);


          if ($resultado_almoco) {
          $row_almoco = mysqli_fetch_assoc($resultado_almoco);
          
          if ($row_almoco['dataalmoco'] != $dia ) {
             $sqlinsertalmoco = "INSERT INTO almoco (codusuario, statusalmoco, dataalmoco , codcardapio, avaliacao, comentario, comentarioava, horaconfirmacao)
            VALUES ('$_SESSION[cod]', '0' , '$dia','','','$observacao','','$horaconfirmacao')";
        
            if(mysqli_query($conn, $sqlinsertalmoco)){

            }
           }
           
           
          }
         echo "</div><div class='col-1 alert alert-warning alert-dismissible'> $statusalmoco </div>";
       
       }else if($row_status['codstatus'] == 0){ 
         $statusalmoco = "Aguardando a confirmação...";
         echo "</div><div class='col-1 alert alert-info alert-dismissible'> $statusalmoco </div>";
       
       }else if($row_status['codstatus'] == 2){ 
        $statusalmoco = "Não almoçará";

        $dia = date('Y-m-d');
        $horaconfirmacao = date('G:i:s');

       
        $selectalmoco = "SELECT * FROM almoco WHERE codusuario = '$cod' AND dataalmoco = '$dia'"; 
          $resultado_almoco = mysqli_query($conn, $selectalmoco);


          if ($resultado_almoco) {
          $row_almoco = mysqli_fetch_assoc($resultado_almoco);
           
          if ($row_almoco['dataalmoco'] != $dia ) {
             $sqlinsertalmoco = "INSERT INTO almoco (codusuario, statusalmoco, dataalmoco , codcardapio, avaliacao, comentario, comentarioava, horaconfirmacao)
            VALUES ('$_SESSION[cod]', '0' , '$dia','','','$observacao','','$horaconfirmacao')";
        
            if(mysqli_query($conn, $sqlinsertalmoco)){

            }
           }
           
           
          }


         echo "</div><div class='col-1 alert alert-danger alert-dismissible'> $statusalmoco </div>";
       } 


    if($row_status['codstatus'] == 0){
      echo
      '<div class="btn-group btn-lg" data-toggle="buttons" >
      <label>
      <input data-toggle="toggle" data-width="150" name="r3" value=1 data-height="50" data-on="Vou almoçar" data-off="Não vou almoçar" type="checkbox" data-onstyle="warning" data-offstyle="danger" checked>
      </div>'; 
    }else if($row_status['codstatus'] == 1){
      echo
      '<div class="btn-group btn-lg" data-toggle="buttons" >
      <label>
      <input data-toggle="toggle" data-width="150" name="r4" value=2 data-height="50" data-on="Já almoçei" data-off="Não vou almoçar" type="checkbox" data-onstyle="success" data-offstyle="danger" checked>
      </div>'; 
    }else if($row_status['codstatus'] == 2){
     
        echo '
       <div class="denied-box">
            <span class="info-box-icon bg-red"><i class="fa fa-fw fa-times"></i></span>

            <div class="info-box-content">
             <span class="info-box-number">Tudo bem</span>
              <span class="info-box"> Tenha um bom almoço fora da Penze! </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          </div>';

    }else if($row_status['codstatus'] == 3){
         echo
      ' 
      <div class="info-box">
            <span class="info-box-icon bg-green" style="border-top-left-radius:0px"><i class="fa fa-fw fa-thumbs-up"></i></span>

            <div class="info-box-content">
              <span class="info-box-number">Obrigado</span>
              <span class="info-box" style="margin-bottom:0px;border-bottom-color: white;"> Esperamos que tenha tido um bom almoço! </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          </div>'; 

}
   if($row_status['codstatus'] == 0 || $row_status['codstatus'] == 1){
    echo 

    '<div class="box-default collapsed-box">         
      <div class="box-header">
        <button type="button" class="box-title btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip">';
         
        if($row_status['codstatus'] == 0 ){
    echo 

    	'Deixe sua Observação';
    	} else {
    	echo 'Deixe sua Avaliação';
    	}
    	}
         if($row_status['codstatus'] == 0){
    	echo '</button>                   
        <!-- tools box -->
              <!--<div class="pull-right box-tools">
                <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip"
                        title="Esconder">
                  <i class="fa fa-minus"></i></button>
                </div>-->
                <div class="box box-default collapsed-box">
                  <div class="box box-body pad">

                    <textarea class="" name="observacao" placeholder="Sua Observação ou Sugestão sobre o almoço"
                    style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>

                  </div>
                </div>
       
           

            <!-- /.box-body -->
            <div class="footer">';}
           elseif ($row_status['codstatus'] == 1){
            echo '</button>                   
             <!-- tools box -->
              <!--<div class="pull-right box-tools">
                <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip"
                        title="Esconder">
                  <i class="fa fa-minus"></i></button>
                </div>-->
                <div class="box box-default collapsed-box">
                  <div class="box box-body pad">

                    <textarea class="" name="avaliacao" placeholder="Sua Avaliação sobre o almoço"
                    style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>

                  </div>
                </div>
       
           

            <!-- /.box-body -->
            <div class="footer">';}
             if($row_status['codstatus'] == 0 || $row_status['codstatus'] == 1){ 
             echo '<button type="submit" name="btnregistrar" value="acessar"'; if($row_status['codstatus'] == 1){ //echo ' data-toggle="modal" data-target="#modal-default" ';
           } echo 'class="btn btn-info pull-right">Registrar</button>';
              }
              
             echo '<!-- <form class="form-horizontal" name="reset" method="POST" action="">
       <button type="submit" name="btnresetar" value="reset" class="btn btn-info pull-right">Resetar</button>
       </form>  -->
            </div>
             
           
          </form>
        
     ';}?>  
             <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true"> Obrigado por registrar o seu almoço. </span></button>
                <h4 class="modal-title">Default Modal</h4>
              </div>
              <div class="modal-body">
                <p> É muito importante para que todos tenham uma refeição tranquila. Não esqueça de avaliar. </p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div>

    <?php if($row_status['codstatus'] == 0 || $row_status['codstatus'] == 1){ 
    echo '</div></div>
   </div></div>';
   } ?>
   <?php 
                $sql = 'SELECT * from status_usuario';
                $result = $conn->query($sql);
                $resultado_busc = mysqli_query($conn, $sql);
                //<div class="col-sm-4 alert alert-success alert-dismissible"> '.$statusalmoco.' </div>
                if($resultado_busc){
                  $row2 = mysqli_fetch_assoc($resultado_busc);


                  if($row2){
                    $almocou = 0;
                    $vaoalmocar = 0;
                    $naovaoalmocar = 0;
                    $aguardando = 0;
                    while($row2 = $result->fetch_assoc()){
                      if($row2['codstatus'] == 3){
                        $almocou++;
                      } if($row2['codstatus'] == 1){
                        $vaoalmocar++;
                      } if($row2['codstatus'] == 0){
                        $aguardando++;
                      } if($row2['codstatus'] == 2){
                        $naovaoalmocar++;
                      }

                    }
                    ?>

      <div class="row">
      
     
      
        <div class="col-md-12">
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><?php 
                  echo $aguardando;    
                  echo '</h3>';  
?> 

                  <p>Aguardando...</p>
                </div>
                <div class="icon">
                  <i class="fa fa-fw fa-ellipsis-h"></i>
                </div>
              </div>
            </div>
  
        
        
         
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3><?php 
                  echo $vaoalmocar;    
                  echo '</h3>';

                  if($vaoalmocar > 1){  
                  echo '<p>Vão almoçar</p> ';
                  }else{
                  echo '<p>Vai almoçar</p> ';
                    }?>
                </div>
                <div class="icon">
                  <i class="fa fa-fw fa-history"></i>
                </div>
              </div>
            </div>
            
            <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
              <div class="inner">
                <h3><?php
                    echo $almocou;
                     echo '</h3>';}}   

                  if($almocou > 1){  
                  echo '<p>Já almoçaram</p> ';
                  }else{
                  echo '<p>Almoçou</p> ';
                    }?> 
      
                </div>
                <div class="icon">
                  <i class="fa fa-fw fa-thumbs-up"></i>
                </div>
              </div>
            </div>           
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><?php 
                  echo $naovaoalmocar;
                  echo '</h3>';   

                  if($naovaoalmocar > 1){  
                  echo '<p>Não almoçarão</p> ';
                  }else{
                  echo '<p>Não almoçará</p> ';
                    }?>     
            
                </div>
                <div class="icon">
                  <i class="fa fa-fw fa-times"></i>
                </div>
          
              </div>
            </div>
          </div>   </div>
  
          </div>
      </h3>
  </h3>


          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Tabela de Almoço</h3>
                </div>

                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th>Usuário</th>
      
                      <th>Status</th>
                      <th>Observação</th>
                    <!--  <th>Classificação</th> -->
                    </tr>
                    
					
					<?php
                    			
					
                    $sql = 'SELECT * from status_usuario';
                    $result = $conn->query($sql);
                    while($row = $result->fetch_assoc()){
                      
				
					// $structure is now utf8 encoded
					//print_r($structure);
					  
                      echo "<tr>
                      <td> $row[nome] </td>";                      
                      if($row['codstatus'] == 3){ 
                       echo "<td><span class='label label-success'> Almoçou </span></td>";
                     }else if($row['codstatus'] == 1){
                       echo "<td><span class='label label-warning'> Vai Almoçar </span></td>";
                     }else if($row['codstatus'] == 2){
                      echo "<td><span class='label label-danger'> Não Almoçará </span></td>"; 
                    }else{
                      echo "<td><span class='label label-info'> Aguardando... </span></td>";
                    }
                  
                  $dia = date('Ymd');
                  $sqlalmoco = 'SELECT * from almoco where codusuario ='.$row["codusuario"].' AND dataalmoco = '.$dia;
                    $resultalmoco = $conn->query($sqlalmoco);
                    if($row = $resultalmoco->fetch_assoc()){
                    echo "<td> $row[comentario] </td>
                    <!--<td class='fa fa-fw fa-star'></td>-->
                    </tr>";
                  }else{
                    echo "<td> - </td>
                          <!--<td class='fa fa-fw fa-star'></td> -->
                          </tr>";
                        }}
                
                  
                  ?>

                </table>
              </div>
  
            </div>
 
          </div>
          

        </div>
 

      </section>
 
    </div>


    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Beta</b> 0.2.1
      </div>
      <strong>Direitos reservados © 2017 PenzeNetwork. Desenvolvido com muito  <i class="fa fa-heart" style="color: red;"></i>  em Assis por  <a style="color: violet;" href="http://www.Penze.com.br" target="_blank" rel="noopener"> Penze</a>.</strong> #Interior.
    </footer>

    
</div>


</div>



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

<script>
	/*Atualizar paginas a cada 1min*/
	$('#index').ready(function(){
	setInterval(function() {
	   window.location.reload();
	   window.scrollTo(0, 550);
	}, 50000); 
	});
</script>

</body>
</html>
