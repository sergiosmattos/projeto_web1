<?php
    
    require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
    require DIR_PROJETOWEB . 'src/repositorio/CategoriaRepositorio.php';
    
    session_start();

    $categoriaRepositorio = new CategoriaRepositorio($pdo);

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        header('Location: listar.php');
        exit;
    }

    $id = $_POST['id'] ?? '';

    $id = $id !== '' ? (int) $id : null;
    $nome = trim($_POST['nome'] ?? '');

    var_dump($_POST);

    if ($nome === '') {

        header('Location: form.php' . ($id ? '?id=' . $id . '&erro=campos' : '?erro=campos'));
        exit;
        
    }

    $categoria = new Categoria($id, $nome);


    if ($id) {

        $objetoExistente = $categoriaRepositorio->findById($id);

        if (!$objetoExistente) {
            header('Location: listar.php?erro=inexistente');
            exit;
        }
        
        $categoriaRepositorio->atualizar($categoria);
        header('Location: listar.php?editadoregistro=true');
        exit;

    }
    else {
            
        $categoriaRepositorio->cadastrar($categoria);
        header('Location: listar.php?novoregistro=true');
        exit;

    }
?>
