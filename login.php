<?php
session_start();
$usuarioLogado = $_SESSION['usuario'] ?? null;
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
        <?php if ($usuarioLogado): ?>

            <section class="logado-section">
                <h1>Bem-vindo, <?php echo htmlspecialchars($usuarioLogado); ?>!</h1>
                <a href="dashboard.php">Ir para o painel</a>

                <form action="dashboard.php" method="post">
                    <button type="submit">Sair</button>
                </form>
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

                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="senha" placeholder="Senha" required>

                    <a href="#">Esqueci minha senha</a>
                    <button type="submit">Entrar</button>

                </form>

            </section>

            <section class="cadastro-section">
                <h2>Bem-vindo</h2>
                <p>Registre-se para obter uma melhor experiência.</p>
                <a href="cadastro.html">Cadastre-se</a>
            </section>
        <?php endif; ?>
    </main>
</body>
</html>
