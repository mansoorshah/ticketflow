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
}
