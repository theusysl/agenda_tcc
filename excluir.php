<?php
include 'db.php';

// deleta a agenda com base no id passado por GET
$id = $_GET['id'];
$sql = "DELETE FROM agendas WHERE id=$id";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Excluir Agenda</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <?php if ($resultado): ?>
        // exibe mensagem de sucesso ou erro
        <div class="alert alert-success">
            Agenda excluída com sucesso. <a href="index.php" class="btn btn-sm btn-success ms-3">Voltar</a>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">
            Erro ao excluir: <?= $conn->error ?> <a href="index.php" class="btn btn-sm btn-danger ms-3">Voltar</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
