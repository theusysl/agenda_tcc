<?php
// Inclui o arquivo de conexão com o banco de dados
include 'db.php';

// Excluir TCC se o parâmetro 'excluir' estiver presente na URL
if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    // Executa a exclusão do TCC pelo ID
    $conn->query("DELETE FROM tcc WHERE id = $id");
}

// Consulta para buscar todos os TCCs e informações relacionadas
$result = $conn->query("
SELECT tcc.id, tcc.titulo, tcc.curso,
       tipo_tcc.descricao AS tipo,
       a1.nome AS aluno1,
       a2.nome AS aluno2,
       a3.nome AS aluno3,
       p.nome AS orientador
FROM tcc
LEFT JOIN tipo_tcc ON tcc.tipo_tcc_id = tipo_tcc.id
LEFT JOIN aluno a1 ON tcc.aluno1_ra = a1.ra
LEFT JOIN aluno a2 ON tcc.aluno2_ra = a2.ra
LEFT JOIN aluno a3 ON tcc.aluno3_ra = a3.ra
LEFT JOIN professor p ON tcc.professor_orientador_id = p.id
ORDER BY tcc.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>TCCs Registrados</title>
    <meta charset="utf-8">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">TCCs</h2>
        <!-- Botão para cadastrar novo TCC -->
        <a href="adicionar_tcc.php" class="btn btn-dark">Cadastrar TCC</a>
    </div>

    <!-- Tabela de TCCs -->
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Curso</th>
                <th>Tipo</th>
                <th>Alunos</th>
                <th>Orientador</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <!-- Exibe os dados do TCC -->
                <td><?= $row['id'] ?></td>
                <td><?= $row['titulo'] ?></td>
                <td><?= $row['curso'] ?></td>
                <td><?= $row['tipo'] ?></td>
                <td>
                    <?= $row['aluno1'] ?><br>
                    <?= $row['aluno2'] ?><br>
                    <?= $row['aluno3'] ?>
                </td>
                <td><?= $row['orientador'] ?></td>
                <td>
                    <!-- Botões de ação -->
                    <a href="editar_tcc.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-dark">Editar</a>
                    <a href="?excluir=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este TCC?')">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    
    <!-- Botão voltar para a página inicial -->
    <a href="index.php" class="btn btn-dark">Voltar</a>

</div>
</body>
</html>
