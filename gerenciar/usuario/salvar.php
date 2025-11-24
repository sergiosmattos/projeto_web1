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
    $tipo = trim($_POST['tipo']) ?? 'User';
    $email = trim($_POST['email']) ?? '';
    $senha = trim($_POST['senha']) ?? '';
    $saldo = trim($_POST['saldo']) ?? '';
    $dataNascimento = $_POST['dataNascimento'] ?? '';
    $saldo = $_POST['saldo'] ?? 0;

    $dataNascimento = isset($dataNascimento) ? new DateTime($dataNascimento, $timezone) : '';

    if ( $nome === '' || $email === '' || $senha === '' || $dataNascimento === '' ) {

        header('Location: cadastro.php?erro=campos');
        exit;

    }

    $usuario = new Usuario($id, $tipo, $nome, $dataNascimento, $email, $senha, $saldo);

    if ($id) {

        $objetoExistente = $usuarioRepositorio->findById($id);

        if (!$objetoExistente) {
            header('Location: listar.php?erro=inexistente');
            exit;
        }
        
        $usuarioRepositorio->atualizar($usuario);
        header('Location: listar.php?editadoregistro=true');
        exit;

    }
    else {
            
        $usuarioRepositorio->cadastrar($usuario);
        header('Location: listar.php?novoregistro=true');
        exit;

    }
?>
