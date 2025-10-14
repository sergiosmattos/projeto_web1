<?php

    require __DIR__ . '/src/repositorio/ObraRepositorio.php';

    session_start();

    $emailUsuario = $_SESSION['usuario'] ?? null;

    if (!isset($emailUsuario)) {
        header('Location: /projeto_web1/login.php');
        exit;
    }

    $tipoUsuario = $_SESSION['tipo'] ?? 'User';

    if ($tipoUsuario !== 'Admin') {
        header('Location: /projeto_web1/dashboardUsuario.php');
        exit;
    }

    $obraRepositorio = new ObraRepositorio($pdo);


    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $id = isset($_POST['id']) && $_POST['id'] !== '' ? (int)$_POST['id'] : null;
        $nome = trim($_POST['nome'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');

        if ($nome === '' || $descricao === '') {

            header('Location: form.php' . ($id ? '?id=' . $id . '&erro=campos' : '?erro=campos'));
            exit;
            
        }

        if ($id) {

            $existenteObra = $obraRepositorio->findById($id);

            if (!$existenteObra) {
                header('Location: listar.php?erro=inexistente');
                exit;
            }

            $obra = new Obra($id, $nome, $descricao);
            $obraRepositorio->atualizar($obra);
            header('Location: listar.php?ok=1');
            exit;

        }
         else {
            $obra = new Obra(null, $nome, $descricao);
            $obraRepositorio->cadastrar($obra);
            header('Location: listar.php?novo=1');
            exit;
        }
    } else {
        header('Location: listar.php');
        exit;
    }
?>
