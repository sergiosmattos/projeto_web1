
<div class="produto-card">
    
    <a href="/projeto_web1/compra.php?id=<?=htmlspecialchars($produto->getId())?>">

        <img 
        src="/projeto_web1/<?= htmlspecialchars($produto->getImagemDiretorio())?>" 
        alt="<?= htmlspecialchars($produto->getNome())?>">
        <h3><?= htmlspecialchars($produto->getNome()) ?></h3>
        <p class="descricao"><?= htmlspecialchars($produto->getDescricao()) ?></p>
        <p class="preco">R$ <?= number_format($produto->getPreco(), 2, ',', '.') ?></p>
        
    </a>

</div>