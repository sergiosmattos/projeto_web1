<?php

session_start();

$erro = $_GET['erro'] ?? '';

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo_geek.png">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/acesso.css">
    <title>Cadastro</title>
</head>
<body>
    <main>
        <section class="section-login">
            <h1>Cadastre-se</h1>

            <form action="cadastroUsuario.php" method="post" autocomplete="off">

                <?php if($erro === 'campos'): ?>
                    <p class="mensagem-erro">Preencha todos os campos.</p>
                <?php endif ?>

                <input name="nome" type="text" placeholder="Nome">
                <input name="dataNascimento" type="date">
                <input name="email" type="email" placeholder="Email">
                <input name="senha" type="password" placeholder="Senha">
                <input type="hidden" name="saldo" value="0">
                
                <a href="#">Esqueci minha senha</a>

                <button type="submit">Entrar</button>
            </form>
        </section>

        <section class="section-cadastro">
            
            <h2>Bem-vindo</h2>
            <p>Caso já tenha um cadastro aperte em login</p>
            <a href="login.php">Login</a>

        </section>
        
    </main>

    <script src="js/form.js"></script>

</body>
</html>
