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

    $usuarioRepositorio = new UsuarioRepositorio($pdo);

    $erro = $_GET['erro'] ?? '';

    $userIdPost = isset($_POST['id']) ? (int) $_POST['id'] : null;
    $userIdSession = $usuarioRepositorio->findByEmail($emailUsuario)->getId();

    $modoEdicao = $userIdPost ? true : false;

    $usuario = $modoEdicao ? $usuarioRepositorio->findById($userIdPost) : null;

    $valorNome = $modoEdicao ? $usuario->getNome() : '';
    $valorTipo = $modoEdicao ? $usuario->getTipo() : '';
    $valorEmail = $modoEdicao ? $usuario->getEmail() : '';
    $valorDataNascimento = $modoEdicao ? $usuario->getDataNascimento()->format('Y-m-d') : '';
    $valorSenha = $modoEdicao ? $usuario->getSenha() : '';

    $textoTitulo = $modoEdicao ? 'Editar Usuário' : 'Cadastrar Usuário';
    $textoBotao = $modoEdicao ? 'Editar' : 'Cadastrar';

    $lockOwnTipo = $userIdPost === $userIdSession;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/projeto_web1/img/logo_geek.png">
    <link rel="stylesheet" href="/projeto_web1/css/reset.css">
    <link rel="stylesheet" href="/projeto_web1/css/dashboard.css">
    <link rel="stylesheet" href="/projeto_web1/css/form.css">
    <title>Gerenciar Obras</title>
</head>

<body>
    
    <?php include_once DIR_PROJETOWEB . 'reutilizar/header.php' ?>

    <?php include_once DIR_PROJETOWEB . 'reutilizar/asidemenu.php' ?>

    <section class="all-form">

        <h2><?= $textoTitulo ?></h2>

        <div class="form-wrapper">

            <form action="salvar.php" method="POST" class="form-cadastro" autocomplete="off">

                <?php if ($erro === 'campos'): ?>
                    <p class="mensagem-erro">Preencha todos os campos!</p>
                <?php endif; ?>

                <input name="id" type="hidden" value=<?= $userIdPost ?>>

                <div class="grupo-input">

                    <div>
                        <label>Nome</label>
                        <input name="nome" type="text" value="<?= $valorNome?>">
                    </div>

                    <div>
                        <label>Tipo de Usuário</label>

                        <select name="tipo" <?php if($lockOwnTipo){echo "disabled";}?>>

                            <option <?php if ($valorTipo == 'User') {echo "selected";}?> value="User">Usuário</option>
                            <option <?php if ($valorTipo == 'Admin') {echo "selected";}?> value="Admin">Administrador</option>
                        
                        </select>
                    </div>

                    <div>
                        <label>Email</label>
                        <input name="email" type="email" value="<?= $valorEmail?>">
                    </div>

                    <div>
                        <label>Data de Nascimento</label>
                        <input name="dataNascimento" type="date" value="<?= $valorDataNascimento?>">
                    </div>

                    <div>
                        <label>Senha</label>
                        <input name="senha" type="text" value="<?= $valorSenha?>">
                    </div>

                </div>
                
                <div class="grupo-botoes">
                    <button type="submit" class="botao-executar"><?= $textoBotao ?></button>
                    <a href="listar.php" class="botao-voltar">Voltar</a>
                </div>

            </form>
        </div>

    </section>

    <script src="/projeto_web1/js/form.js"></script>

</body>
</html>
