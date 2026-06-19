<?php
require_once __DIR__.'/../model/UserModel.php';

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
            // Get the raw JSON input
            $json = file_get_contents('php://input');
            // Decode JSON to PHP object or array
            $data = json_decode($json, true); // true makes it an associative array
            
            $input = [];
            $input['password'] = $data['password'] ?? '';
            $input['email'] = $data['email'] ?? '';
            
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
            if (!password_verify($input['password'], $user['password'])) {
                http_response_code(400);
                echo json_encode(['error' => 'incorrect email or password']);
                return;
            }

            session_regenerate_id(true);
            $_SESSION['logged_in'] = true;
            $_SESSION['last_activity'] = time();
            $_SESSION['user_id'] = $user['ID'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['name'];
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

    public function logout($redirectHome = true) {
        $_SESSION = array(); // Clear all session variables

        // Delete session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
        if ($redirectHome) {
            http_response_code(200);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true
            ]);
        }
    }

    public function store() {
        try {
            // Get the raw JSON input
            $json = file_get_contents('php://input');
            // Decode JSON to PHP object or array
            $data = json_decode($json, true); // true makes it an associative array
            
            $input = [];
            $input['name'] = $data['name'] ?? '';
            $input['email'] = $data['email'] ?? '';
            $input['password'] = $data['password'] ?? '';
            if (empty($input['name']) || empty($input['email']) || empty($input['password'])) {
                http_response_code(400);

                echo json_encode(['error' => 'name, email and password are required']);
                return;
            }

            if ($this->user->getUserByEmail($input['email'])) {
                http_response_code(409);
                echo json_encode(['error' => 'Email already exists']);
                return;
            }

            $userId = $this->user->createUser(
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
    
            $user = $this->user->getUserById($id);
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
            $affectedRows = $this->user->updateUser($id, $updateData);
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