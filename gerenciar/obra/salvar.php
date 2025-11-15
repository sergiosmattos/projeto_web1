<?php
    
    require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
    require DIR_PROJETOWEB . 'src/repositorio/ObraRepositorio.php';
    require DIR_PROJETOWEB . 'src/repositorio/CategoriaRepositorio.php';
    require DIR_PROJETOWEB . 'src/repositorio/ObraCategoriaRepositorio.php';
    
    session_start();

    $obraRepo = new ObraRepositorio($pdo);
    $catgRepo = new CategoriaRepositorio($pdo);
    $oCRepo = new ObraCategoriaRepositorio(
        $pdo, 
        $obraRepo, 
        $catgRepo
    );

    // if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    //     header('Location: listar.php');
    //     exit;
    // }

    $id = $_POST['id'] ?? '';

    $id = $id !== '' ? (int) $id : null;
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $categoriasIds = $_POST['categorias'] ?? [];

    // if ($nome === '' || $descricao === '' || is_null($categorias) ) {

    //     header('Location: form.php' . ($id ? '?id=' . $id . '&erro=campos' : '?erro=campos'));
    //     exit;
        
    // }

    $obra = new Obra($id, $nome, $descricao);

    // if ($id) {

    //     $objetoExistente = $obraRepositorio->findById($id);

    //     if (!$objetoExistente) {
    //         header('Location: listar.php?erro=inexistente');
    //         exit;
    //     }
        
    //     $obraRepositorio->atualizar($obra);

    //     header('Location: listar.php?editadoregistro=true');
    //     exit;

    // }
    // else {
            
    //     $obraRepositorio->cadastrar($obra);
    //     header('Location: listar.php?novoregistro=true');
    //     exit;

    // }

    if( $id ){

        $objetoExistente = $obraRepo->findById($id);

        if (!$objetoExistente) {
            header('Location: listar.php?erro=inexistente');
            exit;
        }

        $categoriasAll = [];
        $categoriasChecked = [];
        $categoriasUnchecked = [];

        defineCategoriaArray($pdo);

        $obraRepo->atualizar($obra);

        // header('Location: listar.php?editadoregistro=true');
        // exit;        

    }

    function defineCategoriaArray($pdo) : void {
        
        
        
    }

?>
