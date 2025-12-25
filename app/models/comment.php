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
        $stmt = $this->db->prepare("
            INSERT INTO comments (ticket_id, user_id, body)
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([$ticketId, $userId, $body]);
    }
}
