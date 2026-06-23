<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\UserModel;

class UserService {
    private UserModel $user;

    public function __construct() {
        $this->user = new UserModel();
    }
    public function getUser(int $id) {
        try {
            $user = $this->user->getUserById($id);
            return $user;
        } catch(Exception $e) {
            return false;
        }
    }

    public function getUserByEmail(string $email, $password) {
            $user = $this->user->getUserByEmail($email);
            if (!$user) {
                return ['error' => 'incorrect email or password', 'code' => 401];
            }
            if (!password_verify($password, $user['password'])) {
                return ['error' => 'incorrect email or password', 'code' => 400];
            }
            return $user;
    }

    public function createUser(array $data) {
        try {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            
            $input = [];
            $input['name'] = $data['name'] ?? '';
            $input['email'] = $data['email'] ?? '';
            $input['password'] = $data['password'] ?? '';
            if (empty($input['name']) || empty($input['email']) || empty($input['password'])) {
                http_response_code(400);

                return ['error' => 'name, email and password are required', 'code' => 400];
            }

            if ($this->user->getUserByEmail($input['email'])) {
                return (['error' => 'Email already exists', 'code' => 409]);
            }

            $userId = $this->user->createUser(
                $input['name'],
                $input['email'],
                $input['password']
            );
            return [
                'success' => true,
                'message' => 'user created successfully',
                'userId' => $userId,
                'code' => 200
            ];
        } catch(Exception $e) {
            return ['error' => $e->getMessage(), 'code' => 500];
        }
    }

    public function createUserSession($user) {
            session_regenerate_id(true);
            $_SESSION['logged_in'] = true;
            $_SESSION['last_activity'] = time();
            $_SESSION['user_id'] = $user['ID'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['name'];
    }

    public function updateUser(int $id, array $data): array {
        if (!isset($this->users[$id])) {
            throw new \Exception('User not found', 404);
        }
        $this->users[$id] = array_merge($this->users[$id], $data);
        return $this->users[$id];
    }

    public function deleteUser(int $id): void {
        if (!isset($this->users[$id])) {
            throw new \Exception('User not found', 404);
        }
        unset($this->users[$id]);
    }
}
