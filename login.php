<?php

session_start();

$email = $_SESSION['usuario'] ?? null;
$erro = $_GET['erro'] ?? '';
$novousuario = $_GET['novousuario'] ?? '';

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" href="img/logo_geek.png">
    <title>Login</title>
</head>
<body>
    <main>
        <?php if ($email): ?>

            <section class="section-logado">

                <div class="pergunta">
                    <h1>Você já esta logado como <?php echo htmlspecialchars($email); ?>!</h1>
                </div>

                <div class="botoes">

                    <a href="dashboardAdmin.php" class="botao-dashboard">Pagina Inicial</a>
                    <a href="logout.php" class="botao-sair">Encerrar Sessão</a>

                </div>
            </section>
            
        <?php else: ?>

            <section class="section-login">

                <h1>Login</h1>
                
                <?php if ($novousuario === 'true'): ?>
                    <p class="mensagem-ok">Usuário cadastrado!</p>
                <?php endif; ?>

                <?php if ($erro === 'credenciais'): ?>
                    <p class="mensagem-erro">Usuário ou senha incorretos.</p>
                <?php elseif ($erro === 'campos'): ?>
                    <p class="mensagem-erro">Preencha todos os campos.</p>
                <?php endif; ?>

                <form action="autenticar.php" method="post">

                    <input name="email" type="email" placeholder="Email">
                    <input name="senha" type="password" placeholder="Senha">

                    <a href="#">Esqueci minha senha</a>
                    <button type="submit">Entrar</button>

                </form>

            </section>

            <section class="section-cadastro">
                <h2>Bem-vindo</h2>
                <p>Registre-se para obter uma melhor experiência.</p>
                <a href="cadastro.php">Cadastrar</a>
            </section>

        <?php endif; ?>
    </main>

    <script>
        
        window.addEventListener('DOMContentLoaded', () => {
            
            const mensagens = document.querySelectorAll('.mensagem-erro, .mensagem-ok');

            mensagens.forEach(msg => {
                
                setTimeout(() => {
                
                msg.classList.add('oculto');
                msg.remove();

                }, 2500)

            });
        });
        
    </script>

</body>
</html>
