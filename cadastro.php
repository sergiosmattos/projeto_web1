<?php

session_start();

$erro = $_GET['erro'] ?? '';

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/login.css">
    <title>Login</title>
</head>
<body>
    <main>
        <section class="login-section">
            <h1>Cadastre-se</h1>

            <form action="cadastroUsuario.php" method="post">

                <?php if($erro === 'campos'): ?>
                    <p class="mensagem-erro">Preencha todos os campos.</p>
                <?php endif ?>

                <input name="nome" type="text" placeholder="Nome">

                <input name="dataNascimento" type="date" placeholder="data da Nascimento. Ex: YYYY-mm-DD">

                <input name="email" type="email" placeholder="Email">

                <input name="senha" type="password" placeholder="Senha">
                
                <a href="#">Esqueci minha senha</a>

                <button type="submit">Entrar</button>
            </form>
        </section>

        <section class="cadastro-section">
            
            <h2>Bem-vindo</h2>
            <p>Caso já tenha um cadastro aperte em login</p>
            <a href="login.php">Login</a>

        </section>
        
    </main>

    <script>
        
        window.addEventListener('DOMContentLoaded', () => {
            
            const mensagens = document.querySelectorAll('.mensagem-erro, .mensagem-ok');

            mensagens.forEach(msg => {
                
                setTimeout(() => {

                    msg.classList.add('oculto');

                    msg.remove();

                }, 2500);

            });
        });
        
    </script>

</body>
</html>
