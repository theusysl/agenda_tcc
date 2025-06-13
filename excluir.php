<?php
include 'db.php'; // Inclui o arquivo de conexão com o banco de dados

// Obtém o id da agenda a ser excluída via GET
$id = $_GET['id'];

// Monta a query SQL para deletar a agenda com o id especificado
$sql = "DELETE FROM agendas WHERE id=$id";

// Executa a query no banco de dados
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Excluir Agenda</title>
    <meta charset="utf-8">
    <!-- Inclui o Bootstrap para estilização -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <?php if ($resultado): ?>
        <!-- Exibe mensagem de sucesso caso a exclusão ocorra sem erros -->
        <div class="alert alert-success">
            Agenda excluída com sucesso. <a href="index.php" class="btn btn-sm btn-success ms-3">Voltar</a>
        </div>
    <?php else: ?>
        <!-- Exibe mensagem de erro caso a exclusão falhe -->
        <div class="alert alert-danger">
            Erro ao excluir: <?= $conn->error ?> <a href="index.php" class="btn btn-sm btn-danger ms-3">Voltar</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
