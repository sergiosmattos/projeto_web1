
<header>

    <section class="topo">

        <div class="logo">
            <a href="/projeto_web1/dashboardUsuario.php">
                <img src="/projeto_web1/img/logo_geek.png" class="iconLogo" alt="logo geek artefacts">
                <h1>Geek Artifacts</h1>    
            </a>
        </div>

        <div class="container-navegacao">

            <?php if($tipoUsuario === 'Admin'): ?>
            <a href="/projeto_web1/dashboardAdmin.php">Adminstração</a>
            <?php endif?>
            
            <a href="#">Leilao</a>
            <a href="#">Compra</a>

        </div>

        <img src="/projeto_web1/img/icon_user_branco.svg" class="iconUser" alt="IconUsuario">
        
    </section>

</header>