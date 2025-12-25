<?php
class ProjectsController
{
    public function index()
    {
        Auth::requireLogin();

        $projectModel = new Project();
        $projects = $projectModel->all();

        require_once "../app/views/projects/index.php";
    }

    public function create()
    {
        Auth::requireLogin();

        if (Auth::user()['role'] !== 'admin') {
            die("Access denied");
        }

        require_once "../app/views/projects/create.php";
    }

    public function store()
    {
        Auth::requireLogin();

        if (Auth::user()['role'] !== 'admin') {
            die("Access denied");
        }

        $name = trim($_POST['name']);
        $key  = strtoupper(trim($_POST['key']));

        if ($name === '' || $key === '') {
            die("All fields required");
        }

        $projectModel = new Project();
        $projectModel->create($name, $key, Auth::user()['id']);

        header("Location: /ticketflow/public/projects");
        exit;
    }
}
