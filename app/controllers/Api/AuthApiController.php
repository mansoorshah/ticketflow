<?php
header('Content-Type: application/json');

class AuthApiController
{
    public function login()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['email']) || empty($data['password'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing credentials']);
            return;
        }

        $userModel = new User();
        $user = $userModel->findByEmail($data['email']);

        if (!$user || !password_verify($data['password'], $user['password'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Invalid credentials']);
            return;
        }

        $token = bin2hex(random_bytes(32));

        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE users SET api_token = ? WHERE id = ?");
        $stmt->execute([$token, $user['id']]);

        echo json_encode([
            'success' => true,
            'token' => $token
        ]);
    }

    public function me()
    {
        $user = ApiAuth::requireAuth();

        unset($user['password'], $user['api_token']);

        echo json_encode([
            'success' => true,
            'data' => $user
        ]);
    }
}
