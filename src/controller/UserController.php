<?php
namespace App\Controller;

use App\Controller\BaseController;
use App\Service\UserService;
use App\Helper\ViewHelper;

class UserController extends BaseController {
    private UserService $user;

    public function __construct()
    {
        $this->user = new UserService();
    }

    public function show($id) {
        $user = $this->user->getUser($id);

        if (!$user) {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
            ViewHelper::loadWithMasterView('views/404.php');
        }

        unset($user['password']);
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => $user
        ]);
    }

    public function loginView() {
        ViewHelper::loadWithMasterView('views/profile/login.php');
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
            $data = $this->user->getUserByEmail($input['email'], $input['password']);
            if (isset($user['error'])) {
                http_response_code($data['code']);
                echo json_encode($data);
                return;
            }

            session_regenerate_id(true);
            $_SESSION['logged_in'] = true;
            $_SESSION['last_activity'] = time();
            $_SESSION['user_id'] = $data['ID'];
            $_SESSION['user_email'] = $data['email'];
            $_SESSION['user_name'] = $data['name'];
            http_response_code(200);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'data' => $data
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

    public function storeView() {
        ViewHelper::loadWithMasterView('views/profile/register.php');
    }

    public function store() {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        $input = [];
        $input['name'] = $data['name'] ?? '';
        $input['email'] = $data['email'] ?? '';
        $input['password'] = $data['password'] ?? '';
        $response = $this->user->createUser($input);
        
        return $this->jsonResponse($response, $response['code']);
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