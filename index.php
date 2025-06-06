<?php
include 'db.php';

$result = $conn->query("
SELECT a.id, a.data_hora, a.local, a.nota_final, a.aprovado, a.curso, a.cidade,
       tcc.titulo AS titulo_tcc,
       tipo.descricao AS tipo_tcc,
       a1.nome AS aluno1,
       a2.nome AS aluno2,
       a3.nome AS aluno3,
       p.nome AS orientador
FROM agendas a
LEFT JOIN tcc ON a.tcc_id = tcc.id
LEFT JOIN tipo_tcc tipo ON a.tipo_tcc_id = tipo.id
LEFT JOIN aluno a1 ON a.aluno1_ra = a1.ra
LEFT JOIN aluno a2 ON a.aluno2_ra = a2.ra
LEFT JOIN aluno a3 ON a.aluno3_ra = a3.ra
LEFT JOIN professor p ON a.prof_orientador_id = p.id
ORDER BY a.data_hora DESC
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Agendas de TCC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <script>
        function confirmar_exclusao() {
            return confirm("Tem certeza que deseja excluir esta agenda?");
        }
    </script>
    <div class="container mt-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Agendas de TCC</h1>
            <div>
                <a href="alunos.php" class="btn btn-outline-dark me-2">Alunos</a>
                <a href="professores.php" class="btn btn-outline-dark me-2">Professores</a>
                <a href="tccs.php" class="btn btn-outline-dark me-2">Lista de TCC</a>
                <a href="adicionar.php" class="btn btn-dark">Adicionar Nova Agenda</a>
            </div>
        </div>

        <!-- Tabela -->
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Data/Hora</th>
                    <th>Local</th>
                    <th>Título do TCC</th>
                    <th>Tipo</th>
                    <th>Alunos</th>
                    <th>Orientador</th>
                    <th>Nota</th>
                    <th>Aprovado</th>
                    <th>Curso</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= date('d/m/Y H:i', strtotime($row['data_hora'])) ?></td>
                    <td><?= $row['local'] ?></td>
                    <td><?= $row['titulo_tcc'] ?></td>
                    <td><?= $row['tipo_tcc'] ?></td>
                    <td>
                        <?= $row['aluno1'] ?><br>
                        <?= $row['aluno2'] ?><br>
                        <?= $row['aluno3'] ?>
                    </td>
                    <td><?= $row['orientador'] ?></td>
                    <td><?= $row['nota_final'] ?></td>
                    <td><?= $row['aprovado'] ?></td>
                    <td><?= $row['curso'] ?></td>
                    <td>
                        <a href="editar.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-dark">Editar</a>
                        <a href="excluir.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-dark" onclick="return confirm('Deseja excluir esta agenda?')">Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>