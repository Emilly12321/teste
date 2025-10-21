<?php
session_start();

// Inicializa o array produtos na sessão
if (!isset($_SESSION['produtos'])) {
    $_SESSION['produtos'] = [
        "nomes" => [],
        "precos" => [],
        "estoques" => []
    ];
}

// Função para excluir produto pelo índice
function excluirProduto($indice) {
    if (isset($_SESSION['produtos']['nomes'][$indice])) {
        array_splice($_SESSION['produtos']['nomes'], $indice, 1);
        array_splice($_SESSION['produtos']['precos'], $indice, 1);
        array_splice($_SESSION['produtos']['estoques'], $indice, 1);
        return true;
    }
    return false;
}

// Verifica se é POST para tratar dados
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST['acao']) && $_POST['acao'] === 'excluir') {
        // Excluir produto
        $indice = intval($_POST['indice']);
        if (excluirProduto($indice)) {
            echo "Produto excluído com sucesso!";
        } else {
            echo "Erro: Produto não encontrado.";
        }
        
    } else {
        // Inserir novo produto
        $nome = $_POST["nome"] ?? "";
        $preco = (float) $_POST["preco"];
        $estoque = (int) $_POST["estoque"];

        if ($nome === "" || $preco < 0 ||  $estoque < 0) {
            echo "<div class='container_resposta'>Favor preencher corretamente os campos!!</div>";
        } else {
            $_SESSION['produtos']['nomes'][] = $nome;
            $_SESSION['produtos']['precos'][] = $preco;
            $_SESSION['produtos']['estoques'][] = $estoque;
            echo "<div class='container_resposta'>Produto cadastrado com sucesso!</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="src/css/styles.css" />
    <title>Supermecado Tchê</title>
</head>

<body>
    <section>
        <form method="POST" class="formulario">
            <h1>Cadastro de Estoque</h1>
            <label for="nome">Nome do Produto:</label>
            <input type="text" name="nome" id="nome" required />

            <label for="preco">Preço (R$):</label>
            <input type="number" name="preco" id="preco" step="0.01" required />

            <label for="estoque">Quantidade em Estoque:</label>
            <input type="number" name="estoque" id="estoque" required />

            <button type="submit">Cadastrar</button>
        </form>

        <?php
        // Exibe tabela com produtos e botão de excluir
        if (!empty($_SESSION['produtos']['nomes'])) {
            echo "<div class='container_resposta'>";
            echo "<h2>📦 Estoque de Produtos</h2>";
            echo "<table>
                    <tr>
                        <th>Nome</th>
                        <th>Preço (R$)</th>
                        <th>Estoque</th>
                        <th>Ações</th>
                    </tr>";

            for ($i = 0; $i < count($_SESSION['produtos']['nomes']); $i++) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($_SESSION['produtos']['nomes'][$i]) . "</td>";
                echo "<td>" . number_format($_SESSION['produtos']['precos'][$i], 2, ',', '.') . "</td>";
                echo "<td>" . $_SESSION['produtos']['estoques'][$i] . "</td>";
                // Botão para excluir o produto
                echo "<td>
                        <form method='POST' style='margin:0;'>
                            <input type='hidden' name='acao' value='excluir'>
                            <input type='hidden' name='indice' value='$i'>
                            <button type='submit'>Excluir</button>
                        </form>
                    </td>";
                echo "</tr>";
            }
            echo "</table></div>";
        }
        ?>
    </section>
</body>

</html>
