<?php
    
    require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
    require DIR_PROJETOWEB . 'src/repositorio/ObraRepositorio.php';
    require DIR_PROJETOWEB . 'src/repositorio/CategoriaRepositorio.php';
    require DIR_PROJETOWEB . 'src/repositorio/ObraCategoriaRepositorio.php';
    
    session_start();

    $obraRepo = new ObraRepositorio($pdo);
    $categoriaRepo = new CategoriaRepositorio($pdo);

    $obraCategoriaRepo = new ObraCategoriaRepositorio (
        $pdo, 
        $obraRepo, 
        $categoriaRepo
    );

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        header('Location: listar.php');
        exit;
    }

    $id = $_POST['id'] ?? '';

    $id = $id !== '' ? (int) $id : null;
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $categoriasIds = $_POST['categorias'] ?? null;

    if ($nome === '' || $descricao === '' || is_null($categoriasIds) ) {

        if($categoriasIds) {
            header('Location: form.php' . ($id ? '?id=' . $id . '&erro[]=campos' : '?erro[]=campos'));
        }
        else {
            header('Location: form.php' . ($id ? '?id=' . $id . '&erro[]=campos' : '?erro[]=campos') . '&erro[]=selecao');
        }

        exit;
        
    }

    $obra = new Obra($id, $nome, $descricao);

    if ($id) {

        $objetoExistente = $obraRepo->findById($id);

        if(!$objetoExistente) {
            header('Location: listar.php?erro=inexistente');
            exit;
        }

    }

    try {

        $pdo->beginTransaction();

        if($id) {

            $obraRepo->atualizar($obra);
            $obraCategoriaRepo->relateObjects($categoriasIds, $id);
            header('Location: listar.php?editadoregistro=true');

        }
        else {

            $obraRepo->cadastrar($obra);
            $obraCategoriaRepo->relateObjects($categoriasIds, null);
            header('Location: listar.php?novoregistro=true');

        }
        $pdo->commit();

        exit;
        
    } catch (Throwable $th) {

        echo $th->getMessage();
        $pdo->rollBack();
        header('Location: listar.php?erro=desconhecido');
        exit;
        
    }

?>
