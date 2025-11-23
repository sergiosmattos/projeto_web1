<?php 

require_once __DIR__."/Usuario.php";
require_once __DIR__."/Produto.php";
class Compra {

    private ?int $id;
    private ?DateTime $dataHoraCompra;

    private int $unidades;

    private float $valorTotal;

    private Usuario $usuario;

    private Produto $produto;

    public function __construct(?int $id, ?DateTime $dataHoraCompra, int $unidades, float $valorTotal, Usuario $usuario, Produto $produto ) {

        $this->id = $id;
        $this->dataHoraCompra = $dataHoraCompra;
        $this->unidades = $unidades;
        $this->valorTotal = $valorTotal;
        $this->usuario = $usuario;
        $this->produto = $produto;
        
    }

    public function getId() : ?int 
    {
        return $this->id;
    }

    public function getDataHoraCompra() : ?DateTime 
    {
        return $this->dataHoraCompra;
    }

    public function getUnidades() : int 
    {
        return $this->unidades;
    }

    public function getValorTotal() : float 
    {
        return $this->valorTotal;
    }

    public function getUsuario() : Usuario 
    {
        return $this->usuario;
    }

    public function getProduto() : Produto 
    {
        return $this->produto;
    }
    

}


