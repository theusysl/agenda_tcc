<?php
include 'db.php';

// Busca dados para dropdowns
$professores = $conn->query("SELECT id, nome FROM professor");
$alunos = $conn->query("SELECT ra, nome FROM aluno");
$tipos = $conn->query("SELECT id, descricao FROM tipo_tcc");

// Se formulário enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $conn->prepare("
        INSERT INTO agendas (
            data_hora, local, tipo_tcc_id,
            prof_orientador_id, prof_convidado1_id, prof_convidado2_id,
            aluno1_ra, aluno2_ra, aluno3_ra,
            nota_final, aprovado, curso, cidade
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "ssiiiiiiisss",
        $_POST["data_hora"],
        $_POST["local"],
        $_POST["tipo_tcc_id"],
        $_POST["prof_orientador_id"],
        $_POST["prof_convidado1_id"],
        $_POST["prof_convidado2_id"],
        $_POST["aluno1_ra"],
        $_POST["aluno2_ra"],
        $_POST["aluno3_ra"],
        $_POST["nota_final"],
        $_POST["aprovado"],
        $_POST["curso"],
        $_POST["cidade"]
    );

    if ($stmt->execute()) {
        echo "<div class='alert alert-success mt-4 text-center'>Agenda adicionada com sucesso!</div>";
    } else {
        echo "<div class='alert alert-danger mt-4 text-center'>Erro ao inserir: " . $stmt->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Adicionar Nova Agenda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Adicionar Nova Agenda de TCC</h2>

        <form method="POST" class="row g-3">
            <!-- Data e Hora -->
            <div class="col-md-4">
                <label class="form-label">Data e Hora</label>
                <input type="datetime-local" class="form-control" name="data_hora" required>
            </div>

            <!-- Local -->
            <div class="col-md-4">
                <label class="form-label">Local</label>
                <input type="text" class="form-control" name="local" required>
            </div>

            <!-- Tipo de TCC -->
            <div class="col-md-4">
                <label class="form-label">Tipo de TCC</label>
                <select name="tipo_tcc_id" class="form-select" required>
                    <option value="">-- Selecione --</option>
                    <?php while($t = $tipos->fetch_assoc()): ?>
                        <option value="<?= $t['id'] ?>"><?= $t['descricao'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Professores -->
            <div class="col-md-4">
                <label class="form-label">Prof. Orientador</label>
                <select name="prof_orientador_id" class="form-select" required>
                    <option value="">-- Selecione --</option>
                    <?php $professores->data_seek(0); while($p = $professores->fetch_assoc()): ?>
                        <option value="<?= $p['id'] ?>"><?= $p['nome'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Prof. Convidado 1</label>
                <select name="prof_convidado1_id" class="form-select" required>
                    <option value="">-- Selecione --</option>
                    <?php $professores->data_seek(0); while($p = $professores->fetch_assoc()): ?>
                        <option value="<?= $p['id'] ?>"><?= $p['nome'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Prof. Convidado 2</label>
                <select name="prof_convidado2_id" class="form-select" required>
                    <option value="">-- Selecione --</option>
                    <?php $professores->data_seek(0); while($p = $professores->fetch_assoc()): ?>
                        <option value="<?= $p['id'] ?>"><?= $p['nome'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Alunos -->
            <div class="col-md-4">
                <label class="form-label">Aluno 1</label>
                <select name="aluno1_ra" class="form-select" required>
                    <option value="">-- Selecione --</option>
                    <?php $alunos->data_seek(0); while($a = $alunos->fetch_assoc()): ?>
                        <option value="<?= $a['ra'] ?>"><?= $a['nome'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Aluno 2</label>
                <select name="aluno2_ra" class="form-select">
                    <option value="">-- Selecione --</option>
                    <?php $alunos->data_seek(0); while($a = $alunos->fetch_assoc()): ?>
                        <option value="<?= $a['ra'] ?>"><?= $a['nome'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Aluno 3</label>
                <select name="aluno3_ra" class="form-select">
                    <option value="">-- Selecione --</option>
                    <?php $alunos->data_seek(0); while($a = $alunos->fetch_assoc()): ?>
                        <option value="<?= $a['ra'] ?>"><?= $a['nome'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Nota Final -->
            <div class="col-md-4">
                <label class="form-label">Nota Final</label>
                <input type="number" step="0.01" class="form-control" name="nota_final">
            </div>

            <!-- Aprovado -->
            <div class="col-md-4">
                <label class="form-label">Aprovado</label>
                <select name="aprovado" class="form-select" required>
                    <option value="Sim">Sim</option>
                    <option value="Não">Não</option>
                </select>
            </div>

            <!-- Curso -->
            <div class="col-md-4">
                <label class="form-label">Curso</label>
                <input type="text" class="form-control" name="curso" required>
            </div>

            <!-- Cidade -->
            <div class="col-md-12">
                <label class="form-label">Cidade</label>
                <input type="text" class="form-control" name="cidade" required>
            </div>

            <!-- Botões -->
            <div class="col-12 d-flex justify-content-between">
                <a href="index.php" class="btn btn-secondary">Voltar</a>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</body>
</html>
