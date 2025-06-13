<?php
// Inclui o arquivo de conexão com o banco de dados
include 'db.php';

// Se clicar em excluir
if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    // Prepara e executa a exclusão do professor pelo ID
    $stmt = $conn->prepare("DELETE FROM professor WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Professores</title>
    <meta charset="utf-8">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <!-- Título e botão para adicionar professor -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Professores</h2>
        <a href="adicionar_professor.php" class="btn btn-dark">Registrar Professor</a>
    </div>

    <!-- Tabela de professores -->
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Área de Especialização</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Busca todos os professores cadastrados
        $res = $conn->query("SELECT * FROM professor ORDER BY nome");
        while ($p = $res->fetch_assoc()):
        ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= $p['nome'] ?></td>
                <td><?= $p['email'] ?></td>
                <td><?= $p['area_especializacao'] ?></td>
                <td>
                    <!-- Botão para excluir professor -->
                    <a href="?excluir=<?= $p['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Excluir este professor?')">Excluir</a>
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