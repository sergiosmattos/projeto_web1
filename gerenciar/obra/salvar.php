<?php
    
    require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
    require DIR_PROJETOWEB . 'src/repositorio/ObraRepositorio.php';
    
    session_start();

    $obraRepositorio = new ObraRepositorio($pdo);

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        header('Location: listar.php');
        exit;
    }

    $id = $_POST['id'];

    $id = isset($id) && $id !== '' ? (int) $id : null;
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');

    if ($nome === '' || $descricao === '') {

        header('Location: form.php' . ($id ? '?id=' . $id . '&erro=campos' : '?erro=campos'));
        exit;
        
    }

    $obra = new Obra($id, $nome, $descricao);


    if ($id) {

        $existenteObra = $obraRepositorio->findById($id);

        if (!$existenteObra) {
            header('Location: listar.php?erro=inexistente');
            exit;
        }
        
        $obraRepositorio->atualizar($obra);
        header('Location: listar.php?ok=1');
        exit;

    }
    else {
            
        $obraRepositorio->cadastrar($obra);
        header('Location: listar.php?novo=1');
        exit;

    }
?>
