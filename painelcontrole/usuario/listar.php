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

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo_geek.png">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/listarUsuario.css">
    <link rel="stylesheet" href="../css/admin.css">
    <title>Gerenciar - Usuários</title>
</head>

<body>
    <section class="topo">
        <div class="logo">
            <img src="../img/logo_geek.png" class="iconLogo" alt="logo geek artefacts">
            <h1>Geek Artefacts</h1>
        </div>

        <a href="#">Administração</a>
        <a href="#">Leilão</a>
        <a href="#">Compra</a>

        <img src="../img/icon_user_branco.svg" class="iconUser" alt="IconUsuario">
    </section>

    <aside class="sidebar">
        <a href="../dashboardAdmin.html">Painel de controle</a>
        <a href="../Obra/listar.php">Obra</a>
        <a href="#">Usuários</a>
        <a href="#">Leilões</a>
        <a href="#">Categorias</a>
        <a href="#">Produtos</a>
    </aside>

    <div class="listar">
        <h1>Gerenciar Usuário</h1>

        <div class="acoes">
            <button class="btn-add">Adicionar Usuário</button>
            <div class="busca">
                <input type="text" placeholder="Buscar">
            </div>
        </div>

        <section class="tabela">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Nome</th>
                        <th>Data de Nascimento</th>
                        <th>Email</th>
                        <th>Senha</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?= htmlspecialchars($usuario->getId()) ?></td>
                            <td><?= htmlspecialchars($usuario->getTipo()) ?></td>
                            <td><?= htmlspecialchars($usuario->getNome()) ?></td>
                            <td><?= $usuario->getDataNascimento()->format('d/m/Y') ?></td>
                            <td><?= htmlspecialchars($usuario->getEmail()) ?></td>
                            <td><?= htmlspecialchars($usuario->getSenha()) ?></td>
                            <td>
                                <button class="btn-editar">Alterar</button>
                                <button class="btn-excluir">Excluir</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>
