<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Cadastro de Clientes</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <h2>Cadastro de Clientes</h2>
        <a href="adicionar.php"><button>Adicionar</button></a>
        <a href="pesquisar.php"><button>Pesquisar</button></a>
        <br />
        <table border="1" width="600">
            <tr>
                <th>Id</th>
                <th>Nome Produto</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Estoque</th>
                <th>Categoria</th>
            </tr>
            
    </table>
</body>
</html>
<?php 
            // Conexão com o banco de dados
            require 1= ("conecta.php");

            // Configurar charset para evitar problemas com acentos
            $mysqli -> set_charset("utf8");

            // Executar consulta SQL
            $query = $mysqli->query("SELECT * FROM tb_clientes");
            if (!$query) {
                die("Erro na consulta: " . $mysqli->error);
            }

            // Carregar consulta de registros
            while ($tabela = $query->fetch_assoc()) {
                echo "
                <tr>
                    <td align='center'>{$tabela['idcli']}</td>
                    <td align='center'>{$tabela['cpfcli']}</td>
                    <td align='center'>{$tabela['nomecli']}</td>
                    <td width='120'>
                        <a href='excluir.php?excluir={$tabela['idcli']}'>excluir</a>
                        <a href='alterar.php?alterar={$tabela['idcli']}'>alterar</a>
                    </td>
                </tr>";
            }
?>