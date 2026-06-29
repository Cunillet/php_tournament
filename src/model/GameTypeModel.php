<?php
namespace App\Model;
use App\Script\DB;

class GameTypeModel {
    private DB $db;
    private string $table='tt_game_type';

    public function __construct() {
        $this->db = DB::getInstance();
    }

    public function getGameTypeAll() {
        $query = "SELECT * FROM {$this->table}";
        return $this->db->fetchAll($query);
    }

    public function getGameTypeById(int $id) {
        $sql = "SELECT * FROM {$this->table} WHERE ID = :id";
        return $this->db->fetchOne($sql, ['id' => $id]);
    }

    public function storeGameType(string $name, string $version) {
        $data = [
            'name' => $name,
            'version' => $version,
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