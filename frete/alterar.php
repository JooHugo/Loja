<?php 
require("conecta.php");

$cpfcli = "";
$nomecli = "";

// Verifica se o ID foi passado na URL e é válido
if (isset($_GET["alterar"])) {
    $idcli = filter_var($_GET["alterar"], FILTER_VALIDATE_INT);

    if ($idcli === false || $idcli <= 0) {
        exit("<p style='color:red;'>Erro: ID inválido!</p>");
    }

    // Usa Prepared Statements para evitar SQL Injection
    $stmt = $mysqli->prepare("SELECT cpfcli, nomecli FROM tb_clientes WHERE idcli = ?");
    $stmt->bind_param("i", $idcli);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $tabela = $result->fetch_assoc();
        $cpfcli = htmlspecialchars($tabela["cpfcli"]);
        $nomecli = htmlspecialchars($tabela["nomecli"]);
    } else {
        exit("<p style='color:red;'>Erro: Cliente não encontrado!</p>");
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Alterar Cliente</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <h2>Alterar Cliente</h2>
    <form method="POST" action="alterar.php">
        <input type="hidden" name="idcli" value="<?php echo $idcli ?>">
        CPF: <input type="text" name="cpfcli" value="<?php echo $cpfcli ?>" required>
        <br/><br/>            
        Nome: <input type="text" name="nomecli" value="<?php echo $nomecli ?>" required>
        <br/><br/>
        <input type="submit" value="Salvar" name="botao">
    </form>

    <br>
    <a href="index.php">Voltar</a>
</body>
</html>

<?php 
if (isset($_POST["botao"])) {
    // Captura e valida os dados do formulário
    $idcli   = filter_var($_POST["idcli"], FILTER_VALIDATE_INT);
    $cpfcli  = trim($_POST["cpfcli"]);
    $nomecli = trim($_POST["nomecli"]);

    if ($idcli === false || empty($cpfcli) || empty($nomecli)) {
        exit("<p style='color:red;'>Erro: Preencha todos os campos corretamente.</p>");
    }

    // Usa Prepared Statements para evitar SQL Injection
    $stmt = $mysqli->prepare("UPDATE tb_clientes SET cpfcli = ?, nomecli = ? WHERE idcli = ?");
    $stmt->bind_param("ssi", $cpfcli, $nomecli, $idcli);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<p style='color:green;'>Alterado com sucesso!</p>";
    } else {
        echo "<p style='color:blue;'>Nenhuma alteração realizada.</p>";
    }

    $stmt->close();
    $mysqli->close();
}
?>