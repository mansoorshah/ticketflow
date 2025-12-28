<?php
class Comment
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getByTicket($ticketId)
    {
        $stmt = $this->db->prepare("
            SELECT c.*, u.name
            FROM comments c
            JOIN users u ON u.id = c.user_id
            WHERE c.ticket_id = ?
            ORDER BY c.created_at ASC
        ");
        $stmt->execute([$ticketId]);
        return $stmt->fetchAll();
    }

    public function create($ticketId, $userId, $body)
    {
        $ticketModel = new Ticket();
        $ticket = $ticketModel->find($ticketId);

        $stmt = $this->db->prepare("
            INSERT INTO comments (ticket_id, user_id, body)
            VALUES (?, ?, ?)
        ");

        $success = $stmt->execute([$ticketId, $userId, $body]);

        if (!$success) {
            return false;
        }

        $commentId = $this->db->lastInsertId();

        $userModel = new User();

        $assignee = $ticket['assignee_id']
            ? $userModel->findById($ticket['assignee_id'])
            : null;


        // Avoid notifying the same user who commented
        if ($assignee && $assignee['id'] !== $userId) {
            Event::dispatch('ticket.commented', [
                'ticket' => $ticket,
                'assignee' => $assignee,
                'comment' => [
                    'id' => $commentId,
                    'body' => $body
                ],
                'actor' => Auth::user()
            ]);
        }

        return $commentId;
}




    public function addAttachment($commentId, $file)
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

    public function getAttachments($commentId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM comment_attachments
            WHERE comment_id = ?
            ORDER BY uploaded_at ASC
        ");
        $stmt->execute([$commentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByTicketWithAttachments($ticketId)
    {
        $stmt = $this->db->prepare("
            SELECT c.*, u.name
            FROM comments c
            JOIN users u ON u.id = c.user_id
            WHERE c.ticket_id = ?
            ORDER BY c.created_at ASC
        ");
        $stmt->execute([$ticketId]);
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($comments as &$comment) {
            $comment['attachments'] = $this->getAttachments($comment['id']);
        }

        return $comments;
    }



}
