<?php
session_start();

$email = $_SESSION['usuario'] ?? null;
$erro = $_GET['erro'] ?? '';

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

            <section class="logado-section">
                <div class="pergunta">
                    <h1>Você já esta logado, <?php echo htmlspecialchars($email); ?>!</h1>
                </div>

                <div class="botoes">

                    <a href="dashboardAdmin.php" class="paginaInicial">Pagina Inicial</a>
                
                    <form action="logout.php" method="post">
                        <button type="submit" class="botaoSair">Sair</button>
                    </form>

                </div>
            </section>
            
        <?php else: ?>

            <section class="login-section">

                <h1>Login</h1>

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

            <section class="cadastro-section">
                <h2>Bem-vindo</h2>
                <p>Registre-se para obter uma melhor experiência.</p>
                <a href="cadastro.php">Cadastrar</a>
            </section>

        <?php endif; ?>
    </main>

    <script>
        
        window.addEventListener('DOMContentLoaded', () => {
            
            const mensagens = document.querySelectorAll('.mensagem-erro');

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
