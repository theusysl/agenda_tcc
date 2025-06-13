<?php
include 'db.php'; // Inclui o arquivo de conexão com o banco de dados

// Deletar aluno se o ID (RA) for passado via GET
if (isset($_GET['excluir'])) {
    $ra = $_GET['excluir'];
    $stmt = $conn->prepare("DELETE FROM aluno WHERE ra = ?");
    $stmt->bind_param("i", $ra);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Alunos</title>
    <meta charset="utf-8">
    <!-- Bootstrap CSS para estilização -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <!-- Título + Botão -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Alunos</h1>
        <a href="adicionar_aluno.php" class="btn btn-dark">Registrar Aluno</a>
    </div>

    <!-- Tabela de alunos -->
    <table class="table table-hover">
        <thead>
            <tr>
                <th>RA</th>
                <th>Nome</th>
                <th>Curso</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Busca todos os alunos ordenados por nome
        $res = $conn->query("SELECT * FROM aluno ORDER BY nome");
        $alunos = $res->fetch_all(MYSQLI_ASSOC);
        foreach ($alunos as $aluno):
        ?>
            <tr>
            <td><?= $aluno['ra'] ?></td>
            <td><?= $aluno['nome'] ?></td>
            <td><?= $aluno['curso'] ?></td>
            <td>
                <!-- Botão para excluir aluno, com confirmação -->
                <a href="?excluir=<?= $aluno['ra'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Deseja excluir este aluno?')">Excluir</a>
            </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Botão para voltar à página inicial -->
    <a href="index.php" class="btn btn-dark">Voltar</a>
    
</div>
</body>
</html>
