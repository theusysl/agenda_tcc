<?php
include 'db.php';

// busca o registro no banco com base no id passado por GET
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM agendas WHERE id=$id");
$row = $result->fetch_assoc();

// atualiza os dados se o formulário for enviado
if (isset($_POST['atualizar'])) {
    // atualiza todos os campos da agenda usando prepared statements
    $sql = "UPDATE agendas SET 
        data_hora=?, local=?, prof_orientador=?, prof_convidado1=?, prof_convidado2=?, 
        aluno1=?, aluno2=?, aluno3=?, nota_final=?, aprovado=?, curso=?, cidade=?
        WHERE id=?";

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
        <div class="col-md-6">
            <label class="form-label">Data e Hora</label>
            <input type="datetime-local" class="form-control" name="data_hora" value="<?= substr($row['data_hora'], 0, 16) ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Local</label>
            <input type="text" class="form-control" name="local" value="<?= $row['local'] ?>" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Prof. Orientador</label>
            <input type="text" class="form-control" name="prof_orientador" value="<?= $row['prof_orientador'] ?>">
        </div>
        <div class="col-md-4">
            <label class="form-label">Prof. Convidado 1</label>
            <input type="text" class="form-control" name="prof_convidado1" value="<?= $row['prof_convidado1'] ?>">
        </div>
        <div class="col-md-4">
            <label class="form-label">Prof. Convidado 2</label>
            <input type="text" class="form-control" name="prof_convidado2" value="<?= $row['prof_convidado2'] ?>">
        </div>
        <div class="col-md-4">
            <label class="form-label">Aluno 1</label>
            <input type="text" class="form-control" name="aluno1" value="<?= $row['aluno1'] ?>">
        </div>
        <div class="col-md-4">
            <label class="form-label">Aluno 2</label>
            <input type="text" class="form-control" name="aluno2" value="<?= $row['aluno2'] ?>">
        </div>
        <div class="col-md-4">
            <label class="form-label">Aluno 3</label>
            <input type="text" class="form-control" name="aluno3" value="<?= $row['aluno3'] ?>">
        </div>
        <div class="col-md-4">
            <label class="form-label">Nota Final</label>
            <input type="number" step="0.1" class="form-control" name="nota_final" value="<?= $row['nota_final'] ?>">
        </div>
        <div class="col-md-4">
            <label class="form-label">Aprovado</label>
            <select class="form-select" name="aprovado">
                <option <?= $row['aprovado'] == 'Sim' ? 'selected' : '' ?>>Sim</option>
                <option <?= $row['aprovado'] == 'Não' ? 'selected' : '' ?>>Não</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Curso</label>
            <input type="text" class="form-control" name="curso" value="<?= $row['curso'] ?>">
        </div>
        <div class="col-md-12">
            <label class="form-label">Cidade</label>
            <input type="text" class="form-control" name="cidade" value="<?= $row['cidade'] ?>">
        </div>
        <div class="col-12 d-flex justify-content-between">
            <a href="index.php" class="btn btn-dark">Voltar</a>
            <button type="submit" name="atualizar" class="btn btn-dark">Atualizar</button>
        </div>
    </form>
</div>

</body>
</html>
