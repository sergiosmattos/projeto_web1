<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
    require DIR_PROJETOWEB . 'src/repositorio/UsuarioRepositorio.php';

    include_once(DIR_PROJETOWEB."/reutilizar/verify-logged.php");

    $usuarioRepositorio = new UsuarioRepositorio($pdo);
    $usuario = $usuarioRepositorio->findByEmail($emailUsuario);

    $dataFormatada = $usuario->getDataNascimento()->format('Y-m-d');

    $confirmacao = $_GET['confirmacao'] ?? '';
    $erro = $_GET['erro'] ?? '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="/projeto_web1/img/logo_geek.png">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/mensagem.css">
    <link rel="stylesheet" href="css/perfil.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <?php include_once DIR_PROJETOWEB . '/reutilizar/header.php' ?>

    <main>

        <div class="container-troca">

            <h2>Peça um saldo</h2>

            <?php if($confirmacao == 'true'):?>
                <p class="mensagem-ok">Saldo Liberado!</p>
            <?php elseif($confirmacao == 'false'):?>
                <p class="mensagem-erro">Saldo Recusado.</p>
            <?php endif;?>

            <?php if($erro == 'campos'):?>
                <p class="mensagem-erro">Digite um saldo!</p>
            <?php endif;?>

            <form method="post" action="/projeto_web1/autenticarSaldo.php" class="form-saldo">
                
                <div class="campo">
                    <label>Saldo Atual</label>
                    <input type="text" name="saldo_atual_aparente" value="R$ <?= number_format($usuario->getSaldo(), 2, ",", ".")?>">
                
                    <input type="hidden" name="saldo_atual" id="saldoAtual" value="<?= htmlspecialchars($usuario->getSaldo()) ?>">
                </div>
                
                <div class="campo">

                    <label for="saldoPedido">Saldo Desejado</label>
                    <input type="number" name="saldo_pedido" id="saldoPedido" min="0.01" step="0.01" value="">

                </div>

                <input type="submit" value="Pedir Saldo" class="botao-trocar-perfil">

            </form>

        </div>

    </main>

    <script src="js/form.js"></script>
    
</body>
</html>