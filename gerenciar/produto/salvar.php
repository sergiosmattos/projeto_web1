<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
require_once DIR_PROJETOWEB . 'src/repositorio/ProdutoRepositorio.php';
require_once DIR_PROJETOWEB . 'src/repositorio/ObraRepositorio.php';

session_start();

$produtoRepositorio = new ProdutoRepositorio($pdo);
$obraRepositorio = new ObraRepositorio($pdo);

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header('Location: listar.php');
    exit;
}

$id = $_POST['id'] ?? '';
$id = $id !== '' ? (int)$id : null;

$nome = trim($_POST['nome'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$preco = trim($_POST['preco'] ?? '');
$idObra = trim($_POST['id_obra'] ?? '');


if ($nome === '' || $descricao === '' || $preco === '' || $idObra === '') {
    header("Location: form.php?erro=campos");
    exit;
}

$obra = $obraRepositorio->findById((int)$idObra);


$uploadsDir = DIR_PROJETOWEB . 'uploads/produtos/';


if (!is_dir($uploadsDir)) {
    mkdir($uploadsDir, 0755, true);
}


$imagemFinal = 'semImagem.png';


if ($id) {
    $produtoExistente = $produtoRepositorio->findById($id);
    
    if (!$produtoExistente) {
        header('Location: listar.php?erro=inexistente');
        exit;
    }
    
    $imagemFinal = $_POST['imagem_atual'] ?? $produtoExistente->getImagem();
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
        
        $filename = uniqid('produto_', true) . $ext;
        $destination = $uploadsDir . $filename;
        
        if ($id && isset($produtoExistente)) {
            $imagemAntiga = $produtoExistente->getImagem();
            if ($imagemAntiga && $imagemAntiga !== 'semImagem.png' && file_exists($uploadsDir . $imagemAntiga)) {
                unlink($uploadsDir . $imagemAntiga);
            }
        }
        
        if (move_uploaded_file($tmpPath, $destination)) {
            $imagemFinal = $filename;
        }
    }
}

$produto = new Produto(
    $id, 
    $nome, 
    $descricao, 
    (float)$preco, 
    $obra,
    $imagemFinal
);

if ($id) {
    $produtoRepositorio->atualizar($produto);
    header('Location: listar.php?editadoregistro=true');
    exit;
} else {
    $produtoRepositorio->cadastrar($produto);
    header('Location: listar.php?novoregistro=true');
    exit;
}
?>