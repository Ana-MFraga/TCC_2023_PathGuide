<?php
    include('../conexao/conn.php');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); //Mostra quando dá algum erro
    mysqli_set_charset($conn, "utf8"); //Aceita acentos e caracteres especiais

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //var_dump($dados);

    if(!empty($dados['cadLocal'])){
        $stmt = mysqli_prepare($conn, "INSERT INTO local(nome, tipo, diaExcep) VALUES (?,?,?)");
        mysqli_stmt_bind_param($stmt, 'sii', $dados['nome'], $dados['tipo'], $dados['diaExcep']);

        mysqli_stmt_execute($stmt);

        //var_dump(mysqli_insert_id($conn));
        $id_local = mysqli_insert_id($conn); //Pega o último ID inserido

        $stmt = mysqli_prepare($conn, "INSERT INTO contato(tel, fk_local) VALUES (?,?)");
        mysqli_stmt_bind_param($stmt, 'si', $dados['contato'], $id_local);

        mysqli_stmt_execute($stmt);

        $stmt = mysqli_prepare($conn, "INSERT INTO endereco(logradouro, bairro, CEP, numero, fk_local) VALUES(?,?,?,?,?)");
        mysqli_stmt_bind_param($stmt, 'ssssi', $dados['logradouro'], $dados['bairro'], $dados['cep'], $dados['numero'], $id_local);

        mysqli_stmt_execute($stmt);

        $stmt = mysqli_prepare($conn, "INSERT INTO diasemana(diaInicio, diaFim, horaInicio, horaFim, fk_local) VALUES(?,?,?,?,?)");
        mysqli_stmt_bind_param($stmt, 'iissi', $dados['diaInicio'], $dados['diaFim'], $dados['horaInicio'], $dados['horaFim'], $id_local);

        mysqli_stmt_execute($stmt);


        if($dados['diaExcep'] != 0){
            $stmt = mysqli_prepare($conn, "INSERT INTO diaexcep(diaSemana, dataExcep, aberto_fechado,horaInicio_excep, horaFim_excep, fk_local) VALUES (?,?,?,?,?,?)");
            mysqli_stmt_bind_param($stmt, 'isissi', $dados['diaSemana'], $dados['dataExcep'], $dados['aberto_fechado'], $dados['horaInicio_excep'], $dados['horaFim_excep'], $id_local);

            mysqli_stmt_execute($stmt);
        }

        echo '<p style="display: flex; align-content:center; justify-content:center; margin: 20px auto 0; width: fit-content; background-color: #2686C7; border: none; border-radius: 2rem;padding: 1rem; text-align:center; color: #FCFCFC; font-size: 40px;"> &check; Cadastro realizado com sucesso!</p>';
        echo "<script> window.location.href='../../index.html'</script>";

    }else{
        echo '<p style="display: flex; align-content:center; justify-content:center; margin: 20px auto 0; width: fit-content; background-color: #FF8A00; border: none; border-radius: 2rem;padding: 1rem; text-align:center; color: #FCFCFC; font-size: 50px;"> &times; Erro no cadastro! </p>';
    }

?>