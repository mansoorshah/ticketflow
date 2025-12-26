<?php

require "../app/views/dashboard.php";
class DashboardController
{
    public function index()
    {
        Auth::requireLogin();
        require_once "../app/views/dashboard.php";
        $ticketModel = new Ticket();
        $userId = $_SESSION['user']['id'];
        $assignedCount = $ticketModel->countAssignedToUser($userId);
    }
}
