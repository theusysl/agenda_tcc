<?php
    // configuração de conexão com o banco de dados mysql
    $host = 'localhost';
    $db = 'agenda_tcc';
    $user = 'root';
    $pass = '';

    // cria a conexão
    $conn = new mysqli($host, $user, $pass, $db);

    // verifica se houve erro na conexão
    if ($conn->connect_error) {
        die("Erro: " . $conn->connect_error);
    }
?>