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

if ($nome === '') {
    header('Location: form.php' . ($id ? '?id=' . $id . '&erro=campos' : '?erro=campos'));
    exit;
}

$uploadsDir = DIR_PROJETOWEB . 'uploads/categorias/';

if (!is_dir($uploadsDir)) {
    mkdir($uploadsDir, 0755, true);
}

$imagemFinal = 'semImagem.png';

if ($id) {
    $categoriaExistente = $categoriaRepositorio->findById($id);
    
    if (!$categoriaExistente) {
        header('Location: listar.php?erro=inexistente');
        exit;
    }
    
    $imagemFinal = $_POST['imagem_atual'] ?? $categoriaExistente->getImagem();
}

if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    
    $tmpPath = $_FILES['imagem']['tmp_name'];
    
    $imgInfo = @getimagesize($tmpPath);
    
    if ($imgInfo !== false) {
        $ext = '';
        switch ($imgInfo['mime']) {
            case 'image/jpeg': 
                $ext = '.jpg'; 
                break;
            case 'image/png':  
                $ext = '.png'; 
                break;
            case 'image/gif':  
                $ext = '.gif'; 
                break;
            default: 
                $ext = image_type_to_extension($imgInfo[2]) ?: '';
        }
        
        $filename = uniqid('categoria_', true) . $ext;
        $destination = $uploadsDir . $filename;
        
        // Se for edição, remover imagem antiga
        if ($id && isset($categoriaExistente)) {
            $imagemAntiga = $categoriaExistente->getImagem();
            if ($imagemAntiga && $imagemAntiga !== 'semImagem.png' && file_exists($uploadsDir . $imagemAntiga)) {
                unlink($uploadsDir . $imagemAntiga);
            }
        }
        
        if (move_uploaded_file($tmpPath, $destination)) {
            $imagemFinal = $filename;
        }
    }
}

$categoria = new Categoria($id, $nome, $imagemFinal);

if ($id) {
    $categoriaRepositorio->atualizar($categoria);
    header('Location: listar.php?editadoregistro=true');
    exit;
} else {
    $categoriaRepositorio->cadastrar($categoria);
    header('Location: listar.php?novoregistro=true');
    exit;
}
?>