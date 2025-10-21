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
            <input type="text" name="nome" id="nome" />

            <label for="preco">Preço (R$):</label>
            <input type="number" name="preco" id="preco"/>

            <label for="estoque">Quantidade em Estoque:</label>
            <input type="number" name="estoque" id="estoque" />

            <button type="submit">Cadastrar</button>
        </form>

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
        function excluirProduto($indice)
        {
            if (isset($_SESSION['produtos']['nomes'][$indice])) {
                // remover / cortar , um elemento a partir do indice 
                array_splice($_SESSION['produtos']['nomes'], $indice, 1);
                array_splice($_SESSION['produtos']['precos'], $indice, 1);
                array_splice($_SESSION['produtos']['estoques'], $indice, 1);
                return true;
            }
            return false;
        }

        // Verifica se é POST para tratar dados
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $acao = $_POST['excluir'] ?? "";

            if ($acao >= 0) {
                // Excluir produto
                if (excluirProduto($acao)) {
                    echo "<p>Produto excluído com sucesso!</p>";
                } else {
                    echo "<p>Erro: Produto não encontrado.</p>";
                }
            } 
            else {

                $nome = trim($_POST["nome"]) ?? "";
                $preco = $_POST["preco"] ?? "";
                $estoque = $_POST["estoque"] ?? "";

                // Validação
                if ($nome === "" || !is_numeric($preco) || !is_numeric($estoque)) {
                    echo "<p>Preencha todos os campos corretamente!</p>";
                } else {
                    
                    $preco = (float)$preco;
                    $estoque = (int)$estoque;

                    if ($preco <= 0 || $estoque <= 0) {
                        echo "<p>Preço e estoque devem ser maiores que zero!</p>";
                    } else {
                        $_SESSION['produtos']['nomes'][] = $nome;
                        $_SESSION['produtos']['precos'][] = $preco;
                        $_SESSION['produtos']['estoques'][] = $estoque;
                        echo "<p>Produto cadastrado com sucesso!</p>";
                    }
                }
            }

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
                        <form method='POST'>
                        <button type='submit' name='excluir' value='$i'>Excluir</button>
                        </form>

                    </td>";
                    echo "</tr>";
                }
                echo "</table></div>";
            }
        }
        ?>
    </section>
</body>

</html>