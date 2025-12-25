<?php
class ApiAuth
{
    public static function user()
    {
        $headers = getallheaders();

        if (!isset($headers['Authorization'])) {
            return null;
        }

        if (!preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
            return null;
        }

        $token = $matches[1];

        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM users WHERE api_token = ?");
        $stmt->execute([$token]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function requireAuth()
    {
        $user = self::user();

        if (!$user) {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'error' => 'Unauthorized'
            ]);
            exit;
        }

        return $user;
    }
}
