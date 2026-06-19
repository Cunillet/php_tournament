<?php
require_once __DIR__.'/../scripts/DB.php';

class UserModel {
    private DB $db;
    private string $table='tt_user';

    public function __construct() {
        $this->db = DB::getInstance();
    }

    public function getUserById(int $id) {
        $sql = "SELECT * FROM {$table} WHERE ID = :id";
        return $this->db->fetchOne($sql, ['id' => $id]);
    }

    public function getUserByEmail(string $email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";
        return $this->db->fetchOne($sql, ['email' => $email]);
    }

    public function createUser(string $name, string $email, string $pwd) {
        $hashPwd = password_hash($pwd, PASSWORD_DEFAULT);
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $hashPwd
        ];
        return $this->db->insert($this->table, $data);
    }

    public function updateUser(int $id, array $data) {
        $where = "id = :id";
        $whereParams = ['id' => $id];

        if (isset($data['user_pwd'])) {
            $data['user_pwd'] = password_hash($data['pwd'], PASSWORD_DEFAULT);
        }
        return $this->db->update($this->table, $data, $where, $whereParams);
    }

    public function deleteUser(int $id) {
        return $this->db->delete($this->table, 'id = :id', ['id' => $id]);
    }
}
?>