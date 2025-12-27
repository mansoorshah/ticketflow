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
            SELECT t.*, u.name AS assignee_name
            FROM tickets t
            LEFT JOIN users u ON t.assignee_id = u.id
            WHERE t.project_id = ?
            ORDER BY t.created_at DESC
        ");
        $stmt->execute([$projectId]);
         return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

	public function getAssignedToUser($userId)
	{
		$sql = "
			SELECT t.*, 
				p.name AS project_name,
				u.name AS assignee_name
			FROM tickets t
			LEFT JOIN projects p ON p.id = t.project_id
			LEFT JOIN users u ON u.id = t.assignee_id
			WHERE t.assignee_id = ?
			ORDER BY t.created_at DESC
		";

		$stmt = $this->db->prepare($sql);
		$stmt->execute([$userId]);

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function addCommentAttachment($commentId, $file)
	{
		$allowed = ['jpg','jpeg','png','pdf','docx','xlsx','zip'];
		$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

		if (!in_array($ext, $allowed)) {
			return false;
		}

		if ($file['size'] > 5 * 1024 * 1024) {
			return false; // 5MB limit
		}

		$uploadDir = __DIR__ . '/../../public/uploads/comments/';
		$safeName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file['name']);
		$targetPath = $uploadDir . $safeName;

		if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
			return false;
		}

		$stmt = $this->db->prepare("
			INSERT INTO comment_attachments
			(comment_id, file_name, file_path, file_size)
			VALUES (?, ?, ?, ?)
		");

		return $stmt->execute([
			$commentId,
			$file['name'],
			'uploads/comments/' . $safeName,
			$file['size']
		]);
	}

	public function getCommentAttachments($commentId)
	{
		$stmt = $this->db->prepare("
			SELECT * FROM comment_attachments
			WHERE comment_id = ?
			ORDER BY uploaded_at ASC
		");
		$stmt->execute([$commentId]);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getCommentsWithAttachments($ticketId)
	{
		// Get comments
		$stmt = $this->db->prepare("
			SELECT c.id, c.body, c.created_at, u.name
			FROM ticket_comments c
			JOIN users u ON u.id = c.user_id
			WHERE c.ticket_id = ?
			ORDER BY c.created_at ASC
		");
		$stmt->execute([$ticketId]);
		$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

		// Attach files to each comment
		foreach ($comments as &$comment) {
			$comment['attachments'] = $this->getCommentAttachments($comment['id']);
		}

		return $comments;
	}

	public function countAssignedToUser($userId)
	{
		$stmt = $this->db->prepare("
			SELECT COUNT(*) 
			FROM tickets 
			WHERE assignee_id = ?
		");
		$stmt->execute([$userId]);
		return (int) $stmt->fetchColumn();
	}




}
