//Sistema de busca sem refresh
$(function(){
       $("#pesquisa").keyup(function(){ //keyUp -> Pega informação enquanto está sendo digitado
              var pesquisa = $(this).val(); //Pega o valor sendo digitado

              //Verifica se algo foi digitado
              if(pesquisa != ''){ //Se não estiver vazio
                     var dados = {
                     palavra : pesquisa // Atribuindo o valor de 'pesquisa' para 'palavra'
                     }

                     $.post('api/model/busca.php', dados, function(retorna){
                            $(".retorna").html(retorna); //Enviando os dados para o html
                     });
              }else{
                     $(".retorna").html(''); //Limpa se não tiver nada digitado
              }
       });
});