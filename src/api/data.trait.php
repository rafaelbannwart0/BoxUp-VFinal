<?php
class Service
{
  protected $con;

  public function __construct()
  {
    try {
      $this->con = new PDO('mysql:host=localhost;dbname=boxup;', 'user_boxup', '12345');
    } catch (PDOException $erro) {
      echo 'Erro ao conectar com o MySQL: ' . $erro->getMessage();
    };
  }

  public function Cadastrar($nome, $email, $senha, $cpf, $usuario, $motorista, $preco): array
  {
    $retorno = [];

    try {
      $senhaCripto = md5($senha);
      $sql = "INSERT INTO usuario (nome, senha, usuario, cpf, email, motorista, preco) VALUES ('$nome', '$senhaCripto', '$usuario', '$cpf', '$email', $motorista, $preco)";

      $stmt = $this->con->prepare($sql);
      $stmt->execute();

      $retorno["data"] = "";
      $retorno["message"] = "Usuario cadastrado";
      $retorno["resultado"] = true;
    } catch (PDOException $e) {
      $retorno["error"] = $e->getMessage();
      $retorno["resultado"] = false;
      $retorno["data"] = "";
    }

    return $retorno;
  }

  public function Logar($email, $senha): array
  {
    $retorno = [];

    try {
      $senhaCripto = md5($senha);
      $sql = "SELECT * FROM usuario WHERE email = '$email' AND senha = '$senhaCripto'";

      $query = $this->con->query($sql);

      $usuario = $query->fetch(PDO::FETCH_ASSOC);

      if (!$usuario) {
        $retorno["error"] = "Erro ao logar!";
        $retorno["resultado"] = false;
        $retorno["data"] = "";
      } else {
        $retorno["data"] = $usuario;
        $retorno["message"] = "Usuário Logado";
        $retorno["resultado"] = true;
      }
    } catch (PDOException $e) {
      $retorno["error"] = $e->getMessage();
      $retorno["resultado"] = false;
      $retorno["data"] = "";
    }

    return $retorno;
  }

  public function CriarMudanca($idUsuario, $objetos, $enderecoInicial, $enderecoFinal, $km, $observacoes)
  {
    if ($_SESSION["user"]["motorista"] != 0) {
      header("Location: /BoxUp/src/pages/usuario/login.php");
      exit;
    }

    $retorno = [];

    try {
      $sql = "SELECT id FROM usuario
        WHERE motorista = 1
        ORDER BY RAND()
        LIMIT 1;
      ";

      $query = $this->con->query($sql);
      $idMotorista = $query->fetch(PDO::FETCH_ASSOC)["id"];
    } catch (PDOException $e) {
      $retorno["error"] = $e->getMessage();
      $retorno["resultado"] = false;
      $retorno["data"] = "";

      return $retorno;
    }

    try {
      $sql = "INSERT INTO mudanca (id_usuario, id_motorista, objetos, endereco_inicial, endereco_final, km, observacoes) VALUES ('$idUsuario', '$idMotorista', '$objetos', '$enderecoInicial', '$enderecoFinal', $km, '$observacoes')";

      $stmt = $this->con->prepare($sql);
      $stmt->execute();

      $retorno["data"] = "";
      $retorno["message"] = "Mudanca cadastrada";
      $retorno["resultado"] = true;
    } catch (PDOException $e) {
      $retorno["error"] = $e->getMessage();
      $retorno["resultado"] = false;
      $retorno["data"] = "";
    }

    return $retorno;
  }public function BuscarTodasMudancasMotoristas()
{
    if ($_SESSION["user"]["motorista"] != 1) {
        header("Location: /BoxUp/src/pages/usuario/login.php");
        exit;
    }

    $retorno = [];

    try {
        $sql = "SELECT 
                    m.id AS mudanca_id,
                    m.*,
                    u.preco,
                    (SELECT COUNT(*) 
                     FROM chat c 
                     WHERE c.mudanca_id = m.id
                    ) AS hasChat
                FROM mudanca m
                INNER JOIN usuario u ON u.id = m.id_motorista
                ORDER BY m.id DESC";

        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $mudancas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($mudancas as &$m) {
            $m['hasChat'] = $m['hasChat'] > 0;
        }

        $retorno["data"] = $mudancas;
        $retorno["message"] = "Sucesso!";
        $retorno["resultado"] = true;
    } catch (PDOException $e) {
        $retorno["error"] = $e->getMessage();
        $retorno["resultado"] = false;
        $retorno["data"] = [];
    }

    return $retorno;
}



public function ChatExisteMotorista($mudanca_id, $motorista_id): bool
{
    $sql = "SELECT COUNT(*) as total 
            FROM chat 
            WHERE mudanca_id = :mudanca_id 
              AND (sender_id = :motorista_id OR receptor_id = :motorista_id)";
    $stmt = $this->con->prepare($sql);
    $stmt->execute([
        ':mudanca_id' => $mudanca_id,
        ':motorista_id' => $motorista_id
    ]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['total'] > 0;
}


  public function BuscarMudancas($idUsuario)
  {
    if ($_SESSION["user"]["motorista"] != 0) {
      header("Location: /BoxUp/src/pages/usuario/login.php");
      exit;
    }

    $retorno = [];

    try {
      $sql = "SELECT 
          mudanca.id AS mudanca_id,
          mudanca.*, 
          usuario.preco 
        FROM mudanca 
        INNER JOIN usuario ON usuario.id = mudanca.id_motorista 
        WHERE mudanca.id_usuario = $idUsuario";

      $query = $this->con->query($sql);

      $mudancas = $query->fetchAll(PDO::FETCH_ASSOC);


      $retorno["data"] = $mudancas;
      $retorno["message"] = "Sucesso!";
      $retorno["resultado"] = true;
    } catch (PDOException $e) {
      $retorno["error"] = $e->getMessage();
      $retorno["resultado"] = false;
      $retorno["data"] = "";
    }

    return $retorno;
  }


  public function EditarStatus($idUsuario, $status, $id): array
  {
    $retorno = [];

    try {
      $sql = "UPDATE mudanca SET status = $status where id_motorista = $idUsuario AND id = $id";
      $stmt = $this->con->prepare($sql);

      $stmt->execute();

      $retorno["data"] = "";
      $retorno["message"] = "Status Editado";
      $retorno["resultado"] = true;
    } catch (PDOException $e) {
      $retorno["error"] = $e->getMessage();
      $retorno["resultado"] = false;
      $retorno["data"] = "";
    }

    return $retorno;
  }

  public function ExcluiMudanca($idMudanca)
  {
    $retorno = [];

    try {
      $sql = "DELETE FROM mudanca WHERE id = $idMudanca";
      $stmt = $this->con->prepare($sql);

      $stmt->execute();

      $retorno["data"] = "";
      $retorno["message"] = "Mudança excluída";
      $retorno["resultado"] = true;
    } catch (PDOException $e) {
      $retorno["error"] = $e->getMessage();
      $retorno["resultado"] = false;
      $retorno["data"] = "";
    }

    return $retorno;
  }
  public function ListarMensagens($mudanca_id)
{
    $sql = "SELECT remetente_id, receptor_id, mensagem, criado_em 
            FROM chat 
            WHERE mudanca_id = :mudanca_id 
            ORDER BY criado_em ASC";
    $stmt = $this->con->prepare($sql);
    $stmt->execute([':mudanca_id' => $mudanca_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function SalvarMensagem($mudanca_id, $remetente_id, $receptor_id, $mensagem): bool
{
    $sql = "INSERT INTO chat (mudanca_id, remetente_id, receptor_id, mensagem) 
            VALUES (:mudanca_id, :remetente_id, :receptor_id, :mensagem)";
    $stmt = $this->con->prepare($sql);
    return $stmt->execute([
      ':mudanca_id'   => $mudanca_id,
      ':remetente_id' => $remetente_id,
      ':receptor_id'  => $receptor_id,
      ':mensagem'     => $mensagem
    ]);
}

public function ChatExiste($mudanca_id): bool
{
    $sql = "SELECT COUNT(*) as total FROM chat WHERE mudanca_id = :mudanca_id";
    $stmt = $this->con->prepare($sql);
    $stmt->execute([':mudanca_id' => $mudanca_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['total'] > 0;
}


public function CriarChat($mudancaId, $usuarioId) {
    $mudanca = $this->BuscarMudancaPorId($mudancaId);
    if (!$mudanca) {
        return ["resultado" => false, "mensagem" => "Mudança não encontrada"];
    }

    $usuario = $_SESSION["user"];
    if ($usuario["motorista"] == 1) {
        $receptorId = $mudanca["id_usuario"];
    } else {
        $receptorId = $mudanca["id_motorista"];
    }

    $stmt = $this->con->prepare(
        "INSERT INTO chat (mudanca_id, remetente_id, receptor_id, mensagem) VALUES (?, ?, ?, ?)"
    );
    $stmt->execute([$mudancaId, $usuarioId, $receptorId, "Chat iniciado"]);

    return ["resultado" => true, "mensagem" => "Chat criado"];
}

public function BuscarMudancaPorId($mudanca_id)
{
    $sql = "SELECT id, id_usuario, id_motorista
            FROM mudanca
            WHERE id = :id";
    $stmt = $this->con->prepare($sql);
    $stmt->execute([':id' => $mudanca_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
public function BuscarMudancasMotoristasVisiveis($motorista_id)
{
    if ($_SESSION["user"]["motorista"] != 1) {
        header("Location: /BoxUp/src/pages/usuario/login.php");
        exit;
    }

    $retorno = [];

    try {
        $sql = "
SELECT 
    m.id AS mudanca_id,
    m.*,
    u.preco,
    MAX(c.id) AS chat_id,
    MAX(c.remetente_id) AS chat_remetente
FROM mudanca m
INNER JOIN usuario u ON u.id = m.id_motorista
LEFT JOIN chat c ON c.mudanca_id = m.id
GROUP BY m.id
HAVING 
    chat_id IS NULL           -- no chat at all
    OR chat_remetente = :motorista_id   -- chat only with this motorista
ORDER BY m.id DESC
";


        $stmt = $this->con->prepare($sql);
        $stmt->execute(['motorista_id' => $motorista_id]);
        $mudancas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($mudancas as &$m) {
            $m["hasChat"] = !empty($m["chat_id"]);
        }

        $retorno["data"] = $mudancas;
        $retorno["message"] = "Sucesso!";
        $retorno["resultado"] = true;

    } catch (PDOException $e) {
        $retorno["error"] = $e->getMessage();
        $retorno["resultado"] = false;
        $retorno["data"] = [];
    }

    return $retorno;
}

}
