<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/css/styles.css">

    <title>Supermecado Tchê</title>
</head>

<body>

    <section>

        <form method="POST" action="processa.php">
            <h1>Cadastro de Estoque</h1>
            <label for="nome">Nome do Produto:</label>
            <input type="text" name="nome" id="nome" required>

            <label for="preco">Preço (R$):</label>
            <input type="number" name="preco" id="preco" step="0.01" required>

            <label for="estoque">Quantidade em Estoque:</label>
            <input type="number" name="estoque" id="estoque" required>

            <button type="submit">Cadastrar</button>




            <?php


            session_start();

            if (!isset($_SESSION['produtos'])) {
                $_SESSION['produtos'] = [
                    "nomes" => [],
                    "precos" => [],
                    "estoques" => []
                ];
            }

            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $nome = $_POST["nome"] ?? "";
                $preco = (float) $_POST["preco"];
                $estoque = (int) $_POST["estoque"];

                if ($nome === "" || $preco < 0 ||  $estoque < 0) {
                    echo "<div class='container_resposta'>Favor preencher corretamente os campos!!";
                    exit;
                } else {
                    $_SESSION['produtos']['nomes'][] = $nome;
                    $_SESSION['produtos']['precos'][] = $preco;
                    $_SESSION['produtos']['estoques'][] = $estoque;
                }
            }


            echo "<div class='container_resposta'>";
            if (!empty($_SESSION['produtos'])) {

                echo "<h2>📦 Estoque de Produtos</h2>
                     <table>
                            <tr>
                                <th>Nome</th>
                                <th>Preço (R$)</th>
                                <th>Estoque</th>
                            </tr>";
                for ($i = 0; $i < count($_SESSION['produtos']['nomes']); $i++) {

                    echo "<tr><td>" . htmlspecialchars($_SESSION['produtos']['nomes'][$i]) . "</td>";
                    echo "<td>" . number_format($_SESSION['produtos']['precos'][$i], 2, ',', '.') . "</td>";
                    echo "<td>" . $_SESSION['produtos']['estoques'][$i] . "</td></tr>";
                }
                echo "</table></div>";
            }
            ?>
        </form>

    </section>
    </main>

</body>

</html>