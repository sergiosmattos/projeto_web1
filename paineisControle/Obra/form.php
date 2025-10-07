<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/reset.css">
    <link rel="stylesheet" href="../../css/admin.css">
    <link rel="stylesheet" href="../../css/form.css">
    <title>Admin - Obras</title>
</head>

<body>
    <section class="topo">
        <div class="logo">
            <img src="../../img/logo_geek.png" class="iconLogo" alt="logo geek artefacts">
            <h1>Geek Artefacts</h1>
        </div>

        <a href="#">Administração</a>
        <a href="#">Leilão</a>
        <a href="#">Compra</a>

        <img src="../../img/icon_user_branco.svg" class="iconUser" alt="IconUsuario">
    </section>

    <section class="all-form">
        <h2>Cadastrar Obra</h2>

        <div class="form-wrapper">
            <form action="" method="post" class="form-cadastro">
                
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
