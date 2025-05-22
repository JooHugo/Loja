<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Adicionar Cliente</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <h2>Adicionar Cliente</h2>
    <form method="POST" action="adicionar.php">
        CPF: <input type="text" name="cpfcli" maxlength="20" placeholder="Digite o CPF" required>
        <br/><br/>
        Nome do Cliente: <input type="text" name="nomecli" maxlength="50" placeholder="Digite o nome" required>
        <br/><br/>    
        <input type="submit" value="Salvar" name="botao">
    </form>

    <?php 
    if(isset($_POST["botao"])) {
        require("conecta.php");

        // Captura e sanitiza os dados
        $cpfcli = trim($_POST["cpfcli"]);
        $nomecli = trim($_POST["nomecli"]);

        // Verificação básica para evitar entrada vazia
        if (empty($cpfcli) || empty($nomecli)) {
            echo "<p style='color:red;'>Erro: Preencha todos os campos!</p>";
        } else {
            // Usando Prepared Statements para evitar SQL Injection
            $stmt = $mysqli->prepare("INSERT INTO tb_clientes (cpfcli, nomecli) VALUES (?, ?)");
            $stmt->bind_param("ss", $cpfcli, $nomecli);
            $stmt->execute();

            if ($stmt->error) {
                echo "<p style='color:red;'>Erro ao inserir: " . $stmt->error . "</p>";
            } else {
                echo "<p style='color:green;'>Inserido com sucesso!</p>";
                echo "<a href='index.php'>Voltar</a>";
            }

            // Fecha a consulta preparada
            $stmt->close();
        }

        // Fecha a conexão com o banco
        $mysqli->close();
    }
    ?>
</body>
</html>