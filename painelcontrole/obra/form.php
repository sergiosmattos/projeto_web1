<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../login.php');
    exit;
}

$usuarioLogado = $_SESSION['usuario'] ?? null;
if (!$usuarioLogado) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../../src/Repositorio/ObraRepositorio.php';

$obraRepositorio = new ObraRepositorio($pdo);

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$modoEdicao = false;
$obra = null;

if ($id) {

    if (method_exists($obraRepositorio, 'findById')) {
        $obra = $obraRepositorio->findById($id);
    }

    if ($obra) {
        $modoEdicao = true;
    } else {
        // id inválido -> voltar para lista
        header('Location: listar.php');
        exit;
    }
}

// Valores para o form
$valorNome       = $modoEdicao ? $obra->getNome() : '';
$valorDescricao     = $modoEdicao ? $obra->getDescricao() : '';


$tituloPagina = $modoEdicao ? 'Editar Obra' : 'Cadastrar Obra';
$textoBotao   = $modoEdicao ? 'Salvar Alterações' : 'Cadastrar Obra';
$actionForm   = $modoEdicao ? 'salvar.php' : 'salvar.php';

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo_geek.png">
    <link rel="stylesheet" href="../../css/reset.css">
    <link rel="stylesheet" href="../../css/admin.css">
    <link rel="stylesheet" href="../../css/form.css">
    <title>Gerenciar Obras</title>
</head>

<body>
    <section class="topo">
        <div class="logo">
            <img src="../../img/logo_geek.png" class="iconLogo" alt="logo geek artefacts">
            <h1>Geek Artifacts</h1>
        </div>

        <a href="#">Administração</a>
        <a href="#">Leilão</a>
        <a href="#">Compra</a>

        <img src="../../img/icon_user_branco.svg" class="iconUser" alt="IconUsuario">
    </section>

    <aside class="sidebar">
        <a href="../dashboardAdmin.html">Painel de controle</a>
        <a href="../Obra/listar.php">Obra</a>
        <a href="#">Usuários</a>
        <a href="#">Leilões</a>
        <a href="#">Categorias</a>
        <a href="#">Produtos</a>
    </aside>

    <section class="all-form">
        <h2>Cadastrar Obra</h2>

        <div class="form-wrapper">
            <form action="salvar.php" method="POST" class="form-cadastro">
                
                <input id="nome" name="nome" type="text" placeholder="Nome" required>
                <input id="descricao" name="descricao" type="text" placeholder="Descrição" required>

                
                <div class="grupo-botoes">
                    <button type="submit" class="botao-cadastrar">Cadastrar</button>
                    <a href="listar.php" class="botao-voltar">Voltar</a>
                </div>
            </form>
        </div>
    </section>


</body>
</html>
