<?php
class TicketsController
{
    public function index($projectId)
    {
        Auth::requireLogin();

        $ticketModel = new Ticket();
        $tickets = $ticketModel->getByProject($projectId);

        require_once "../app/views/tickets/index.php";
    }

    public function create($projectId)
    {
        Auth::requireLogin();
        
        $ticketModel = new Ticket();
        $users = $ticketModel->users();
        
        require_once "../app/views/tickets/create.php";
    }

	public function store($projectId)
	{
		Auth::requireLogin();

		$title = trim($_POST['title']);
		$description = trim($_POST['description']);
		$priority = $_POST['priority'];
		$assigneeId = !empty($_POST['assignee_id']) ? $_POST['assignee_id'] : null;

		if ($title === '') {
			die("Title is required");
		}

		$ticketModel = new Ticket();

		// Create ticket
		$ticketModel->create(
			$projectId,
			$title,
			$description,
			$priority,
			Auth::user()['id']
		);

		// Get newly created ticket ID
		$ticketId = Database::getInstance()->lastInsertId();

		// Assign user if selected
		if ($assigneeId) {
			$ticketModel->assignUser($ticketId, $assigneeId);
		}

		// Handle attachment
		if (!empty($_FILES['attachment']['name'])) {

			$allowed = ['jpg','png','pdf','docx','txt'];
			$ext = strtolower(pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION));

			if (!in_array($ext, $allowed)) {
				die("Invalid file type");
			}

			$newName = uniqid() . "." . $ext;
			$uploadPath = "uploads/" . $newName;

			move_uploaded_file(
				$_FILES['attachment']['tmp_name'],
				"../public/" . $uploadPath
			);

			$ticketModel->addAttachment(
				$ticketId,
				$_FILES['attachment']['name'],
				$uploadPath
			);
		}

		header("Location: /ticketflow/public/tickets/index/$projectId");
		exit;
	}
	
	public function show($ticketId)
	{
		Auth::requireLogin();

		$ticketModel = new Ticket();
		$commentModel = new Comment();

		$ticket = $ticketModel->find($ticketId);
		$attachments = $ticketModel->attachments($ticketId);
		$comments = $commentModel->getByTicketWithAttachments($ticketId);
		$users = $ticketModel->users();

		require_once "../app/views/tickets/show.php";
	}


	public function comment($ticketId)
	{
		Auth::requireLogin();

		$commentModel = new Comment();
		$userId = Auth::user()['id'];
		$body   = trim($_POST['body'] ?? '');

		if ($body === '') {
			header("Location: /ticketflow/public/tickets/show/$ticketId");
			exit;
		}

		// ✅ 1. Create comment AND capture its ID
		$commentId = $commentModel->create($ticketId, $userId, $body);

		// ✅ 2. Attach multiple files if provided
		if (!empty($_FILES['attachments']['name'][0])) {
			$fileCount = count($_FILES['attachments']['name']);
			
			for ($i = 0; $i < $fileCount; $i++) {
				if ($_FILES['attachments']['error'][$i] === UPLOAD_ERR_OK) {
					$file = [
						'name' => $_FILES['attachments']['name'][$i],
						'type' => $_FILES['attachments']['type'][$i],
						'tmp_name' => $_FILES['attachments']['tmp_name'][$i],
						'error' => $_FILES['attachments']['error'][$i],
						'size' => $_FILES['attachments']['size'][$i]
					];
					
					$commentModel->addAttachment($commentId, $file);
				}
			}
		}

		header("Location: /ticketflow/public/tickets/show/$ticketId");
		exit;
	}


	public function updateStatus($ticketId)
	{
		Auth::requireLogin();

		$status = $_POST['status'];

		$allowed = ['open','in_progress','done','closed'];
		if (!in_array($status, $allowed)) {
			die("Invalid status");
		}

		$ticketModel = new Ticket();
		$ticketModel->updateStatus($ticketId, $status);

		header("Location: /ticketflow/public/tickets/show/$ticketId");
		exit;
	}

	public function assign($ticketId)
	{
		Auth::requireLogin();

		$userId = $_POST['assignee_id'] ?? null;
		$userId = $userId === '' ? null : $userId;
		$ticketModel = new Ticket();
		$ticketModel->assignUser($ticketId, $userId);

		header("Location: /ticketflow/public/tickets/show/$ticketId");
		exit;
	}

	public function updatePriority($ticketId)
	{
		Auth::requireLogin();


			$priority = $_POST['priority'] ?? null;
			$allowed = ['low','medium','high','critical'];

			if (!in_array($priority, $allowed)) {
				header("Location: /ticketflow/public/tickets/show/$ticketId");
				exit;
			}

			$ticketModel = new Ticket();
			$ticketModel->updatePriority($ticketId, $priority);

			header("Location: /ticketflow/public/tickets/show/$ticketId");
			exit;

	}



	public function assigned()
	{
		Auth::requireLogin();

		$userId = Auth::user()['id'];

		$ticketModel = new Ticket();
		$tickets = $ticketModel->getAssignedToUser($userId);

		require_once "../app/views/tickets/assigned_to_me.php";
	}

	public function delete($ticketId)
	{
		Auth::requireLogin();

		$ticketModel = new Ticket();
		$ticket = $ticketModel->find($ticketId);

		// Check if user is authorized (ticket creator or admin)
		if (Auth::user()['id'] != $ticket['reporter_id'] && Auth::user()['role'] != 'admin') {
			die("Unauthorized");
		}

		$projectId = $ticket['project_id'];
		$ticketModel->delete($ticketId);

		header("Location: /ticketflow/public/tickets/index/$projectId");
		exit;
	}

	public function deleteComment($commentId)
	{
		Auth::requireLogin();

		$commentModel = new Comment();
		$comment = $commentModel->getById($commentId);

		if (!$comment) {
			die("Comment not found");
		}

		// Check if user is authorized (comment creator or admin)
		if (Auth::user()['id'] != $comment['user_id'] && Auth::user()['role'] != 'admin') {
			die("Unauthorized");
		}

		$ticketId = $comment['ticket_id'];
		$commentModel->delete($commentId);

		header("Location: /ticketflow/public/tickets/show/$ticketId");
		exit;
	}

}
