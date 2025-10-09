<?php
    
    session_start();

    $emailUsuario = $_SESSION['usuario'] ?? null;

    if (!isset($emailUsuario)) {
        header('Location: ../login.php');
        exit;
    }

    require __DIR__ . "/../../../src/repositorio/ObraRepositorio.php";

    $obraRepositorio = new ObraRepositorio($pdo);
    $obras = $obraRepositorio->listar();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo_geek.png">
    
    <link rel="stylesheet" href="../../../css/reset.css">
    <link rel="stylesheet" href="../../../css/listarUsuario.css">
    <link rel="stylesheet" href="../../../css/admin.css">
    <title>Gerenciar - Obras</title>
</head>

<body>
    
    <section class="topo">

        <div class="logo">
            <img src="../../../img/logo_geek.png" class="iconLogo" alt="logo geek artefacts">
            <h1>Geek Artefacts</h1>
        </div>

        <a href="#">Administração</a>
        <a href="#">Leilão</a>
        <a href="#">Compra</a>

        <img src="../../../img/icon_user_branco.svg" class="iconUser" alt="IconUsuario">
    </section>

    <aside class="sidebar">
        <a href="../dashboardAdmin.php">Painel de controle</a>
        <a href="../Obra/listar.php">Obras</a>
        <a href="../Usuario/listar.php">Usuários</a>
        <a href="#">Leilões</a>
        <a href="#">Categorias</a>
        <a href="#">Produtos</a>
    </aside>

    <div class="listar">
        <h1>Gerenciar Obras</h1>

        <div class="acoes">

            <a href="form.php"><button class="btn-add">Adicionar Obra</button></a>
            
            <div class="busca">
                <input type="text" placeholder="Buscar Obra">
            </div>
        </div>

        <section class="tabela">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($obras as $obra): ?>
                        <tr>
                            <td><?= htmlspecialchars($obra->getId()) ?></td>
                            <td><?= htmlspecialchars($obra->getNome()) ?></td>
                            <td><?= htmlspecialchars($obra->getDescricao()) ?></td>
                            <td>
                                <a href="form.php?id=<?= $obra->getId()?>"><button class="btn-editar">Alterar</button></a>

                                <form action="excluir.php" method="post">
                                    <input type="hidden" name="id" value="<?= $usuario->getId() ?>">
                                    <input type="submit" class="btn-excluir" value="Excluir">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>
