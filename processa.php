<?php


session_start();

if (!isset($_SESSION['produtos'])) {
    $_SESSION['produtos'] = [
        "nomes" => [],
        "precos" => [],
        "estoques" => []
    ];
}


function voltar()
{
    echo "<a href='index.html'>Cadastrar mais</a></div>";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome"] ?? "";
    $preco = (float) $_POST["preco"];
    $estoque = (int) $_POST["estoque"];

    if ($nome === "" || $preco < 0 ||  $estoque < 0) {
        echo "<div class='container_resposta'>Favor preencher corretamente os campos!!";
        voltar();
        exit;
    } else {
        $_SESSION['produtos']['nomes'][] = $nome;
        $_SESSION['produtos']['precos'][] = $preco;
        $_SESSION['produtos']['estoques'][] = $estoque;
    }
}




?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/css/styles.css">

    <title>Supermecado Tchê</title>
</head>

<body>
    <header>

        <div>
            <h1>Supermercado Tchê</h1>
        </div>

    </header>
    <main>

        <section>


            <?php



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
                echo "</table>";
                echo voltar();
            }
            ?>

        </section>
    </main>

</body>

</html>