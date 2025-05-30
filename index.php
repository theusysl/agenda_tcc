<?php
    include 'db.php';

    // Consulta com JOINs para buscar nomes reais
    $sql = "
    SELECT a.id, a.data_hora, a.local, a.nota_final, a.aprovado, a.curso, a.cidade,
        po.nome AS orientador,
        pc1.nome AS convidado1,
        pc2.nome AS convidado2,
        al1.nome AS aluno1,
        al2.nome AS aluno2,
        al3.nome AS aluno3
    FROM agendas a
    LEFT JOIN tipo_tcc tt ON a.tipo_tcc_id = tt.id
    LEFT JOIN professor po ON a.prof_orientador_id = po.id
    LEFT JOIN professor pc1 ON a.prof_convidado1_id = pc1.id
    LEFT JOIN professor pc2 ON a.prof_convidado2_id = pc2.id
    LEFT JOIN aluno al1 ON a.aluno1_ra = al1.ra
    LEFT JOIN aluno al2 ON a.aluno2_ra = al2.ra
    LEFT JOIN aluno al3 ON a.aluno3_ra = al3.ra
    ORDER BY a.data_hora DESC
    ";

    $result = $conn->query($sql);
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
                        <td>{$row['tipo_tcc_id']}</td>
                        <td>{$row['prof_orientador']}</td>
                        <td>{$row['aluno1']}<br>{$row['aluno2']}<br>{$row['aluno3']}</td>
                        <td>{$row['nota_final']}</td>
                        <td>{$row['aprovado']}</td>
                        <td>
                            <a href='editar.php?id={$row['id']}' class='btn btn-dark btn-sm'>Editar</a>
                            <a href='excluir.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirmar_exclusao()'>Excluir</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>