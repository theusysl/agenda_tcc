<?php 
// Inclui o arquivo de conexão com o banco de dados
include 'db.php'; 
?>

<!DOCTYPE html>
<html>
<head>
    <title>Adicionar Professor</title>
    <meta charset="utf-8">
    <!-- Importa o CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Registrar Novo Professor</h2>

    <!-- Formulário para adicionar novo professor -->
    <form method="POST" class="row g-3">

        <!-- Nome -->
        <div class="col-md-6">
            <label class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" required>
        </div>

        <!-- Email -->
        <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control">
        </div>

        <!-- Área de Especialização -->
        <div class="col-md-12">
            <label class="form-label">Área de Especialização</label>
            <input type="text" name="area" class="form-control">
        </div>

        <!-- Botões -->
        <div class="col-12 d-flex justify-content-between">
            <a href="professores.php" class="btn btn-dark">Voltar</a>
            <button type="submit" name="salvar" class="btn btn-dark">Salvar</button>
        </div>
    </form>

    <?php
    // Verifica se o formulário foi enviado
    if (isset($_POST['salvar'])) {
        // Prepara a query para inserir um novo professor
        $stmt = $conn->prepare("INSERT INTO professor (nome, email, area_especializacao) VALUES (?, ?, ?)");
        // Faz o bind dos parâmetros recebidos do formulário
        $stmt->bind_param("sss", $_POST['nome'], $_POST['email'], $_POST['area']);

        // Executa a query e exibe mensagem de sucesso ou erro
        if ($stmt->execute()) {
            echo "<div class='alert alert-success mt-4'>Professor cadastrado com sucesso!</div>";
        } else {
            echo "<div class='alert alert-danger mt-4'>Erro: " . $stmt->error . "</div>";
        }
    }
    ?>
</div>
</body>
</html>
