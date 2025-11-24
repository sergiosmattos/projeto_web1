<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
    require DIR_PROJETOWEB . 'src/repositorio/UsuarioRepositorio.php';

    session_start();

    if( $_SERVER["REQUEST_METHOD"] !== "POST" ){
        header('Location: login.php');
        exit();
    }

    $emailUsuario = $_SESSION['usuario'] ?? null;
    if(!$emailUsuario) {
        header('Location: login.php');
        exit;
    }

    $usuarioRepositorio = new UsuarioRepositorio($pdo);
    $usuarioExistente = $usuarioRepositorio->findByEmail($emailUsuario);

    $id = $usuarioExistente->getId();
    $tipo = $usuarioExistente->getTipo();
    $nome = $_POST['nome'] ?? $usuarioExistente->getNome();
    $email = $_POST['email'] ?? $usuarioExistente->getEmail();
    $senha = $_POST['senha'] ?? $usuarioExistente->getSenha();
    $dataNascimento = $_POST['dataNascimento'] ?? $usuarioExistente->getDataNascimento()->format('Y-m-d');
    $saldo = $usuarioExistente->getSaldo();

    
    $uploadsDir = DIR_PROJETOWEB . 'uploads/usuarios/';

    //is_dir verifica se o uploadsDir realmente existe
    //se nao tiver mkdir cria o mkdir cria com nome uploadsDir
    if (!is_dir($uploadsDir)) {
        mkdir($uploadsDir, 0755, true);
    }

    $imagemFinal = $_POST['imagem_atual'] ?? $usuarioExistente->getImagem();

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {

        // caminho do arquivo temporário
        $tmpPath = $_FILES['imagem']['tmp_name'];
        // verifica se é uma imagem valida e retorna uma array com as informaçoes da imagem
        $imgInfo = @getimagesize($tmpPath);

        if ($imgInfo !== false) {
            $ext = '';
            switch ($imgInfo['mime']) {
                case 'image/jpeg': $ext = '.jpg'; break;
                case 'image/png':  $ext = '.png'; break;
                case 'image/gif':  $ext = '.gif'; break;
                default: $ext = image_type_to_extension($imgInfo[2]) ?: '';
            }

            $filename = uniqid('user_', true) . $ext;
            $destination = $uploadsDir . $filename;

        $imagemAntiga = $usuarioExistente->getImagem();
        if ($imagemAntiga && file_exists($uploadsDir . $imagemAntiga)) {
            unlink($uploadsDir . $imagemAntiga);
        }

            if (move_uploaded_file($tmpPath, $destination)) {
                $imagemFinal = $filename;
            }
    }


}


    // Valida os campos
    if ($nome === '' || $email === '' || $senha === '' || $dataNascimento === '') {
        header('Location: perfil.php?erro=campos');
        exit;
    }

    $usuarioAtualizado = new Usuario($id, $tipo, $nome, new DateTime($dataNascimento), $email,$senha, $saldo, $imagemFinal);

    $usuarioRepositorio->atualizar($usuarioAtualizado);

    header('Location: perfil.php?editadoregistro=true');
    exit;
?>
