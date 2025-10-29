<?php
    
    require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
    require DIR_PROJETOWEB . 'src/repositorio/UsuarioRepositorio.php';
    
    session_start();

    $usuarioRepositorio = new UsuarioRepositorio($pdo);
    $timezone = new DateTimeZone('UTC');

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        header('Location: listar.php');
        exit;
    }

    $id = $_POST['id'] ?? '';

    $id = $id !== '' ? (int) $id : null;

    $nome = trim($_POST['nome']) ?? '';
    $email = trim($_POST['email']) ?? '';
    $senha = trim($_POST['senha']) ?? '';
    $dataNascimento = $_POST['dataNascimento'] ?? '';

    $dataNascimento = isset($dataNascimento) ? new DateTime($dataNascimento, $timezone) : '';

    if ( $nome === '' || $email === '' || $senha === '' || $dataNascimento === '' ) {

        header('Location: cadastro.php?erro=campos');
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
        header('Location: listar.php?editadoregistro=true');
        exit;

    }
    else {
            
        $obraRepositorio->cadastrar($obra);
        header('Location: listar.php?novoregistro=true');
        exit;

    }
?>
