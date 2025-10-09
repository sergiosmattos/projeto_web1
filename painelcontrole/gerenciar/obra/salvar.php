<!-- <?php

        require __DIR__ . "/../../../src/repositorio/ObraRepositorio.php";

        var_dump($_SERVER["REQUEST_METHOD"]);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: listar.php');
            exit;
        }
        
        $obraRepositorio = new obraRepositorio($pdo);

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $obra = new Obra(
                
                $_POST['id'] ?: null,
                $_POST['nome'],
                $_POST['descricao'],
            );
        }


        if ($obra->getId()) {
            $obraRepositorio->atualizar($obra);
        } else {
            $obraRepositorio->cadastrar($obra);
        }


        $repo = new obraRepositorio($pdo);


        $id     = isset($_POST['id']) && $_POST['id'] !== '' ? (int)$_POST['id'] : null;
        $nome   = trim($_POST['nome']   ?? '');
        $descricao = trim($_POST['descricao'] ?? '');



        // validadecao
        if ($nome === '' || $descricao === '') {
            header('Location: form.php' . ($id ? '?id=' . $id . '&erro=campos' : '?erro=campos'));
            exit;
        }

        if ($id) {

            $existente = $obraRepositorio->findById($id);
            if (!$existente) {
                header('Location: listar.php?erro=inexistente');
                exit;
            }

            $obra = new Obra($id, $nome, $descricao);
            $obraRepositorio->atualizar($obra);
            header('Location: listar.php?ok=1');
            exit;

        } 
        else {

            $obra = new Obra(null, $nome, $descricao);
            $obraRepositorio->cadastrar($obra);
            header('Location: listar.php?novo=1');
            exit;
        }
