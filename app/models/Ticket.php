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
		$ticket = $this->find($ticketId);

		$oldStatus = $ticket['status'];

		$stmt = $this->db->prepare("
			UPDATE tickets
			SET status = ?, updated_at = NOW()
			WHERE id = ?
		");

		$success = $stmt->execute([$status, $ticketId]);

		if (!$success || $oldStatus === $status) {
			return false;
		}

		$userModel = new User();

		$assignee = $ticket['assignee_id']
			? $userModel->findById($ticket['assignee_id'])
			: null;


		Event::dispatch('ticket.status_changed', [
			'ticket' => $ticket,
			'oldStatus' => $oldStatus,
			'newStatus' => $status,
			'assignee' => $assignee
		]);

		return true;
	}


	public function assignUser($ticketId, $userId)
	{
		$ticket = $this->find($ticketId);

		$userModel = new User();

		$oldAssignee = $ticket['assignee_id']
			? $userModel->findById($ticket['assignee_id'])
			: null;

		$newAssignee = $userId
			? $userModel->findById($userId)
			: null;

		$stmt = $this->db->prepare("
			UPDATE tickets
			SET assignee_id = ?, updated_at = NOW()
			WHERE id = ?
		");

		$userId = empty($userId) ? null : $userId;

		$success = $stmt->execute([$userId, $ticketId]);

		if (!$success) {
			return false;
		}

		// 🔔 EVENTS AFTER SUCCESS
		if ($newAssignee && (!$oldAssignee || $oldAssignee['id'] !== $newAssignee['id'])) {
			Event::dispatch('ticket.assigned', [
				'ticket' => $ticket,
				'assignee' => $newAssignee,
				'oldAssignee' => $oldAssignee
			]);
		}

		if ($oldAssignee && (!$newAssignee || $oldAssignee['id'] !== $newAssignee['id'])) {
			Event::dispatch('ticket.unassigned', [
				'ticket' => $ticket,
				'oldAssignee' => $oldAssignee,
				'newAssignee' => $newAssignee
			]);
		}

		return true;
	}



	public function users()
	{
		$stmt = $this->db->query("SELECT id, name FROM users ORDER BY name");
		return $stmt->fetchAll();
	}

	public function updatePriority($ticketId, $priority)
	{
		$ticket = $this->find($ticketId);

		$oldPriority = $ticket['priority'];

		$stmt = $this->db->prepare("
			UPDATE tickets
			SET priority = :priority, updated_at = NOW()
			WHERE id = :id
		");

		$success = $stmt->execute([
			'priority' => $priority,
			'id' => $ticketId
		]);

		if (!$success || $oldPriority === $priority) {
			return false;
		}

		$userModel = new User();

		$assignee = $ticket['assignee_id']
			? $userModel->findById($ticket['assignee_id'])
			: null;


		Event::dispatch('ticket.priority_changed', [
			'ticket' => $ticket,
			'oldPriority' => $oldPriority,
			'newPriority' => $priority,
			'assignee' => $assignee
		]);

		return true;
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

	public function getAssignedOverTime($userId, $days = 30)
	{
		$stmt = $this->db->prepare("
			SELECT DATE(created_at) as date, COUNT(*) as count
			FROM tickets
			WHERE assignee_id = ?
			AND created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
			GROUP BY DATE(created_at)
			ORDER BY date ASC
		");
		$stmt->execute([$userId, $days]);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getRecentTickets($limit = 10)
	{
		$stmt = $this->db->prepare("
			SELECT t.*, 
				   u.name AS assignee_name,
				   p.name AS project_name
			FROM tickets t
			LEFT JOIN users u ON t.assignee_id = u.id
			LEFT JOIN projects p ON t.project_id = p.id
			ORDER BY t.created_at DESC
			LIMIT ?
		");
		$stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getCriticalTickets($limit = 10)
	{
		$stmt = $this->db->prepare("
			SELECT t.*, 
				   u.name AS assignee_name,
				   p.name AS project_name
			FROM tickets t
			LEFT JOIN users u ON t.assignee_id = u.id
			LEFT JOIN projects p ON t.project_id = p.id
			WHERE t.priority = 'critical'
			AND t.status NOT IN ('done', 'closed')
			ORDER BY t.created_at DESC
			LIMIT ?
		");
		$stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function delete($ticketId)
	{
		// Delete attachments first
		$stmt = $this->db->prepare("DELETE FROM ticket_attachments WHERE ticket_id = ?");
		$stmt->execute([$ticketId]);

		// Delete comment attachments
		$stmt = $this->db->prepare("
			DELETE FROM comment_attachments 
			WHERE comment_id IN (SELECT id FROM comments WHERE ticket_id = ?)
		");
		$stmt->execute([$ticketId]);

		// Delete comments
		$stmt = $this->db->prepare("DELETE FROM comments WHERE ticket_id = ?");
		$stmt->execute([$ticketId]);

		// Delete ticket
		$stmt = $this->db->prepare("DELETE FROM tickets WHERE id = ?");
		return $stmt->execute([$ticketId]);
	}


}
