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

        <h2>Peça um saldo</h2>
            
        <div class="campo">

            <label>Valor</label>
            <form action="alterarUsuarioPerfil.php" method="post">
                <input type="text" name="nome" value="<?= htmlspecialchars($usuario->getNome()) ?>">
                <button type="submit" class="botao-editar">ALTERAR</button>
            </form>

        </div>

    </main>

    <script src="js/form.js"></script>
    
</body>
</html>