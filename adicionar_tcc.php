<?php
include 'db.php';

// Carrega dropdowns de alunos, professores e tipos de TCC
$alunos = $conn->query("SELECT ra, nome FROM aluno");
$professores = $conn->query("SELECT id, nome FROM professor");
$tipos = $conn->query("SELECT id, descricao FROM tipo_tcc");

if (isset($_POST['salvar'])) {
    // Trata os campos opcionais: "" => null
    $aluno2 = empty($_POST['aluno2_ra']) ? null : $_POST['aluno2_ra'];
    $aluno3 = empty($_POST['aluno3_ra']) ? null : $_POST['aluno3_ra'];

    // Prepara a query de inserção do novo TCC
    $stmt = $conn->prepare("
        INSERT INTO tcc (titulo, tipo_tcc_id, aluno1_ra, aluno2_ra, aluno3_ra, professor_orientador_id, curso)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    // Faz o bind dos parâmetros para a query preparada
    $stmt->bind_param(
        "siiiiss",
        $_POST['titulo'],
        $_POST['tipo_tcc_id'],
        $_POST['aluno1_ra'],
        $aluno2,
        $aluno3,
        $_POST['professor_orientador_id'],
        $_POST['curso']
    );

    // Executa a query e exibe mensagem de sucesso ou erro
    if ($stmt->execute()) {
        echo "<div class='alert alert-success mt-4 text-center'>TCC cadastrado com sucesso!</div>";
    } else {
        echo "<div class='alert alert-danger mt-4 text-center'>Erro: " . $stmt->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Adicionar TCC</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Cadastrar Novo TCC</h2>
    <form method="POST" class="row g-3">
        <!-- Título -->
        <div class="col-md-12">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" required>
        </div>

        <!-- Tipo TCC -->
        <div class="col-md-6">
            <label class="form-label">Tipo de TCC</label>
            <select name="tipo_tcc_id" class="form-select" required>
                <option value="">-- Selecione --</option>
                <?php while($t = $tipos->fetch_assoc()): ?>
                    <option value="<?= $t['id'] ?>"><?= $t['descricao'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Curso -->
        <div class="col-md-6">
            <label class="form-label">Curso</label>
            <input type="text" name="curso" class="form-control" required>
        </div>

        <!-- Aluno 1 -->
        <div class="col-md-4">
            <label class="form-label">Aluno 1 (obrigatório)</label>
            <select name="aluno1_ra" class="form-select" required>
                <option value="">-- Selecione --</option>
                <?php $alunos->data_seek(0); while($a = $alunos->fetch_assoc()): ?>
                    <option value="<?= $a['ra'] ?>"><?= $a['nome'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Aluno 2 (opcional) -->
        <div class="col-md-4">
            <label class="form-label">Aluno 2 (opcional)</label>
            <select name="aluno2_ra" class="form-select">
                <option value="">-- Selecione --</option>
                <?php $alunos->data_seek(0); while($a = $alunos->fetch_assoc()): ?>
                    <option value="<?= $a['ra'] ?>"><?= $a['nome'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Aluno 3 (opcional) -->
        <div class="col-md-4">
            <label class="form-label">Aluno 3 (opcional)</label>
            <select name="aluno3_ra" class="form-select">
                <option value="">-- Selecione --</option>
                <?php $alunos->data_seek(0); while($a = $alunos->fetch_assoc()): ?>
                    <option value="<?= $a['ra'] ?>"><?= $a['nome'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Professor Orientador -->
        <div class="col-md-6">
            <label class="form-label">Professor Orientador</label>
            <select name="professor_orientador_id" class="form-select" required>
                <option value="">-- Selecione --</option>
                <?php while($p = $professores->fetch_assoc()): ?>
                    <option value="<?= $p['id'] ?>"><?= $p['nome'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Botões de ação -->
        <div class="col-12 d-flex justify-content-between">
            <a href="tccs.php" class="btn btn-secondary">Voltar</a>
            <button type="submit" name="salvar" class="btn btn-primary">Salvar</button>
        </div>
    </form>
</div>
</body>
</html>
