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
        Nome Completo: <input type="text" name="nome"
         maxlength="50" placeholder="Digite seu nome completo" required>
        <br/><br/>
        Usuário: <input type="text" name="usuario"
         maxlength="20" placeholder="Digite seu nome de usuário" required>
        <br/><br/>
        Email: <input type="email" name="email"
         maxlength="50" placeholder="Digite seu email" required>
        <br/><br/>
        fone: <input type="text" name="fone"
         maxlength="15" placeholder="Digite seu fone" required>
        <br/><br/>
        CPF: <input type="text" name="cpf"
         maxlength="15" placeholder="Digite seu CPF" required>
        <br/><br/>
        Cidade: <input type="text" name="cidade"
         maxlength="60" placeholder="Digite sua cidade" required>
        <br/><br/>
        Endereço: <input type="text" name="endereco"
         maxlength="100" placeholder="Digite seu endereço" required>
        <br/><br/>
        CEP: <input type="text" name="cep"
         maxlength="10" placeholder="Digite seu CEP" required>
        <br/><br/>
        <input type="submit" value="Salvar" name="botao">
    </form>

    <?php 
    if(isset($_POST["botao"])) {
        require("conecta.php");

        // Captura e sanitiza os dados
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
        $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $fone = filter_input(INPUT_POST, 'fone', FILTER_SANITIZE_STRING);
        $cpfcli = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_NUMBER_INT);
        $cidade = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING);
        $endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING);
        $cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING);

        // Verificação básica para evitar entrada vazia
        if (empty($nome) || empty($usuario) || empty($email) || empty($fone) || empty($cpfcli) || empty($cidade) || empty($endereco) || empty($cep)) {
            echo "<p style='color:red;'>Erro: Preencha todos os campos!</p>";
        } else {
            // Usando Prepared Statements para evitar SQL Injection
            $stmt = $mysqli->prepare("INSERT INTO tb_clientes (nome, usuario, email, fone, cpf, cidade, endereco, cep) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $nome, $usuario, $email, $fone, $cpfcli, $cidade, $endereco, $cep);
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