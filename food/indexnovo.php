<?php
session_start();
//Inclusão da conexão com o banco
include_once("../utils/Biblioteca/BD/conn.php");
//Inclusão de funções para solucionar o problema de conversão de strings ao serem puxadas do bd
include_once("../utils/Biblioteca/BD/functionsdb.php");
//Funções do sistema, toda pagina deve ter
include_once("../utils/Sis/functions.php");
//Funções php
include_once("../utils/Biblioteca/Functions/functionsphp.php");

?>
<!DOCTYPE html>
<html>
<?php 
//Inclui ocabeçalho (a barra de navegação do topo)
include("cabecalhonovo.php");
//Inclui a barra de navegação lateral 
include("sidebar.php");
?>
<body id="index">
<!-- "Content Wrapper" contem todo o conteudo da pagina -->
<div class="content-wrapper">
  <!-- Cabeçalho da pagina -->
  <section class="content-header">
    <h1>
      PenzeFood
      <small>Dashboard</small>
    </h1>
  
  <!-- Conteudo principal-->
  <section class="content" style="padding-left:0px;">
    <!-- Caixa de usuarios aguardando -->
        <div class="row">
        <div class="col-md-3" style="padding-left:0px;">
          <div class="box box-solid" style="    border-bottom-left-radius: 0px;">
            <div class="box-header with-border">
              <div class="input-group" style="padding-top:5px;width: 100%!important;">
               <input type="text" name="q" id="procurar" class="form-control" style="width: 100%!important;" placeholder="Procurar...">
        
         <!--   Botão para limpar campo de busca

                <span class="input-group-btn">
                <button type="button" name="search" id="limpar" onclick="limpar();" class="btn btn-flat"><i class="fa fa-fw fa-times"></i></button>
               </span> -->

              </div>
            </div>
            <div class="box-body" style="padding-right:0px; padding-left:0px;padding-top:0px;">
              <!-- the events -->
          
            <?php
             $numero = ctrls($conn ,0 ,"numero");
              echo '<div>
              <div class="bg-blue" style="padding-left:0px; padding-right:10px; margin:0px;">
              <label style="text-align: center;margin-top:5px;padding-left:4%;"> '.$numero.' Não se decidiram ainda! </label>
              </div>
              </div>';

              ctrls($conn,0, "listagem");

            ?>
            <!-- /.fim da caixa de usuarios aguardando -->
        </div>
    </div>
</div>   
            
        <!-- Pessoas que vão almoçar -->
        <div class="col-lg-3 col-xs-6" style="padding-right: 5px; padding-left: 5px;">
          <div class="box box-solid">
            <div class="box-header" style="padding:0px;"> 
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3>
                  <?php 
                  echo ctrls($conn,1,"numero"); 
                  echo '</h3><p>Vão almoçar</p> ';
                  ?>
                </div>
                <div class="icon">
                  <i class="fa fa-fw fa-history"></i>
                </div>
              </div>
            </div>
            <div class="box-body" id="1" ondrop="drop_handler(this,event);"  ondragover="dragover_handler(event);" style="padding-right:0px; padding-left:0px;padding-top:0px;">
            <?php
              ctrls($conn,1, "listagem");
            ?>
          </div>
         </div>
        </div>
        <!-- Fim da caixa de Pessoas que vão almoçar -->


        <!-- Pessoas que já almoçam -->
        <div class="col-lg-3 col-xs-6" style="padding-right: 5px; padding-left: 5px;">
          <div class="box box-solid">
            <div class="box-header" style="padding:0px;"> 
              <div class="small-box bg-green">
                <div class="inner">
                  <h3>
                  <?php 
                  echo ctrls($conn,3,"numero"); 
                  echo '</h3><p>Já pegaram</p> ';
                  ?>
                </div>
                <div class="icon">
                  <i class="fa fa-fw fa-thumbs-up" style="float:none;"></i>
                </div>
              </div>
            </div>
            <div class="box-body" id="3" ondrop="drop_handler(this,event);" ondragover="dragover_handler(event);" style="padding-right:0px; padding-left:0px;padding-top:0px;min-height: 55px;">
            <?php
              ctrls($conn,3, "listagem");
            ?>
          </div>
         </div>
        </div>  
        <!-- Fim da caixa de Pessoas que já almoçam -->


        <!-- Pessoas que não almoçarão -->
        <div class="col-lg-3 col-xs-6" style="padding-right: 5px; padding-left: 5px;">
          <div class="box box-solid">
            <div class="box-header" style="padding:0px;"> 
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>
                  <?php 
                  echo ctrls($conn,2,"numero"); 
                  echo '</h3><p>Não almoçarão</p> ';
                  ?>
                </div>
                <div class="icon">
                   <i class="fa fa-fw fa-times"></i>
                </div>
              </div>
            </div>
            <div class="box-body" id="2" ondrop="drop_handler(this,event)" ondragover="dragover_handler(event);" style="padding-right:0px; padding-left:0px;padding-top:0px;">
            <?php
              ctrls($conn,2, "listagem");
            ?>
          </div>
         </div>
        </div>  
         <!-- Fim da caixa de Pessoas que não almoçarão -->
        
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirme sua Escolha</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form name="mudastatus" id="mudastatus" method="POST" action="../utils/Biblioteca/Functions/pffuncs/validapin.php" data-toggle="" role="form" enctype="multipart/form-data" >  
                <input type="hidden" id="codusu" name="codusu" value="">
                <input type="hidden" id="codstatus" name="codstatus" value="">
            <div class="form-group row">
                <label for="pin" class="col-sm-2 col-form-label">Pin</label>
                  <div class="col-sm-10">
                    <input type="password" name="pin" class="form-control" id="pin" placeholder="Insira seu Pin">
                  </div>
            </div>
            <div class="form-group row">
              <label for="comentario" class="col-sm-2 col-form-label">Comentário</label>
              <div class="col-sm-10">
                <input type="text" name="comentario" class="form-control" id="comentario" placeholder="Insira um comentário">
              </div>
            </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Confirmar</button>
        </form>
      </div>
    </div>
  </div>
</div>

  </section>
  <!-- Fim do Conteudo principal-->
 
</div>
  <!-- Fim do content wrapper -->

<?php 
//Inclusão do rodapé
include_once("../utils/Estrutura/rodape.php"); ?>

    
</div>


</div>



<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve o conflito do jQuery UI tooltip com o Bootstrap tooltip -->
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

<script >
  
//   function colorChange() {
//     $('#nome').text(this);
//     $( 'span' ).delay(2000).fadeOut(1000,function(){
//     $(this).text('red');
//     }).fadeIn(1000).delay(2000).fadeOut(1000,function(){
//     $(this).text('green');
//     }).fadeIn(1000);
//   }

// $(document).ready(function(){

// var colorLooper = setInterval(function() {
// colorChange();
// }, 6000);
// });

$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});

</script>

<!-- Inclusão de funções destinadas a esta pagina -->
<script src="../utils/Biblioteca/Functions/pffuncs/functions.js"> </script>

<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
</body>
</html>
