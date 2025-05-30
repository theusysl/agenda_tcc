<?php
include 'db.php';

// busca o registro no banco com base no id passado por GET
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM agendas WHERE id=$id");
$row = $result->fetch_assoc();

// atualiza os dados se o formulário for enviado
if (isset($_POST['atualizar'])) {
    // atualiza todos os campos da agenda usando statements preparados
    $sql = "UPDATE agendas SET
        INSERT INTO agendas (
            data_hora=?,
            local=?,
            prof_orientador_id=?,
            prof_convidado1_id=?,
            prof_convidado2_id=?,
            aluno1_ra=?,
            aluno2_ra=?,
            aluno3_ra=?,
            nota_final=?,
            aprovado=?,
            curso=?,
            cidade=?
        ) VALUES id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssssssssdsssi",
        $_POST['data_hora'], $_POST['local'], $_POST['prof_orientador'],
        $_POST['prof_convidado1'], $_POST['prof_convidado2'],
        $_POST['aluno1'], $_POST['aluno2'], $_POST['aluno3'],
        $_POST['nota_final'], $_POST['aprovado'],
        $_POST['curso'], $_POST['cidade'],
        $id
    );

    // executa e mostra mensagem
    if ($stmt->execute()) {
        echo "<div class='alert alert-success mt-4'>Agenda atualizada com sucesso! <a href='index.php'>Voltar</a></div>";
    } else {
        echo "<div class='alert alert-danger mt-4'>Erro: " . $stmt->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Agenda</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Editar Agenda de TCC</h2>

    <form method="post" class="row g-3">

        <!--data e hora-->
        <div class="col-md-6">
            <label class="form-label">Data e Hora</label>
            <input type="datetime-local" class="form-control" name="data_hora" value="<?= substr($row['data_hora'], 0, 16) ?>" required>
        </div>

        <!--local-->
        <div class="col-md-6">
            <label class="form-label">Local</label>
            <input type="text" class="form-control" name="local" value="<?= $row['local'] ?>" required>
        </div>

        <!--professor orientador-->
        <div class="col-md-4">
            <label class="form-label">Prof. Orientador</label>
            <select name="prof_orientador_id" class="form-select">
                <?php $professores->data_seek(0); while($p = $professores->fetch_assoc()): ?>
                    <option value="<?= $p['id'] ?>" <?= $p['id'] == $row['prof_orientador_id'] ? 'selected' : '' ?>>
                        <?= $p['nome'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!--professor convidado 1-->
        <div class="col-md-4">
            <label class="form-label">Prof. Convidado 1</label>
            <select name="prof_convidado1" class="form-select">
                <?php $professores->data_seek(0); while($p = $professores->fetch_assoc()): ?>
                    <option value="<?= $p['id'] ?>" <?= $p['id'] == $row['prof_convidado1'] ? 'selected' : '' ?>>
                        <?= $p['nome'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!--professor convidado 2-->
        <div class="col-md-4">
            <label class="form-label">Prof. Convidado 2</label>
            <select name="prof_convidado2" class="form-select">
                <?php $professores->data_seek(0); while($p = $professores->fetch_assoc()): ?>
                    <option value="<?= $p['id'] ?>" <?= $p['id'] == $row['prof_convidado2'] ? 'selected' : '' ?>>
                        <?= $p['nome'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!--aluno 1-->
        <div class="col-md-4">
            <label class="form-label">Aluno 1</label>
            <select name="aluno1" class="form-select">
                <?php $alunos->data_seek(0); while($a = $alunos->fetch_assoc()): ?>
                    <option value="<?= $a['id'] ?>" <?= $a['id'] == $row['aluno1'] ? 'selected' : '' ?>>
                        <?= $a['nome'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!--aluno 2-->
        <div class="col-md-4">
            <label class="form-label">Aluno 2</label>
            <select name="aluno2" class="form-select">
                <?php $alunos->data_seek(0); while($a = $alunos->fetch_assoc()): ?>
                    <option value="<?= $a['id'] ?>" <?= $a['id'] == $row['aluno2'] ? 'selected' : '' ?>>
                        <?= $a['nome'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!--aluno 3-->
        <div class="col-md-4">
            <label class="form-label">Aluno 3</label>
            <select name="aluno3" class="form-select">
                <?php $alunos->data_seek(0); while($a = $alunos->fetch_assoc()): ?>
                    <option value="<?= $a['id'] ?>" <?= $a['id'] == $row['aluno3'] ? 'selected' : '' ?>>
                        <?= $a['nome'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!--nota final-->
        <div class="col-md-4">
            <label class="form-label">Nota Final</label>
            <input type="number" step="0.1" class="form-control" name="nota_final" value="<?= $row['nota_final'] ?>">
        </div>

        <!--Aprovado-->
        <div class="col-md-4">
            <label class="form-label">Aprovado</label>
            <select class="form-select" name="aprovado">
                <option value="Sim" <?= $row['aprovado'] == 'Sim' ? 'selected' : '' ?>>Sim</option>
                <option value="Não" <?= $row['aprovado'] == 'Não' ? 'selected' : '' ?>>Não</option>
            </select>
        </div>

        <!--curso-->
        <div class="col-md-4">
            <label class="form-label">Curso</label>
            <input type="text" class="form-control" name="curso" value="<?= $row['curso'] ?>">
        </div>

        <!--cidade-->
        <div class="col-md-12">
            <label class="form-label">Cidade</label>
            <input type="text" class="form-control" name="cidade" value="<?= $row['cidade'] ?>">
        </div>

        <!--botoes voltar e atualizar-->
        <div class="col-12 d-flex justify-content-between">
            <a href="index.php" class="btn btn-dark">Voltar</a>
            <button type="submit" name="atualizar" class="btn btn-dark">Atualizar</button>
        </div>

    </form>

</div>

</body>
</html>
