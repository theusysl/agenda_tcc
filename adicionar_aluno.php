<?php include 'db.php'; // Inclui o arquivo de conexão com o banco de dados ?>

<!DOCTYPE html>
<html>
<head>
    <title>Adicionar Aluno</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Registrar Novo Aluno</h2>

    <form method="POST" class="row g-3">

        <!-- RA -->
        <div class="col-md-4">
            <label class="form-label">RA</label>
            <input type="number" name="ra" class="form-control" required>
        </div>

        <!-- Nome -->
        <div class="col-md-8">
            <label class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" required>
        </div>

        <!-- Curso -->
        <div class="col-md-12">
            <label class="form-label">Curso</label>
            <input type="text" name="curso" class="form-control">
        </div>

        <!-- Botões -->
        <div class="col-12 d-flex justify-content-between">
            <a href="alunos.php" class="btn btn-dark">Voltar</a>
            <button type="submit" name="salvar" class="btn btn-dark">Salvar</button>
        </div>
    </form>

    <?php
    // Verifica se o formulário foi enviado
    if (isset($_POST['salvar'])) {
        $ra = intval($_POST['ra']); // Obtém o RA como inteiro
        $nome = $_POST['nome'];     // Obtém o nome do aluno
        $curso = $_POST['curso'];   // Obtém o curso do aluno

        // Verifica se já existe RA cadastrado
        $check = $conn->prepare("SELECT 1 FROM aluno WHERE ra = ?");
        $check->bind_param("i", $ra);
        $check->execute();
        $check->store_result();

        // Se já existe, exibe mensagem de erro
        if ($check->num_rows > 0) {
            echo "<div class='alert alert-danger mt-4'>Já existe um aluno com o RA <strong>$ra</strong>.</div>";
        } else {
            // Insere novo aluno no banco de dados
            $stmt = $conn->prepare("INSERT INTO aluno (ra, nome, curso) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $ra, $nome, $curso);

            // Verifica se a inserção foi bem-sucedida
            if ($stmt->execute()) {
                echo "<div class='alert alert-success mt-4'>Aluno cadastrado com sucesso!</div>";
            } else {
                echo "<div class='alert alert-danger mt-4'>Erro: " . $stmt->error . "</div>";
            }
        }
    }
    ?>
</div>
</body>
</html>