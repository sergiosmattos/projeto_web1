<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/admin.css">
    <title>Admin - Leilões</title>
</head>
<body>
    <section class="topo">
        <div class="logo">
            <img src="img/logo_geek.png" class="iconLogo" alt="logo geek artefacts">
            <h1>Geek Artefacts</h1>
        </div>
        <img src="img/icon_user_branco.svg" class="iconUser" alt="IconUsuario">
    </section>

    <aside class="sidebar">
        <a href="#">Obra</a>
        <a href="#">Leilões</a>
        <a href="#">Usuários</a>
        <a href="#">Categorias</a>
    </aside>

    <main>
        <h1>Gerenciar Leilões</h1>

        <div class="acoes">
            <button class="btn-add">adicionar leilão</button>
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
    </main>
</body>
</html>
