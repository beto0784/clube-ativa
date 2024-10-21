<?php

class Agendamento {
    private $table_name;

    public function __construct() {
        $this->table_name = "agendamentos";
    }

    public function buscarAgendamentosDoDia() {
        $query = "SELECT a.id, a.horario, q.nome as quadra, s.nome as socio, a.status 
                  FROM " . $this->table_name . " a
                  JOIN quadras q ON a.quadra_id = q.id
                  JOIN socios s ON a.socio_id = s.id
                  WHERE DATE(a.data) = CURDATE()
                  ORDER BY a.horario";
        $stmt = $this->conn->prepare($query);
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

    public function buscarAgendamentoHojePorSocio($socioId) {
        $query = "SELECT a.horario, q.nome as quadra 
                  FROM " . $this->table_name . " a
                  JOIN quadras q ON a.quadra_id = q.id
                  WHERE a.socio_id = :socio_id AND DATE(a.data) = CURDATE()
                  LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":socio_id", $socioId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
