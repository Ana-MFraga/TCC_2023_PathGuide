<?php
     include('../../api/conexao/conn.php');

     mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); //Mostra quando dá algum erro
     mysqli_set_charset($conn, "utf8"); //Aceita acentos e caracteres especiais
?>


<div class="grupo">
     <h1 class="title">LOCAIS</h1>

     <button class="btt" onclick="modal()">Cadastrar local</button>  
</div>


<!-- 
     https://celke.com.br/artigo/como-listar-registros-do-banco-de-dados-com-php-e-mysqli-e-criar-paginacao

     https://celke.com.br/artigo/como-pesquisar-com-php-e-mysqli
     https://www.youtube.com/watch?v=IdyTXcTAa68

     VVVV---- Para o ícone
     https://www.educative.io/answers/how-to-add-icons-inside-input-elements-in-html
-->

<section class="tabela_pesquisa">
     <div class="buscar">
          <form action="" method="post" id="form-pesquisa">
               <input type="text" name="pesquisa" id="pesquisa" placeholder="O que você deseja pesquisar?">
          </form>
          <ul class="retorna">
          </ul>
     </div>

     <div class="table-locais">
          <?php
               $query_local = "SELECT * FROM local ORDER BY id";
               $result_local = mysqli_query($conn, $query_local);

               if(isset($result_local)){
                    while($row = mysqli_fetch_assoc($result_local)){
          ?>
          <div class="bloco_locais">
               <section>
          <?php
                         //var_dump($row);
                         extract($row); //Pegando os dados dentro do array ($row) para que possamos usar as variáveis dentro dele

                         $id_local = $id;

                         switch($tipo){
                              case 'Saúde':
                                   //echo '<i class="fa-solid fa-house-medical"></i> <br>';
                                   echo '<img class="img_tipo" src="assets/img/tipo/saude.png"></img> <br>';
                                   break;
                              case 'Administração pública':
                                   //echo '<i class="fa-solid fa-people-roof"></i> <br>';
                                   echo '<img class="img_tipo" src="assets/img/tipo/adm_publica.png"></img> <br>';
                                   break;
                              case 'Segurança':
                                   //echo '<i class="fa-solid fa-shield-halved"></i> <br>';
                                   echo '<img class="img_tipo" src="assets/img/tipo/seguranca.png"></img> <br>';
                                   break;
                              case 'Alimentação':
                                   //echo '<i class="fa-solid fa-utensils"></i> <br>';
                                   echo '<img class="img_tipo" src="assets/img/tipo/alimentacao.png"></img> <br>';
                                   break;
                              case 'Educação':
                                   //echo '<i class="fa-solid fa-school"></i> <br>';
                                   echo '<img class="img_tipo" src="assets/img/tipo/educacao.png"></img> <br>';
                                   break;
                              case 'Financeiro':
                                   //echo '<i class="fa-solid fa-money-bills"></i> <br>';
                                   echo '<img class="img_tipo" src="assets/img/tipo/financeiro.png"></img> <br>';
                                   break;
                              case 'Extrajudicial':
                                   //echo '<i class="fa-solid fa-scale-balanced"></i> <br>';
                                   echo '<img class="img_tipo" src="assets/img/tipo/justica.png"></img> <br>';
                                   break;
                              case 'Serviço público':
                                   //echo '<i class="fa-solid fa-people-group"></i> <br>';
                                   echo '<img class="img_tipo" src="assets/img/tipo/servico_publico.png"></img> <br>';
                                   break;
                         }
                    echo "<h4 class='title'>$nome</h4>";
          ?>
               </section>
               <section>
          <?php
                    echo "<d>Tipo do local:</d> $tipo <br>";

                    // ---------- Endereço ----------
                    $query_endrc = "SELECT loc.id, endrc.fk_local, endrc.logradouro, endrc.bairro, endrc.CEP, endrc.numero FROM endereco endrc LEFT JOIN local AS loc ON endrc.fk_local=loc.id";
                    $result_endrc = mysqli_query($conn, $query_endrc);

                    while($row = mysqli_fetch_assoc($result_endrc)){
                         extract($row);
                         if($fk_local == $id_local){
                              //var_dump($row);
                              echo "<br>";
                              echo "<d>Endereço:</d> $logradouro,$bairro - $numero, $CEP <br>";
                         }
                    }

                    // ---------- Dia semana ----------
                    $query_dSemana = "SELECT loc.id, dSemana.fk_local, dSemana.diaInicio, dSemana.diaFim, dSemana.horaInicio, dSemana.horaFim FROM diaSemana dSemana LEFT JOIN local AS loc ON dSemana.fk_local=loc.id";
                    $result_dSemana = mysqli_query($conn, $query_dSemana);

                    while($row = mysqli_fetch_assoc($result_dSemana)){
                         extract($row);
                         if($fk_local == $id_local){
                              //var_dump($row);
                              echo "<br>";
                              echo "<d>Dias ativos:</d> $diaInicio - $diaFim <br>";
                              if($horaInicio == '00:00:00' && $horaFim == '23:59:00'){
                                   echo "<d>Horário:</d> 24 horas <br>";
                              }else{
                                   echo "<d>Horário:</d> $horaInicio - $horaFim <br>";
                              }
                         }
                    }

                    // ---------- Dia excepcional ----------
                    if($diaExcep != 0){
                         $query_dExcep = "SELECT loc.id, dExcep.fk_local, dExcep.diaSemana, dExcep.dataExcep, dExcep.aberto_fechado, dExcep.horaInicio_excep, dExcep.horaFim_excep  FROM diaExcep dExcep LEFT JOIN local AS loc ON dExcep.fk_local=loc.id";
                         $result_dExcep = mysqli_query($conn, $query_dExcep);

                         while($row = mysqli_fetch_assoc($result_dExcep)){
                              extract($row);

                              if($fk_local == $id_local){
                                   //var_dump($row);
                                   echo "<br>";

                                   if($dataExcep != '0000-00-00'){
                                        echo "<d>Dia excepcional:</d> $dataExcep <br>";
                                   }else{
                                        echo "<d>Dia excepcional:</d> $diaSemana <br>";
                                   }
                                        
                                   if($aberto_fechado == 'Aberto'){
                                        echo "<d>Horário:</d> $horaInicio_excep - $horaFim_excep <br>";
                                   }else{
                                        echo "<d>Horário:</d> $aberto_fechado <br>";
                                   }
                              }
                         }
                    }

                    // ---------- Contato ----------
                    $query_ctt = "SELECT loc.id, ctt.fk_local, ctt.tel FROM contato ctt LEFT JOIN local AS loc ON ctt.fk_local=loc.id";
                    $result_ctt = mysqli_query($conn, $query_ctt);

                    while($row = mysqli_fetch_assoc($result_ctt)){
                         extract($row);

                         if($fk_local == $id_local){
                              //var_dump($row);
                              echo "<br>";
                              echo "<d>Contato:</d> $tel";
                         }
                    }
               ?>
                    </section>
               </div>
               <?php
                    
                    }
                    
                    }else{
                         echo "Nada encontrado...";
                    }
               ?>
     </div>
          
</section>

<div class="modal" style="display: none;">
     <form id="form-local" class="bloco" method="POST" action="api/model/locais.php">
          <h2 class="title">CADASTRAR LOCAL</h2>
          <article>
               <div class="borda">
                    <label>Nome:</label>
                    <input type="text" id="nome" name="nome" required>
               </div>

               <div class="borda">
                    <label>Tipo:</label>
                    <select name="tipo" id="tipo" required>
                         <option value=""></option>
                         <option value="1">Saúde</option>
                         <option value="2">Administração pública</option>
                         <option value="3">Segurança</option>
                         <option value="4">Alimentação</option>
                         <option value="5">Educação</option>
                         <option value="6">Financeiro</option>
                         <option value="7">Extrajudicial</option>
                         <option value="8">Serviço público</option>
                    </select>
               </div>
               
               <div class="borda">
                    <label>Contato:</label>
                    <input type="text" name="contato" id="contato" required>
               </div>

               <div class="borda">
                    <label>Endereço:</label>
                    <span>
                         <input type="text" name="logradouro" id="logradouro" placeholder="Logradouro" required>
                         <input type="text" name="numero" id="numero" placeholder="Número" required>
                    </span>
                    <span>
                         <input type="text" name="bairro" id="bairro" placeholder="Bairro" required>
                         <input type="text" name="cep" id="cep" placeholder="CEP" maxlength="9" required>
                    </span>
               </div>

               <div class="borda">
                    <label>Dias da semana:</label>
                    <span>
                         <label>Dia inicial:</label>
                         <select name="diaInicio" id="diaInicio" required>
                              <option value=""></option>
                              <option value="1">Segunda</option>
                              <option value="2">Terça</option>
                              <option value="3">Quarta</option>
                              <option value="4">Quinta</option>
                              <option value="5">Sexta</option>
                              <option value="6">Sábado</option>
                              <option value="7">Domingo</option>
                         </select>
                    </span>

                    <span>
                         <label>Dia final:</label>
                         <select name="diaFim" id="diaFim" required>
                              <option value=""></option>
                              <option value="1">Segunda</option>
                              <option value="2">Terça</option>
                              <option value="3">Quarta</option>
                              <option value="4">Quinta</option>
                              <option value="5">Sexta</option>
                              <option value="6">Sábado</option>
                              <option value="7">Domingo</option>
                         </select>
                    </span>
               </div>

               <div class="borda">
                    <label>Horário:</label>
                    <span>
                         <label>Início:</label>
                         <input type="time" name="horaInicio" id="horaInicio" required>
                    </span>

                    <span>
                         <label>Fim:</label>
                         <input type="time" name="horaFim" id="horaFim" required>
                    </span>
               </div>

               

               <div class="borda">
                    <label>Dias excepcionais?</label>
                    <span>
                         <input type="radio" name="diaExcep" value="1" required onclick="dExcep()"> <label>Sim</label>
                         <input type="radio" name="diaExcep" value="0" checked required onclick="dExcep()"> <label>Não</label>
                    </span>
               </div>

               <section id="excep" style="display: none;">

                    <div class="borda">
                         <label>Data específica?</label>
                         <span>
                              <input type="radio" name="dtEspec" value="1" class="dExcep" onclick="dExcep()"> <label>Sim</label>
                              <input type="radio" name="dtEspec" value="0" class="dExcep" onclick="dExcep()"> <label>Não</label>
                         </span>
                    </div>

                    <div id="espec_sim" class="borda" style="display: none;">
                         <label>Data:</label>
                         <input type="date" name="dataExcep" id="dataExcep">
                    </div>

                    <div id="espec_nao" class="borda" style="display: none;">
                         <label>Qual dia?</label>
                         <select name="diaSemana" id="diaSemana">
                              <option value="" ></option>
                              <option value="1">Segunda</option>
                              <option value="2">Terça</option>
                              <option value="3">Quarta</option>
                              <option value="4">Quinta</option>
                              <option value="5">Sexta</option>
                              <option value="6">Sábado</option>
                              <option value="7">Domingo</option>
                         </select>
                    </div>

                    <div class="borda">
                         <label>Aberto ou Fechado?</label>
                         <span>
                              <input type="radio" name="aberto_fechado" value="1" class="dExcep" onclick="dExcep()"> <label>Fechado</label>
                              <input type="radio" name="aberto_fechado" value="2" class="dExcep" onclick="dExcep()"> <label>Aberto</label>
                         </span>

                         
                    </div>

                    <div id="dia_aberto" class="borda" style="display: none;">
                         <label>Horário:</label>
                         <span>
                              <label>Início:</label>
                              <input type="time" name="horaInicio_excep" id="horaInicio_excep" class="hr_aberto">
                         </span>
                         <span>
                              <label>Fim:</label>
                              <input type="time" name="horaFim_excep" id="horaFim_excep" class="hr_aberto">
                         </span>
                    </div>
               </section>
          </article>
          

          <span class="grupo_btt">
               <i class="fa-solid fa-angle-left icon" onclick="modal()"></i>
               <input type="submit" class="btt" value="Cadastrar" name="cadLocal">
          </span>

     </form>
</div>

<script src="frontend/controller/busca.js"></script>

