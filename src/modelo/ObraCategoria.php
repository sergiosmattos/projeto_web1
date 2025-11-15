<?php

require __DIR__.'/Obra.php';
require __DIR__.'/Categoria.php';

class ObraCategoria{
    
    private Obra $obra;
    private Categoria $categoria;

    function __construct($obra, $categoria) {
    
        $this->obra = $obra;
        $this->categoria = $categoria;

    }

    function getObra() : Obra {
        
        return $this->obra;

    }

    function getCategoria() : Categoria {
        
        return $this->categoria;

    }

}
