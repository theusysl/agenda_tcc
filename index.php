<?php
// Inclui o arquivo de conexão com o banco de dados
include 'db.php';

// Executa a consulta para buscar todas as agendas de TCC com informações relacionadas
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
<html lang="pt-BR" data-bs-theme="dark">

<head>
    <title>Agendas de TCC</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <script>
        // Função para confirmar exclusão de uma agenda
        function confirmar_exclusao(mensagem) {
            return confirm(mensagem);
        }

        //função para alternar tema claro/escuro
        document.addEventListener('DOMContentLoaded', function () {
            const toggleThemeButton = document.getElementById('toggleTheme');
            toggleThemeButton.addEventListener('click', function () {
                const currentTheme = document.documentElement.getAttribute('data-bs-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                document.documentElement.setAttribute('data-bs-theme', newTheme);
                toggleThemeButton.textContent = newTheme === 'dark' ? '🌙' : '☀️';
                
            });
        });
    </script>
    <div class="container mt-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Agendas de TCC</h1>
            <div>
                <!-- Navegação para outras páginas -->
                <a href="alunos.php" class="btn btn-outline-dark me-2">Alunos</a>
                <a href="professores.php" class="btn btn-outline-dark me-2">Professores</a>
                <a href="tccs.php" class="btn btn-outline-dark me-2">Lista de TCC</a>
                <a href="adicionar.php" class="btn btn-dark me-2">Adicionar Nova Agenda</a>
                <button class="btn btn-outline-dark" id="toggleTheme">🌓</button>
            </div>
        </div>

        <!-- Tabela de agendas -->
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
            <?php
            $rows = [];
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            for ($i = 0; $i < count($rows); $i++):
                $row = $rows[$i];
            ?>
                <tr>
                    <!-- Exibe os dados da agenda -->
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
                        <!-- Botões de ação -->
                        <a href="editar.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-dark">Editar</a>
                        <a href="excluir.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-dark" onclick="return confirmar_exclusao('Tem certeza que deseja excluir esta agenda?')">Excluir</a>
                    </td>
                </tr>
            <?php endfor; ?>
            </tbody>
        </table>
    </div>
</body>

</html>