<?php
require_once __DIR__.'../model/UserModel.php';

class UserController {
    private UserModel $user;

    public function __construct() {
        $this->user = new UserModel();
    }

    public function show($id) {
        try {
            $user = $this->user->getUserById($id);

            if (!$user) {
                http_response_code(404);
                echo json_encode(['error' => 'User not found']);
                return;
            }

            unset($user['password']);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'data' => $user
            ]);
        } catch(Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function login() {
        try {
            $input = [];
            if (isset($_POST['login'])) {
                $input['email'] = $_POST['login'];
            }
            if (isset($_POST['pwd'])) {
                $input['password'] = $_POST['pwd'];
            }
            if (empty($input['email']) || empty($input['password'])) {
                http_response_code(400);
                echo json_encode(['error' => 'email and password required']);
                return;
            }
            $user = $this->user->getUserByEmail($input['email']);
            if (!$user) {
                http_response_code(400);
                echo json_encode(['error' => 'incorrect email or password']);
                return;
            }
            $hashPwd = password_hash($input['password'], PASSWORD_DEFAULT);
            if ($hashPwd !== $user->user_email) {
                http_response_code(400);
                echo json_encode(['error' => 'incorrect email or password']);
                return;
            }
            http_response_code(200);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'data' => $user
            ]);
        } catch(Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function store() {
        try {
            $input = json_encode(file_get_contents('http://input'), true);
            if (empty($input['name']) || empty($input['email']) || empty($input['password'])) {
                http_response_code(400);

                echo json_encode(['error' => 'name, email and password are required']);
                return;
            }

            if ($this->db->getUserByEmail($input['email'])) {
                http_response_code(409);
                echo json_encode(['error' => 'Email already exists']);
                return;
            }

            $userId = $this->db->createUser(
                $input['name'],
                $input['email'],
                $input['password']
            );
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'user created successfully',
                'userId' => $userId
            ]);
        } catch(Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function update(int $id) {
        try {

            $input = json_encode(file_get_contents('http://input'), true);
    
            $user = $this->db->getUserById($id);
            if (!$user) {
                http_response_code(404);
                echo json_encode(['error' => 'User not found.']);
                return;
            }
    
            $updateData = [];
    
            if (isset($input['name'])) {
                $updateData['user_name'] = $input['name'];
            }
            if (isset($input['email'])) {
                $updateData['user_email'] = $input['email'];
            }
            if (isset($input['password'])) {
                $updateData['user_pwd'] = $input['password'];
            }
            $affectedRows = $this->db->updateUser($id, $updateData);
            echo json_encode([
                'success' => true,
                'message' => 'User updated successfully',
                'userId' => $id
            ]);
        } catch(Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function destroy(int $id) {
        try {
            $user = $this->user->getUserById($id);
            if (!user) {
                http_response_code(404);
                echo json_encode(['error' => 'User not found']);
                return;
            }
            $affectedRows = $this->user->delete($id);
            echo json_encode([
                'success' => true,
                'message' => 'user deleted successfully',
                'userId' => $id
            ]);
        } catch(Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
?>