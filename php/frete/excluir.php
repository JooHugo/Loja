<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Excluir Cliente</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <?php 
    // Verifica se o parâmetro foi passado na URL
    if(isset($_GET["excluir"])) {
        require("conecta.php");

        // Captura e valida o ID
        $idcli = filter_var($_GET["excluir"], FILTER_VALIDATE_INT);

        if ($idcli === false || $idcli <= 0) {
            echo "<p style='color:red;'>Erro: ID inválido!</p>";
        } else {
            // Utiliza Prepared Statement para evitar SQL Injection
            $stmt = $mysqli->prepare("DELETE FROM tb_clientes WHERE idcli = ?");
            $stmt->bind_param("i", $idcli);
            $stmt->execute();

            // Verifica se alguma linha foi afetada (ou seja, se o ID existia)
            if ($stmt->affected_rows > 0) {
                echo "<p style='color:green;'>Excluído com sucesso!</p>";
            } else {
                echo "<p style='color:blue;'>Nenhum cliente encontrado com esse ID.</p>";
            }

            // Fecha o statement e a conexão
            $stmt->close();
            $mysqli->close();
        }
    } else {
        echo "<p style='color:red;'>Erro: Nenhum ID informado.</p>";
    }
    ?>
    <br>
    <a href='index.php'>Voltar</a>
</body>
</html>