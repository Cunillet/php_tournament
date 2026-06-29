<?php
namespace App\Model;
use App\Script\DB;

class TournamentModel {
    private DB $db;
    private string $table='tt_tournament';

    public function __construct() {
        $this->db = DB::getInstance();
    }

    public function getTournamentAll() {
        $query = "SELECT * FROM {$this->table}";
        return $this->db->fetchAll($query);
    }

    public function getTournamentById(int $id) {
        $sql = "SELECT * FROM {$this->table} WHERE ID = :id";
        return $this->db->fetchOne($sql, ['id' => $id]);
    }

    public function storeTournament(string $name, string $version) {
        $data = [
            'name' => $name,
            'game_id' => $version,
            'created_at' => date('Y-m-d H:i:s', time()),
        ];
        return $this->db->insert($this->table, $data);
    }

    public function updateGameType(int $id, array $data) {
        $where = "id = :id";
        $whereParams = ['id' => $id];

        if (isset($data['name']) || isset($data['version'])) {
            return $this->db->update($this->table, $data, $where, $whereParams);
        }
        return false;
    }

    public function deleteGameType(int $id) {
        return $this->db->delete($this->table, 'id = :id', ['id' => $id]);
    }
}
?>