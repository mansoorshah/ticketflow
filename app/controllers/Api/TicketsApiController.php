<?php
header('Content-Type: application/json');

class TicketsApiController
{
    public function assigned()
    {
        $user = ApiAuth::requireAuth();

        $ticketModel = new Ticket();
        $tickets = $ticketModel->getAssignedToUser($user['id']);

        echo json_encode([
            'success' => true,
            'data' => $tickets
        ]);
    }

    public function project($projectId)
    {
        $user = ApiAuth::requireAuth();

        if (!$projectId || !is_numeric($projectId)) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => 'Invalid project ID'
            ]);
            return;
        }

        $ticketModel = new Ticket();
        $tickets = $ticketModel->getByProject($projectId);

        echo json_encode([
            'success' => true,
            'data' => $tickets
        ]);
    }

    public function create()
    {
        $user = ApiAuth::requireAuth();
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['project_id']) || empty($data['title'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);
            return;
        }

        $ticketModel = new Ticket();

        $ticketModel->create(
            (int)$data['project_id'],
            trim($data['title']),
            $data['description'] ?? '',
            $data['priority'] ?? 'medium',
            $user['id']
        );

        $ticketId = Database::getInstance()->lastInsertId();

        if (!empty($data['assignee_id'])) {

            $assigneeId = (int)$data['assignee_id'];

            // Check user exists
            $db = Database::getInstance();
            $stmt = $db->prepare("SELECT id FROM users WHERE id = ?");
            $stmt->execute([$assigneeId]);

            if (!$stmt->fetch()) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'error' => 'Invalid assignee_id'
                ]);
                return;
            }

            $ticketModel->assignUser($ticketId, $assigneeId);
        }


        echo json_encode([
            'success' => true,
            'ticket_id' => $ticketId
        ]);
    }


    public function status($ticketId)
    {
        ApiAuth::requireAuth();

        $data = json_decode(file_get_contents("php://input"), true);
        $allowed = ['open', 'in_progress', 'done', 'closed'];

        if (
            !isset($data['status']) ||
            !in_array($data['status'], $allowed)
        ) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid status']);
            return;
        }

        $ticketModel = new Ticket();
        $ticketModel->updateStatus($ticketId, $data['status']);

        echo json_encode(['success' => true]);
    }


}
