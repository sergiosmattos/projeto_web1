<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
    require DIR_PROJETOWEB . 'src/repositorio/UsuarioRepositorio.php';

    session_start();

    $emailUsuario = $_SESSION['usuario'] ?? null;

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="/projeto_web1/img/logo_geek.png">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <?php include_once 'header.php' ?>

    <main>
        <h2><?= htmlspecialchars($usuario->getNome()) ?></h2>


        <div class="foto-perfil">
            <div class="avatar"></div>
            <form action="#" method="post">
                <input type="file" name="foto" id="foto" hidden>
                <label for="foto" class="botao-editar">Editar</label>
            </form>
        </div>

        <div class="info-perfil">

            
            <div class="campo">
                <form action="#" method="post">
                    <label>Nome</label>
                    <input type="text" name="nome" value="<?= htmlspecialchars($usuario->getNome()) ?>">
                    <button type="submit" class="botao-editar">ALTERAR</button>
                </form>
            </div>

            <div class="campo">
                <form action="#" method="post">
                    <label>E-mail</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($usuario->getEmail()) ?>">
                    <button type="submit" class="botao-editar">ALTERAR</button>
                </form>
            </div>

            <div class="campo">
                <form action="#" method="post">
                    <label>Senha</label>
                    <input type=" password" name="campo" value="<?= htmlspecialchars($usuario->getSenha())?>">
                    <button type="submit" class="botao-editar">ALTERAR</button>
                </form>
            </div>

            <div class="campo">
                <form action="#" method="post">
                    <label>Data de Nascimento</label>
                    <input type="datetime" name="dataNascimnto" value="<?= htmlspecialchars($usuario->getDataNascimento())?>">
                    <button type="submit" class="botao-editar">ALTERAR</button>
                </form>
            </div>

        </div>
    </main>
</body>
</html>