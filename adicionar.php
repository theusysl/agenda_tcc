<?php
include 'db.php';

// Carrega TCCs para o dropdown
$tccs = $conn->query("
    SELECT tcc.id, tcc.titulo, aluno.nome AS aluno_nome
    FROM tcc
    JOIN aluno ON tcc.aluno1_ra = aluno.ra
");

// Se um TCC foi selecionado
$tccData = null;
if (isset($_POST['tcc_id'])) {
    $tcc_id = $_POST['tcc_id'];

    $stmt = $conn->prepare("
        SELECT tcc.*, 
               a1.nome AS aluno1_nome, 
               a2.nome AS aluno2_nome, 
               a3.nome AS aluno3_nome, 
               p.nome AS orientador_nome,
               tipo_tcc.descricao AS tipo_tcc_desc
        FROM tcc
        LEFT JOIN aluno a1 ON tcc.aluno1_ra = a1.ra
        LEFT JOIN aluno a2 ON tcc.aluno2_ra = a2.ra
        LEFT JOIN aluno a3 ON tcc.aluno3_ra = a3.ra
        LEFT JOIN professor p ON tcc.professor_orientador_id = p.id
        LEFT JOIN tipo_tcc ON tcc.tipo_tcc_id = tipo_tcc.id
        WHERE tcc.id = ?
    ");
    $stmt->bind_param("i", $tcc_id);
    $stmt->execute();
    $tccData = $stmt->get_result()->fetch_assoc();
}

// Lista de professores (para convidados)
$professores = $conn->query("SELECT id, nome FROM professor");

// Se formulário final enviado
if (isset($_POST['salvar'])) {

    $aluno2 = empty($_POST['aluno2_ra']) ? null : $_POST['aluno2_ra'];
    $aluno3 = empty($_POST['aluno3_ra']) ? null : $_POST['aluno3_ra'];
    
    $stmt = $conn->prepare("
        INSERT INTO agendas (
            tcc_id, tipo_tcc_id, aluno1_ra, aluno2_ra, aluno3_ra, prof_orientador_id,
            data_hora, local, prof_convidado1_id, prof_convidado2_id,
            nota_final, aprovado, curso, cidade
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "iiiiisssisdsss",
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
        $_POST['cidade']
    );    

    if ($stmt->execute()) {
        echo "<div class='alert alert-success mt-4 text-center'>Agenda cadastrada com sucesso!</div>";
    } else {
        echo "<div class='alert alert-danger mt-4 text-center'>Erro: " . $stmt->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Adicionar Agenda</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Cadastrar Agenda de TCC</h2>

    <!-- Passo 1: Selecionar TCC -->
    <form method="POST" class="row g-3 mb-4">
        <div class="col-md-10">
            <label class="form-label">Selecione um TCC</label>
            <select name="tcc_id" class="form-select" required onchange="this.form.submit()">
                <option value="">-- Selecione --</option>
                <?php while ($t = $tccs->fetch_assoc()): ?>
                    <option value="<?= $t['id'] ?>" <?= (isset($tcc_id) && $t['id'] == $tcc_id) ? 'selected' : '' ?>>
                        <?= $t['titulo'] ?> (<?= $t['aluno_nome'] ?>)
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-dark w-100">Carregar</button>
        </div>
    </form>

    <?php if ($tccData): ?>
    <!-- Passo 2: Preencher restante da agenda -->
    <form method="POST" class="row g-3">
        <!-- Dados ocultos do TCC -->
        <input type="hidden" name="tcc_id" value="<?= $tccData['id'] ?>">
        <input type="hidden" name="tipo_tcc_id" value="<?= $tccData['tipo_tcc_id'] ?>">
        <input type="hidden" name="aluno1_ra" value="<?= $tccData['aluno1_ra'] ?>">
        <input type="hidden" name="aluno2_ra" value="<?= $tccData['aluno2_ra'] ?>">
        <input type="hidden" name="aluno3_ra" value="<?= $tccData['aluno3_ra'] ?>">
        <input type="hidden" name="prof_orientador_id" value="<?= $tccData['professor_orientador_id'] ?>">
        <input type="hidden" name="curso" value="<?= $tccData['curso'] ?>">

        <!-- Data e hora -->
        <div class="col-md-6">
            <label class="form-label">Data e Hora</label>
            <input type="datetime-local" name="data_hora" class="form-control" required>
        </div>

        <!-- Local -->
        <div class="col-md-6">
            <label class="form-label">Local</label>
            <input type="text" name="local" class="form-control" required>
        </div>

        <!-- Professores convidados -->
        <div class="col-md-6">
            <label class="form-label">Professor Convidado 1</label>
            <select name="prof_convidado1_id" class="form-select" required>
                <option value="">-- Selecione --</option>
                <?php $professores->data_seek(0); while ($p = $professores->fetch_assoc()): ?>
                    <option value="<?= $p['id'] ?>"><?= $p['nome'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Professor Convidado 2</label>
            <select name="prof_convidado2_id" class="form-select" required>
                <option value="">-- Selecione --</option>
                <?php $professores->data_seek(0); while ($p = $professores->fetch_assoc()): ?>
                    <option value="<?= $p['id'] ?>"><?= $p['nome'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Nota e aprovado -->
        <div class="col-md-4">
            <label class="form-label">Nota Final</label>
            <input type="number" step="0.01" name="nota_final" class="form-control">
        </div>

        <div class="col-md-4">
            <label class="form-label">Aprovado?</label>
            <select name="aprovado" class="form-select" required>
                <option value="Sim">Sim</option>
                <option value="Não">Não</option>
            </select>
        </div>

        <!-- Cidade -->
        <div class="col-md-4">
            <label class="form-label">Cidade</label>
            <input type="text" name="cidade" class="form-control" required>
        </div>

        <!-- Botões -->
        <div class="col-12 d-flex justify-content-between">
            <a href="index.php" class="btn btn-dark">Cancelar</a>
            <button type="submit" name="salvar" class="btn btn-dark">Salvar Agenda</button>
        </div>
    </form>
    <?php endif; ?>
</div>
</body>
</html>