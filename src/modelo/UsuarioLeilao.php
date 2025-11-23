<?php

require_once __DIR__ . '/Usuario.php';
require_once __DIR__ . '/Leilao.php';
class UsuarioLeilao {

    private Usuario $usuario;
    private Leilao $leilao;
    private float $lance;

    public function __construct(Usuario $usuario, Leilao $leilao, float $lance) {
        
        $this->usuario = $usuario;
        $this->leilao = $leilao;
        $this->lance = $lance;

    }

    public function getUsuario() : Usuario 
    {
        return $this->usuario;    
    }

    public function getLeilao() : Leilao 
    {
        return $this->leilao;    
    }

    public function getLance() : float
    {
        return $this->lance;    
    }

}