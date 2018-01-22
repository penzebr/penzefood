<?php  
//Função para consultar a tabela status_usuario e retornar algo desejado
//"Listagem" para exibir uma lista dos usuarios, "Numero" para exibir o numero de usuarios dentro do status ou "nada"
  function ctrls($conn, $codstatus ,$exibir){

          $sql1 = 'Select * from status_usuario where codstatus = '.$codstatus.'';
          $result = $conn->query($sql1);
          $numero = mysqli_num_rows($result);
          
          if ($exibir == "listagem") {
               while($row = $result->fetch_assoc()){  
               $hoje = date('Y-m-d');  
               $codusuario = $row['codusuario'];
               $sql2 = "Select * from almoco where codusuario = $codusuario AND dataalmoco = '$hoje'";
               $result2 = $conn->query($sql2);

          if($row2 = $result2->fetch_assoc()){
              if (!empty($row2['comentario']) AND strlen($row2['comentario']) > 2) {
               $display = "";
               $coment = $row2['comentario'];
              } else {
              $display= "display:none;";
              }
              echo ' 
               <div id="'.$row['codusuario'].'" draggable="true" ondragstart="dragstart_handler(event);">
                    <div class="external-event" style="padding:0px; margin:0px; ">
                    <div class="w3-container '.$codstatus.'" >
                    <a href="#" class="pull-right"  data-trigger="hover" data-placement="top" data-toggle="popover" title="Comentário" data-content="'.$coment.'" ><i class="fa fa-fw fa-commenting" style="'.$display.'padding-right: 10px;padding-top: 10px;"></i> </a>
                    <img src="'.$row['avatar'].'" draggable="false" value='.$codstatus.'" style="width:20%; padding-left:10px;">
                    <label> '.$row['nome'].' </label>
                    </div>
                    </div>
                  </div>';
         } else {
           echo ' 
             <div id="'.$row['codusuario'].'" draggable="true" ondragstart="dragstart_handler(event);">
                  <div class="external-event" style="padding:0px; margin:0px; ">
                  <div class="w3-container '.$codstatus.'" >
                  <a href="#" class="pull-right" data-toggle="popover"  data-trigger="hover" data-placement="top" title="Comentário" data-content="teste"><i class="fa fa-fw fa-commenting" style="display:none;padding-right: 10px;padding-top: 10px;"></i> </a>
                  <img src="'.$row['avatar'].'" draggable="false" value='.$codstatus.'" style="width:20%; padding-left:10px;">
                  <label> '.$row['nome'].' </label>
                  </div>
                  </div>
                </div>';
               };
         }
       }
        
          elseif ($exibir == "numero") {
            return $numero;
          }
          else{
            echo "nada";
          }
      };



      function vocevai($statusid){
        if ($statisid == 1) {
        echo "Você vai almoçar";
        }
        elseif ($statusid == 2) {
        echo "você não vai almoçar";
        }
        else{
          echo "você ja retirou sua comida0";
        }
      }


?>


