<?php
include 'db.php';

// Excluir TCC
if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    $conn->query("DELETE FROM tcc WHERE id = $id");
}

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">TCCs</h2>
        <a href="adicionar_tcc.php" class="btn btn-dark">Cadastrar TCC</a>
    </div>

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
                    <a href="editar_tcc.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-dark">Editar</a>
                    <a href="?excluir=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este TCC?')">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    
    <!-- Botão voltar index -->
    <a href="index.php" class="btn btn-dark">Voltar</a>

</div>
</body>
</html>
