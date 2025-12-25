<?php
class DashboardController
{
    public function index()
    {
        Auth::requireLogin();
        require_once "../app/views/dashboard.php";
    }
}
