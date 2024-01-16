<?php
     include('../conexao/conn.php');

     mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); //Mostra quando dá algum erro
     mysqli_set_charset($conn, "utf8");//Aceita acentos e caracteres especiais

     //Recuperar o valor da palavra
     $locais = $_POST['palavra'];

     //Pesquisando no BD a palavra digitada
     $query_nome = "SELECT * FROM local WHERE nome LIKE '%$locais%' GROUP BY nome";//%$locais% -> % = Pode haver caracteres antes ou depois
     $result_nome = mysqli_query($conn, $query_nome);

     //Pesquisando no BD a palavra digitada
     $query_tipo = "SELECT * FROM local WHERE tipo LIKE '%$locais%' GROUP BY tipo";//%$locais% -> % = Pode haver caracteres antes ou depois
     $result_tipo = mysqli_query($conn, $query_tipo);

     if(mysqli_num_rows($result_nome) <= 0 && mysqli_num_rows($result_tipo) <= 0){ //Se não houver registros com essa palavra
          echo "<br>Nada encontrado...";
     }else{
          if(mysqli_num_rows($result_nome) > 0){
               echo "<h4>Locais:</h4>";
               while($rows = mysqli_fetch_assoc($result_nome) ){
                    echo "<li>".$rows['nome']."</li>";
               }
          }

          if(mysqli_num_rows($result_tipo) > 0){
               echo "<h4>Tipos:</h4>";
               while($rows = mysqli_fetch_assoc($result_tipo) ){
                    echo "<li>".$rows['tipo']."</li>";
               }
          }
     }

     
?>