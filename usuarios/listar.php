<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
require __DIR__ . "/../src/conexaoBD.php";
require __DIR__ . "/../src/Modelo/Usuario.php";
require __DIR__ . "/../src/Repositorio/UsuarioRepositorio.php";

$usuarioLogado = $_SESSION['usuario'] ?? null;
if (!$usuarioLogado) {
    header('Location: login.php');
    exit;
}

$usuarioRepositorio = new UsuarioRepositorio($pdo);
$usuarios = $usuarioRepositorio->listar();


?>
<!doctype html>
<html lang="pt-br">


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
