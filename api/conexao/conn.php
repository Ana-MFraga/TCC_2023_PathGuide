<?php
    $hostname = "localhost:3310"; //Se usar XAMPP não precisa de número
    $dbname = "pontosuteis";
    $username = "root"; //Como estamos no uso local, o 'root' fica como nome padrão, porém em sistemas mais complexos ele pode mudar, assim como a senha
    $password = "usbw"; //Se usar o XAMPP fica em branco


    $conn = new mysqli($hostname, $username, $password, $dbname); //new mysqli("host", "user", "senha", "banco de dados")
    if($conn->connect_error){
        die('Erro: '.$conn->connect_error); //Mostra se há erro de conexão
    }
    
    //echo 'Conexão realizada com sucesso!';


?>