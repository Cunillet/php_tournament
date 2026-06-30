<?php
namespace App\Model;
use App\Script\DB;

class TournamentPlayerModel {
    private DB $db;
    private string $table='tt_tournament_player';

    public function __construct() {
        $this->db = DB::getInstance();
    }

    public function getTournamentPlayersCount(string $id) {
        $sql = "SELECT * FROM {$this->table} WHERE tournament_id = :id";
        return $this->db->rowsCount($sql, ['id' => $id]);
    }

    public function getTournamentPlayers(string $id) {
        $sql = "SELECT * FROM {$this->table} WHERE tournament_id = :id";
        return $this->db->fetchAll($sql, ['id' => $id]);
    }

    public function getTournamentPlayer(string $id, string $userId) {
        $sql = "SELECT * FROM {$this->table} WHERE tournament_id = :id AND user_id = :userId";
        return $this->db->fetchOne($sql, ['id' => $id, 'userId' => $userId]);
    }

    public function storeTournamentPlayer(string $id, string $userId) {
        $data = [
            'tournament_id' => $id,
            'user_id' => $userId,
        ];
        return $this->db->insert($this->table, $data);
    }

    public function deleteTournamentPlayer(int $id, string $userId) {
        $data = [
            'tournament_id' => $id,
            'user_id' => $userId,
        ];
        return $this->db->delete(
            $this->table,
            'tournament_id = :id AND user_id = :userId',
            ['id' => $id, 'userId' => $userId]
        );
    }
}
?>