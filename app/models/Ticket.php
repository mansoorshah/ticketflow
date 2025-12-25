<?php
class Ticket
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getByProject($projectId)
    {
        $stmt = $this->db->prepare("
            SELECT t.*, u.name AS assignee
            FROM tickets t
            LEFT JOIN users u ON u.id = t.assignee_id
            WHERE t.project_id = ?
            ORDER BY t.created_at DESC
        ");
        $stmt->execute([$projectId]);
        return $stmt->fetchAll();
    }

    public function create($projectId, $title, $description, $priority, $reporterId)
    {
        $stmt = $this->db->prepare("
            INSERT INTO tickets
            (project_id, title, description, priority, reporter_id)
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $projectId,
            $title,
            $description,
            $priority,
            $reporterId
        ]);
    }
	
	public function addAttachment($ticketId, $fileName, $filePath)
	{
		$stmt = $this->db->prepare("
			INSERT INTO ticket_attachments (ticket_id, file_name, file_path)
			VALUES (?, ?, ?)
		");
		return $stmt->execute([$ticketId, $fileName, $filePath]);
	}
	
	public function find($ticketId)
	{
		$stmt = $this->db->prepare("
			SELECT t.*, 
				   u1.name AS reporter,
				   u2.name AS assignee
			FROM tickets t
			LEFT JOIN users u1 ON u1.id = t.reporter_id
			LEFT JOIN users u2 ON u2.id = t.assignee_id
			WHERE t.id = ?
		");
		$stmt->execute([$ticketId]);
		return $stmt->fetch();
	}

	public function attachments($ticketId)
	{
		$stmt = $this->db->prepare("
			SELECT * FROM ticket_attachments
			WHERE ticket_id = ?
		");
		$stmt->execute([$ticketId]);
		return $stmt->fetchAll();
	}

	public function updateStatus($ticketId, $status)
	{
		$stmt = $this->db->prepare("
			UPDATE tickets SET status = ?, updated_at = NOW()
			WHERE id = ?
		");
		return $stmt->execute([$status, $ticketId]);
	}

	public function assignUser($ticketId, $userId)
	{
		$stmt = $this->db->prepare("
			UPDATE tickets SET assignee_id = ?, updated_at = NOW()
			WHERE id = ?
		");
		$userId = empty($userId) ? null : $userId;
		return $stmt->execute([$userId, $ticketId]);
	}

	public function users()
	{
		$stmt = $this->db->query("SELECT id, name FROM users ORDER BY name");
		return $stmt->fetchAll();
	}

	public function updatePriority($ticketId, $priority)
	{
		$stmt = $this->db->prepare(
			"UPDATE tickets SET priority = :priority WHERE id = :id"
		);
		return $stmt->execute([
			'priority' => $priority,
			'id' => $ticketId
		]);
	}


}
