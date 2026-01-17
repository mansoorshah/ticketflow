<?php

class DashboardController
{
    public function index()
    {
        Auth::requireLogin();
        
        $ticketModel = new Ticket();
        $userId = Auth::user()['id'];
        
        $assignedCount = $ticketModel->countAssignedToUser($userId);
        $assignedOverTime = $ticketModel->getAssignedOverTime($userId, 30);
        $recentTickets = $ticketModel->getRecentTickets(5);
        $criticalTickets = $ticketModel->getCriticalTickets(5);
        
        require_once "../app/views/dashboard.php";
    }
}