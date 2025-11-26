<?php
    
    require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
    require DIR_PROJETOWEB . 'src/repositorio/UsuarioRepositorio.php';
    require DIR_PROJETOWEB . 'src/repositorio/ObraRepositorio.php';
    require DIR_PROJETOWEB . 'src/repositorio/ProdutoRepositorio.php';
    require DIR_PROJETOWEB . 'src/repositorio/CompraRepositorio.php';
    
    session_start();

    $usuarioRepo = new UsuarioRepositorio($pdo);

    $obraRepo = new ObraRepositorio($pdo);
    $produtoRepo = new ProdutoRepositorio($pdo, $obraRepo);

    $compraRepo = new CompraRepositorio($pdo, $usuarioRepo, $produtoRepo);

    $idProduto = $_POST['id_produto'] ?? null;

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        header('Location: compra.php?id=' . $idProduto);
        exit;
    }
    $idUsuario = $_POST['id_usuario'] ?? null;
    $precoTotal = $_POST['preco_total'] ?? null;
    $qtdDesejada = $_POST['quantidade_desejada'] ?? '';

    if ($qtdDesejada == '') {

        header("Location: compra.php?id=". $idProduto . "&erro=campos");
        exit;
        
    }

    try {

        $pdo->beginTransaction();

        $usuario = $usuarioRepo->findById($idUsuario);
        $produto = $produtoRepo->findById($idProduto);

        $saldoUsuario = $usuario->getSaldo();
        $qtdEstoque = $produto->getQuantidade();

        if($precoTotal > $saldoUsuario) {

            $pdo->rollBack();
            header("Location: compra.php?id=". $idProduto . "&erro=saldo");
            exit;

        }

        if( $qtdEstoque <= 0 ) {

            $pdo->rollBack();
            header("Location: compra.php?id=". $idProduto . "&erro=zerado");
            exit;

        }

        if( $produto->getQuantidade() < $qtdDesejada ) {

            $pdo->rollBack();
            header("Location: compra.php?id=". $idProduto . "&erro=quantidade");
            exit;

        }

        $novaQuantidade = $qtdEstoque - $qtdDesejada;

        // echo("<br/>Quantidade em Estoque: ");
        // var_dump($qtdEstoque);

        // echo("<br/>Quantidade Desejada: ");
        // var_dump($qtdDesejada);

        // echo("<br/>Nova Quantidade: ");
        // var_dump($novaQuantidade);

        $usuario->setSaldo($saldoUsuario - $precoTotal);
        $usuarioRepo->atualizar($usuario);
        
        $produto->setQuantidade($novaQuantidade);
        $produtoRepo->atualizar($produto);

        $compra = new Compra(null, null, $qtdDesejada, $precoTotal, $usuario, $produto);
        $compraRepo->cadastrar($compra);

        $pdo->commit();

        header("Location: compra.php?id=". $idProduto . "&novacompra=true");
        exit;

    } 
    catch (Throwable $th) {

        $pdo->rollBack();
        header("Location: compra.php?id=". $idProduto . "&erro=desconhecido");
        exit;

    }

?>
