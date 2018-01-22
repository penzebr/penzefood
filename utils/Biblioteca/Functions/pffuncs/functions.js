var url = window.location;

// for sidebar menu entirely but not cover treeview
$('ul.sidebar-menu a').filter(function() {
   return this.href == url;
}).parent().addClass('active');

// for treeview
$('ul.treeview-menu a').filter(function() {
   return this.href == url;
}).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');


function dragstart_handler(ev) {
 // Adiciona o id do elemento alvo para o objeto de transferência de dados
 ev.dataTransfer.setData("text/plain", ev.target.id);
 ev.dropEffect = "move";
}

function dragover_handler(ev) {
 ev.preventDefault();
 // Define o dropEffect para ser do tipo move
 // ev.dataTransfer.dropEffect = "move"
 
}

function drop_handler(obj,ev) {
 ev.preventDefault();
 var e = (obj.id);
 // Pega o id do alvo e adiciona o elemento que foi movido para o DOM do alvo
 var data = ev.dataTransfer.getData("text"); 
  $("#codusu").val(data);
  $("#codstatus").val(e);
  $("#exampleModal").modal();
  //resgata value da data e seta no campo do modal que possui id codusu

  

}

$(function(){ 

  $("#procurar").keyup(function(){
    var texto = $(this).val();
    
    $(".w3-container.0").each(function(){
      var resultado = $(this).text().toUpperCase().indexOf(' '+texto.toUpperCase());
      
      if(resultado < 0) {
        $(this).fadeOut();
      }else {
        $(this).fadeIn();
      }
    }); 

  });

});

function limpar() {

     document.getElementById("procurar").value = "";
  
}