<?php
require_once '../config/database.php';

class Socio {
    private $conn;
    private $table_name = "socios";

    public $id;
    public $nome;
    public $endereco;
    public $email;
    public $telefone;
    public $matricula;
    public $status;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function salvar() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET nome=:nome, endereco=:endereco, email=:email, 
                      telefone=:telefone, matricula=:matricula, status=:status";

        $stmt = $this->conn->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->endereco = htmlspecialchars(strip_tags($this->endereco));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->telefone = htmlspecialchars(strip_tags($this->telefone));
        $this->matricula = htmlspecialchars(strip_tags($this->matricula));
        $this->status = "pendente";

        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":endereco", $this->endereco);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":telefone", $this->telefone);
        $stmt->bindParam(":matricula", $this->matricula);
        $stmt->bindParam(":status", $this->status);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function buscarPorStatus($status) {
        $query = "SELECT id, nome, email, matricula FROM " . $this->table_name . " WHERE status = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $status);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function atualizarStatus($id, $status) {
        $query = "UPDATE " . $this->table_name . " SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function buscarPorNomeOuMatricula($busca) {
        $query = "SELECT id, nome, matricula, status FROM " . $this->table_name . " 
                  WHERE nome LIKE :busca OR matricula = :busca_exata";
        $stmt = $this->conn->prepare($query);
        $buscaLike = "%{$busca}%";
        $stmt->bindParam(":busca", $buscaLike);
        $stmt->bindParam(":busca_exata", $busca);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
