<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
require_once DIR_PROJETOWEB . 'src/repositorio/ProdutoRepositorio.php';
require_once DIR_PROJETOWEB . 'src/repositorio/ObraRepositorio.php';

session_start();

$obraRepo = new ObraRepositorio($pdo);
$produtoRepo = new ProdutoRepositorio($pdo, $obraRepo);

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header('Location: listar.php');
    exit;
}

$id = $_POST['id'] ?? '';
$id = $id !== '' ? (int)$id : null;

$nome = trim($_POST['nome'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$quantidade = $_POST['quantidade'] ?? '';
$preco = trim($_POST['preco'] ?? '');
$id_obra = trim($_POST['id_obra'] ?? '');

if ($nome === '' || $descricao === '' || $quantidade == '' || $preco === '' || $id_obra === '' ) {
    header("Location: form.php?erro=campos");
    exit;
}

$obra = $obraRepo->findById($id_obra);

$uploadsDir = DIR_PROJETOWEB . 'uploads/produtos/';

if (!is_dir($uploadsDir)) {
    mkdir($uploadsDir, 0755, true);
}

$imagemFinal = 'semImagem.png';

if ($id) {

    $produtoExistente = $produtoRepo->findById($id);
    
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
            if ($imagemAntiga && $imagemAntiga !== 'sem_imagem.png' && file_exists($uploadsDir . $imagemAntiga)) {
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
    $quantidade,
    (float)$preco, 
    $obra,
    $imagemFinal
    
);

if ($id) {
    $produtoRepo->atualizar($produto);
    header('Location: listar.php?editadoregistro=true');
    exit;
} else {
    $produtoRepo->cadastrar($produto);
    header('Location: listar.php?novoregistro=true');
    exit;
}
?>