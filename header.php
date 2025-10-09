
<section class="topo">

    <div class="logo">
        <a href="dashboardUsuario.php">
            <img src="img/logo_geek.png" class="iconLogo" alt="logo geek artefacts">
            <h1>Geek Artifacts</h1>    
        </a>
    </div>

    <div class="container-navegacao">

        <?php if($tipoUsuario === 'Admin'): ?>
        <a href="dashboardAdmin.php">Adminstração</a>
        <?php endif?>
        
        <a href="#">Leilao</a>
        <a href="#">Compra</a>

    </div>
    

    <img src="img/icon_user_branco.svg" class="iconUser" alt="IconUsuario">
        
</section>