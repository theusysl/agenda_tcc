<?php
include 'db.php';

$id = $_GET['id'] ?? null;

// Carrega a agenda atual
$stmt = $conn->prepare("SELECT * FROM agendas WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$agenda = $stmt->get_result()->fetch_assoc();

// Carrega TCCs para o dropdown
$tccs = $conn->query("
    SELECT tcc.id, tcc.titulo, aluno.nome AS aluno_nome
    FROM tcc
    JOIN aluno ON tcc.aluno1_ra = aluno.ra
");

// Carrega professores para dropdowns
$professores = $conn->query("SELECT id, nome FROM professor");

// Se formulário enviado
if (isset($_POST['salvar'])) {
    // Prepara o UPDATE da agenda
    $stmt = $conn->prepare("
        UPDATE agendas SET
            tcc_id = ?, tipo_tcc_id = ?, aluno1_ra = ?, aluno2_ra = ?, aluno3_ra = ?,
            prof_orientador_id = ?, data_hora = ?, local = ?, prof_convidado1_id = ?, prof_convidado2_id = ?,
            nota_final = ?, aprovado = ?, curso = ?, cidade = ?
        WHERE id = ?
    ");

    // Trata campos opcionais de alunos
    $aluno2 = empty($_POST['aluno2_ra']) ? null : $_POST['aluno2_ra'];
    $aluno3 = empty($_POST['aluno3_ra']) ? null : $_POST['aluno3_ra'];

    // Faz o bind dos parâmetros do formulário
    $stmt->bind_param(
        "iiiiisssisdsssi",
        $_POST['tcc_id'],
        $_POST['tipo_tcc_id'],
        $_POST['aluno1_ra'],
        $aluno2,
        $aluno3,
        $_POST['prof_orientador_id'],
        $_POST['data_hora'],
        $_POST['local'],
        $_POST['prof_convidado1_id'],
        $_POST['prof_convidado2_id'],
        $_POST['nota_final'],
        $_POST['aprovado'],
        $_POST['curso'],
        $_POST['cidade'],
        $id
    );

    // Executa o update e redireciona ou exibe erro
    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "<div class='alert alert-danger mt-4 text-center'>Erro: " . $stmt->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Agenda</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Editar Agenda de TCC</h2>
    <form method="POST" class="row g-3">
        <!-- Dropdown de TCCs -->
        <div class="col-md-12">
            <label class="form-label">TCC</label>
            <select name="tcc_id" class="form-select" required>
                <option value="">-- Selecione --</option>
                <?php $tccs->data_seek(0); while ($t = $tccs->fetch_assoc()): ?>
                    <option value="<?= $t['id'] ?>" <?= $t['id'] == $agenda['tcc_id'] ? 'selected' : '' ?>>
                        <?= $t['titulo'] ?> (<?= $t['aluno_nome'] ?>)
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Campos herdados (não editáveis, enviados como hidden) -->
        <input type="hidden" name="tipo_tcc_id" value="<?= $agenda['tipo_tcc_id'] ?>">
        <input type="hidden" name="aluno1_ra" value="<?= $agenda['aluno1_ra'] ?>">
        <input type="hidden" name="aluno2_ra" value="<?= $agenda['aluno2_ra'] ?>">
        <input type="hidden" name="aluno3_ra" value="<?= $agenda['aluno3_ra'] ?>">
        <input type="hidden" name="prof_orientador_id" value="<?= $agenda['prof_orientador_id'] ?>">
        <input type="hidden" name="curso" value="<?= $agenda['curso'] ?>">

        <!-- Data e Hora da apresentação -->
        <div class="col-md-6">
            <label class="form-label">Data e Hora</label>
            <input type="datetime-local" name="data_hora" class="form-control"
                   value="<?= date('Y-m-d\TH:i', strtotime($agenda['data_hora'])) ?>" required>
        </div>

        <!-- Local da apresentação -->
        <div class="col-md-6">
            <label class="form-label">Local</label>
            <input type="text" name="local" class="form-control" value="<?= $agenda['local'] ?>" required>
        </div>

        <!-- Dropdown de Professor Convidado 1 -->
        <div class="col-md-6">
            <label class="form-label">Professor Convidado 1</label>
            <select name="prof_convidado1_id" class="form-select" required>
                <option value="">-- Selecione --</option>
                <?php $professores->data_seek(0); while ($p = $professores->fetch_assoc()): ?>
                    <option value="<?= $p['id'] ?>" <?= $p['id'] == $agenda['prof_convidado1_id'] ? 'selected' : '' ?>>
                        <?= $p['nome'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Dropdown de Professor Convidado 2 -->
        <div class="col-md-6">
            <label class="form-label">Professor Convidado 2</label>
            <select name="prof_convidado2_id" class="form-select" required>
                <option value="">-- Selecione --</option>
                <?php $professores->data_seek(0); while ($p = $professores->fetch_assoc()): ?>
                    <option value="<?= $p['id'] ?>" <?= $p['id'] == $agenda['prof_convidado2_id'] ? 'selected' : '' ?>>
                        <?= $p['nome'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Nota final do TCC -->
        <div class="col-md-4">
            <label class="form-label">Nota Final</label>
            <input type="number" step="0.01" name="nota_final" class="form-control" value="<?= $agenda['nota_final'] ?>">
        </div>

        <!-- Situação de aprovação -->
        <div class="col-md-4">
            <label class="form-label">Aprovado?</label>
            <select name="aprovado" class="form-select" required>
                <option value="Sim" <?= $agenda['aprovado'] == "Sim" ? 'selected' : '' ?>>Sim</option>
                <option value="Não" <?= $agenda['aprovado'] == "Não" ? 'selected' : '' ?>>Não</option>
            </select>
        </div>

        <!-- Cidade da apresentação -->
        <div class="col-md-4">
            <label class="form-label">Cidade</label>
            <input type="text" name="cidade" class="form-control" value="<?= $agenda['cidade'] ?>" required>
        </div>

        <!-- Botões de ação -->
        <div class="col-12 d-flex justify-content-between">
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
            <button type="submit" name="salvar" class="btn btn-dark">Salvar Alterações</button>
        </div>
    </form>
</div>
</body>
</html>
