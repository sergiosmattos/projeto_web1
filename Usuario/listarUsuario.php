<?php

session_start();

if(!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

require __DIR__ . "/src/Repositorio/conexaoBD.php";
require __DIR__ . "/src/Repositorio/UsuarioRepositorio.php";
require __DIR__ . "/src/Repositorio/CategoriaRepositorio.php";
require __DIR__ . "/src/Repositorio/LeilaoRepositorio.php";
require __DIR__ . "/src/Repositorio/ObraRepositorio.php";
require __DIR__ . "/src/Repositorio/ProdutoRepositorio.php";
require __DIR__ . "/src/Modelo/Categoria.php";
require __DIR__ . "/src/Modelo/Leilao.php";
require __DIR__ . "/src/Modelo/Obra.php";
require __DIR__ . "/src/Modelo/Produto.php";
require __DIR__ . "/src/Modelo/Usuario.php";

if (!$usuarioLogado) {
    header('Location: login.php');
    exit;
}

$tipo = $_GET['tipo'] ?? 'usuario';
$titulo = '';
$itens = [];

if ($tipo === 'usuario') {
    $repo = new UsuarioRepositorio($pdo);
    $itens = $repo->listar();
    $titulo = 'Lista de Usuários';
} elseif ($tipo === 'obra') {
    $repo = new ObraRepositorio($pdo);
    $itens = $repo->listar();
    $titulo = 'Lista de Obras';
} elseif ($tipo === 'produto') {
    $repo = new ProdutoRepositorio($pdo);
    $itens = $repo->listar();
    $titulo = 'Lista de Produtos';
} else if ($tipo === 'categoria') {
    $repo = new CategoriaRepositorio($pdo);
    $itens = $repo->listar();
    $titulo = 'Lista de Categorias';
} else if ($tipo === 'leilao') {
    $repo = new LeilaoRepositorio($pdo);
    $itens = $repo->listar();
    $titulo = 'Lista de Leilões';
} else {
    $titulo = 'Tipo inválido';
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/listarUsuario.css">
    <link rel="stylesheet" href="../css/admin.css">
    <title>Admin - Usuario</title>
</head>

<body>
    <section class="topo">
        <div class="logo">
            <img src="../img/logo_geek.png" class="iconLogo" alt="logo geek artefacts">
            <h1>Geek Artefacts</h1>
        </div>

        <a href="#">Adminstração</a>
        <a href="#">Leilao</a>
        <a href="#">Compra</a>

        <img src="../img/icon_user_branco.svg" class="iconUser" alt="IconUsuario">
    </section>

    <aside class="sidebar">
        <a href="../dashboardAdmin.html">Painel de controle</a>
        <a href="#">Obra</a>
        <a href="#">Usuários</a>
        <a href="#">Leilões</a>
        <a href="#">Categorias</a>
        <a href="#">Produtos</a>
    </aside>


    <div class="listar">
        <h1>Gerenciar Usuario</h1>

        <div class="acoes">
            <button class="btn-add">adicionar Usuario</button>
            <div class="busca">
                <input type="text" placeholder="Buscar">
            </div>
        </div>

        <section class="tabela">
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Lance Atual</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Vaso</td>
                        <td>R$ 5.000</td>
                        <td>
                            <button class="btn-editar">alterar</button>
                            <button class="btn-excluir">excluir</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>
