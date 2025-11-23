<?php 


class Categoria {

    private ?int $id;
    private string $nome;
    private ?string $imagem;

    public function __construct(?int $id, string $nome, ?string $imagem = null) {

        $this->id = $id;
        $this->nome = $nome;
        $this->imagem = $imagem ?? 'sem_imagem.png';
        
    }

    public function getId() : ?int 
    {
        return $this->id;
    }

    public function getNome() : string 
    {
        return $this->nome;
    }

    public function getImagem(): ?string 
    {
        return $this->imagem;
    }

    public function getImagemDiretorio(): string 
    {
        
        $nomeImagem = $this->imagem ?: 'sem_imagem.png';
        
        $caminhoUploads = DIR_PROJETOWEB . 'uploads/categorias/' . $nomeImagem;
        
        // var_dump($caminhoUploads);
        
        if (file_exists($caminhoUploads)) {
            return 'uploads/categorias/' . $nomeImagem;
        }
        
        return 'img/' . $nomeImagem;
    }

}


?>