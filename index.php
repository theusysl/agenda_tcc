<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Agendas de TCC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Agendas de TCC</h1>
    <a href="adicionar.php" class="btn btn-dark mb-3">Adicionar Nova Agenda</a>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Data</th>
                <th>Local</th>
                <th>Orientador</th>
                <th>Alunos</th>
                <th>Nota</th>
                <th>Aprovado</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php

        // consulta todos os registros da tabela agendas
        $result = $conn->query("SELECT * FROM agendas");

        // loop para exibir cada linha da tabela como uma linha na interface html
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['data_hora']}</td>
                    <td>{$row['local']}</td>
                    <td>{$row['prof_orientador']}</td>
                    <td>{$row['aluno1']}<br>{$row['aluno2']}<br>{$row['aluno3']}</td>
                    <td>{$row['nota_final']}</td>
                    <td>{$row['aprovado']}</td>
                    <td>
                        <a href='editar.php?id={$row['id']}' class='btn btn-dark btn-sm'>Editar</a>
                        <a href='excluir.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirmarExclusao()'>Excluir</a>
                    </td>
                </tr>";
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
