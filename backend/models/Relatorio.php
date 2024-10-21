<?php
class Relatorio {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function buscarAgendamentosPorQuadra() {
        $query = "SELECT q.nome as quadra, COUNT(*) as total 
                  FROM agendamentos a
                  JOIN quadras q ON a.quadra_id = q.id
                  GROUP BY q.id
                  ORDER BY total DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarAgendamentosPorDia() {
        $query = "SELECT DAYOFWEEK(data) as dia_semana, COUNT(*) as total 
                  FROM agendamentos
                  GROUP BY dia_semana
                  ORDER BY dia_semana";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $dias = array_fill(1, 7, 0);
        foreach ($resultado as $row) {
            $dias[$row['dia_semana']] = (int)$row['total'];
        }
        return array_values($dias);
    }

    public function buscarSociosMaisAtivos() {
        $query = "SELECT s.nome, COUNT(*) as total_agendamentos 
                  FROM agendamentos a
                  JOIN socios s ON a.socio_id = s.id
                  GROUP BY s.id
                  ORDER BY total_agendamentos DESC
                  LIMIT 10";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
