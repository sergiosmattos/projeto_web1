<?php
    
    require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
    require DIR_PROJETOWEB . 'src/repositorio/ObraRepositorio.php';
    
    session_start();

    $obraRepositorio = new ObraRepositorio($pdo);

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        header('Location: listar.php');
        exit;
    }

    $id = $_POST['id'] ?? '';

    $id = $id !== '' ? (int) $id : null;
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');

    var_dump($_POST);

    if ($nome === '' || $descricao === '') {

        header('Location: form.php' . ($id ? '?id=' . $id . '&erro=campos' : '?erro=campos'));
        exit;
        
    }

    $obra = new Obra($id, $nome, $descricao);


    if ($id) {

        $objetoExistente = $obraRepositorio->findById($id);

        if (!$objetoExistente) {
            header('Location: listar.php?erro=inexistente');
            exit;
        }
        
        $obraRepositorio->atualizar($obra);
        header('Location: listar.php?editadoregistro=true');
        exit;

    }
    else {
            
        $obraRepositorio->cadastrar($obra);
        header('Location: listar.php?novoregistro=true');
        exit;

    }
?>
