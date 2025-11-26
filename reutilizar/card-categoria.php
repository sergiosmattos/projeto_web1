<div>

    <a name="categoria" href="listaObra.php?id=<?=htmlspecialchars($categoria->getId())?>" class="categoria-item">
        <img 
            src="/projeto_web1/<?= htmlspecialchars($categoria->getImagemDiretorio()) ?>" 
            alt="<?= htmlspecialchars($categoria->getNome()) ?>"
            class="imagemList">
        <p><?= htmlspecialchars($categoria->getNome()) ?></p>
    </a>

</div>