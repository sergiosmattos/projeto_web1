<!-- <?php
        require __DIR__ . "/../../src/conexaoBD.php";
        require __DIR__ . "/../../src/Modelo/Obra.php";
        require __DIR__ . "/../../src/Repositorio/ObraRepositorio.php";

        $usuarioRepositorio = new UsuarioRepositorio($pdo);

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $usuario = new Usuario(
                $_POST['id'] ?: null,
                $_POST['nome'],
                $_POST['descricao'],
            );
        }


        if ($usuario->getId()) {
            $usuarioRepositorio->atualizar($usuario);
        } else {
            $usuarioRepositorio->cadastrar($usuario);
        }

        header("Location: listar.php");
        exit();


        require __DIR__ . "/../src/conexaoBD.php";
        require __DIR__ . "/../src/Modelo/Usuario.php";
        require __DIR__ . "/../src/Repositorio/UsuarioRepositorio.php";

        $repo = new UsuarioRepositorio($pdo);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: listar.php');
            exit;
        }

        $id     = isset($_POST['id']) && $_POST['id'] !== '' ? (int)$_POST['id'] : null;
        $nome   = trim($_POST['nome']   ?? '');
        $tipo = trim($_POST['tipo'] ?? 'User');
        $dataNascimento = trim($_POST['dataNascimento'] ?? '');
        $email  = trim($_POST['email']  ?? '');
        $senha  = $_POST['senha'] ?? '';


        // validadecao
        if ($nome === '' || $email === '' || $dataNascimentoStr === '' || (!$id && $senha === '')) {
            header('Location: form.php' . ($id ? '?id=' . $id . '&erro=campos' : '?erro=campos'));
            exit;
        }

        if (!in_array($tipo, ['User', 'Admin'], true)) {
            $tipo = 'User';
        }

        if ($id) {

            $existente = $repo->findById($id);
            if (!$existente) {
                header('Location: listar.php?erro=inexistente');
                exit;
            }


            if ($senha === '') {
                $senhaParaObjeto = $existente->getSenha(); // já é hash
            } else {
                $senhaParaObjeto = $senha; // plain; será hash no repositório (com proteção contra re-hash)
            }



            $usuario = new Usuario($id, $tipo, $nome, $dataNascimento, $email, $senhaParaObjeto);
            $repo->atualizar($usuario);
            header('Location: listar.php?ok=1');
            exit;
        } else {
            // Novo usuário
            $usuario = new Usuario(null, $tipo, $nome, $dataNascimento, $email, $senha);
            $repo->cadastrar($usuario);
            header('Location: listar.php?novo=1');
            exit;
        }
