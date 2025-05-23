<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>

<head>
    <title>Adicionar Agenda</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container mt-5">
        <h2 class="mb-4">Adicionar Nova Agenda de TCC</h2>

        <form method="post" class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Data e Hora</label>
                <input type="datetime-local" class="form-control" name="data_hora" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Local</label>
                <input type="text" class="form-control" name="local" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Prof. Orientador</label>
                <input type="text" class="form-control" name="prof_orientador">
            </div>
            <div class="col-md-4">
                <label class="form-label">Prof. Convidado 1</label>
                <input type="text" class="form-control" name="prof_convidado1">
            </div>
            <div class="col-md-4">
                <label class="form-label">Prof. Convidado 2</label>
                <input type="text" class="form-control" name="prof_convidado2">
            </div>

            <div class="col-md-4">
                <label class="form-label">Aluno 1</label>
                <input type="text" class="form-control" name="aluno1">
            </div>
            <div class="col-md-4">
                <label class="form-label">Aluno 2</label>
                <input type="text" class="form-control" name="aluno2">
            </div>
            <div class="col-md-4">
                <label class="form-label">Aluno 3</label>
                <input type="text" class="form-control" name="aluno3">
            </div>

            <div class="col-md-4">
                <label class="form-label">Nota Final</label>
                <input type="number" step="0.1" class="form-control" name="nota_final">
            </div>
            <div class="col-md-4">
                <label class="form-label">Aprovado</label>
                <select class="form-select" name="aprovado">
                    <option value="Sim">Sim</option>
                    <option value="Não">Não</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Curso</label>
                <input type="text" class="form-control" name="curso">
            </div>

            <div class="col-md-12">
                <label class="form-label">Cidade</label>
                <input type="text" class="form-control" name="cidade">
            </div>

            <div class="col-12 d-flex justify-content-between">
                <a href="index.php" class="btn btn-dark">Voltar</a>
                <button type="submit" name="salvar" class="btn btn-dark">Salvar</button>
            </div>
        </form>

        <?php
        // verifica se o formulário foi enviado
        if (isset($_POST['salvar'])) {

            // prepara o comando sql com placeholders (evita sql injection)
            $sql = "INSERT INTO agendas (
                data_hora, local, prof_orientador, prof_convidado1, prof_convidado2, 
                aluno1, aluno2, aluno3, nota_final, aprovado, curso, cidade
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // prepara a consulta no banco
            $stmt = $conn->prepare($sql);

            // associa os parâmetros aos valores enviados no formulário
            $stmt->bind_param(
                "ssssssssdsss",
                $_POST['data_hora'],
                $_POST['local'],
                $_POST['prof_orientador'],
                $_POST['prof_convidado1'],
                $_POST['prof_convidado2'],
                $_POST['aluno1'],
                $_POST['aluno2'],
                $_POST['aluno3'],
                $_POST['nota_final'],
                $_POST['aprovado'],
                $_POST['curso'],
                $_POST['cidade']
            );

            // executa a inserção
            if ($stmt->execute()) {
                echo "<div class='alert alert-success mt-4'>Agenda adicionada com sucesso!</div>";
            } else {
                echo "<div class='alert alert-danger mt-4'>Erro: " . $stmt->error . "</div>";
            }
        }

        ?>

    </div>

</body>

</html>