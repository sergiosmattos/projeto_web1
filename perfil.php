<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
    require DIR_PROJETOWEB . 'src/repositorio/UsuarioRepositorio.php';

    session_start();

    $emailUsuario = $_SESSION['usuario'] ?? null;
    $confirmacao = $_GET['editadoregistro'] ?? false;

    if (!isset($emailUsuario)) {
        header('Location: login.php');
        exit;
    }

    $tipoUsuario = $_SESSION['tipo'] ?? 'User';

    if( $tipoUsuario !== 'Admin' ) {
        header('Location: dashboardUsuario.php');
        exit;
    }

    $usuarioRepositorio = new UsuarioRepositorio($pdo);
    $usuario = $usuarioRepositorio->findByEmail($emailUsuario);

    $dataFormatada = $usuario->getDataNascimento()->format('Y-m-d');
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
        <h2>Seu perfil</h2>

        <div class="foto-perfil">
            <div class="avatar"></div>
            <form action="#" method="post">
                <input type="file" name="foto" id="foto" hidden>
                <label for="foto" class="botao-editar">Editar</label>
            </form>
        </div>

        <div class="info-perfil">

            <?php if($confirmacao === 'true'): ?>
                <p class="mensagem-ok">Dado alterado!</p>
            <?php endif ?>
            
            <div class="campo">
                <label>Nome</label>
                <form action="alterarUsuarioPerfil.php" method="post">
                    <input type="text" name="nome" value="<?= htmlspecialchars($usuario->getNome()) ?>">
                    <button type="submit" class="botao-editar">ALTERAR</button>
                </form>
            </div>

            <div class="campo">
                <label>E-mail</label>
                <form action="alterarUsuarioPerfil.php" method="post">
                    <input type="email" name="email" value="<?= htmlspecialchars($usuario->getEmail()) ?>">
                    <button type="submit" class="botao-editar">ALTERAR</button>
                </form>
            </div>

            <div class="campo">
                <label>Senha</label>
                <form action="alterarUsuarioPerfil.php" method="post">
                    <input type=" password" name="senha" value="<?= htmlspecialchars($usuario->getSenha())?>">
                    <button type="submit" class="botao-editar">ALTERAR</button>
                </form>
            </div>

            <div class="campo">
                <label>Data de Nascimento</label>
                <form action="alterarUsuarioPerfil.php" method="post">
                    <input type="date" name="dataNascimento" value="<?= $dataFormatada ?>">
                    <button type="submit" class="botao-editar">ALTERAR</button>
                </form>
            </div>

        </div>

        <form action="logout.php" method="post">
            <button type="submit" class="botao-sair-perfil">SAIR</button>
        </form>
    </main>

    <script src="js/form.js"></script>
    
</body>
</html>