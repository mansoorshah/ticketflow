<?php
class Project
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function all()
    {
        $stmt = $this->db->query("SELECT * FROM projects ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function create($name, $key, $userId)
    {
        $stmt = $this->db->prepare("
            INSERT INTO projects (name, project_key, created_by)
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([$name, $key, $userId]);
    }
}
