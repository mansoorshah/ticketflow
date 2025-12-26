<?php
header('Content-Type: application/json');

class ProjectsApiController
{
    public function index()
    {
        ApiAuth::requireAuth();

        $projectModel = new Project();
        $projects = $projectModel->all(); // ✅ correct method

        echo json_encode([
            'success' => true,
            'data' => $projects
        ]);
    }

    public function show($id)
    {
        ApiAuth::requireAuth();

        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid project ID']);
            return;
        }

        $projectModel = new Project();
        $project = $projectModel->find($id);

        if (!$project) {
            http_response_code(404);
            echo json_encode(['error' => 'Project not found']);
            return;
        }

        echo json_encode([
            'success' => true,
            'data' => $project
        ]);
    }
}
