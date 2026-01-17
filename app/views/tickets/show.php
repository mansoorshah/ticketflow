<?php $title = "Ticket Details"; ?>
<?php require_once "../app/views/layout/header.php"; ?>
<?php require_once "../app/views/layout/sidebar.php"; ?>

<!-- Quill.js Rich Text Editor Styles -->
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">
        <?= htmlspecialchars($ticket['title']) ?>
    </h2>
    <?php if (Auth::user()['id'] == $ticket['reporter_id'] || Auth::user()['role'] == 'admin'): ?>
        <div class="btn-group">
            <a href="/ticketflow/public/tickets/edit/<?= $ticket['id'] ?>" 
               class="btn btn-sm btn-outline-primary" 
               title="Edit Ticket">
                ✏️ Edit
            </a>
            <button type="button" 
                    class="btn btn-sm btn-outline-danger" 
                    onclick="if(confirm('Are you sure you want to delete this ticket?')) { window.location.href='/ticketflow/public/tickets/delete/<?= $ticket['id'] ?>'; }"
                    title="Delete Ticket">
                🗑️ Delete
            </button>
        </div>
    <?php endif; ?>
</div>

<!-- Ticket Main Info -->
<div class="card shadow-sm mb-4">
    <div class="card-body">



        <!-- Status + Assignment + Metadata -->
        <div class="row g-3">

            <!-- Status -->
            <div class="col-md-3">
                <form method="post"
                      action="/ticketflow/public/tickets/updateStatus/<?= $ticket['id'] ?>" >
                    <label class="form-label fw-bold">Status</label>
                    <select name="status"
                            class="form-select"
                            onchange="this.form.submit()">
                        <?php
                        $statuses = [
                            'open' => 'Open',
                            'in_progress' => 'In Progress',
                            'done' => 'Done',
                            'closed' => 'Closed'
                        ];
                        foreach ($statuses as $key => $label):
                        ?>
                            <option value="<?= $key ?>"
                                <?= $ticket['status'] === $key ? 'selected' : '' ?>>
                                <?= $label ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>

            <!-- Assignee -->
            <div class="col-md-3">
                <form method="post"
                      action="/ticketflow/public/tickets/assign/<?= $ticket['id'] ?>">
                    <label class="form-label fw-bold">Assignee</label>
                    <select name="assignee_id"
                            class="form-select"
                            onchange="this.form.submit()">
                        <option value="">Unassigned</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= $user['id'] ?>"
                                <?= $ticket['assignee_id'] == $user['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($user['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>

            <!-- Reporter -->
            <div class="col-md-3">
                <label class="form-label fw-bold">Reporter</label>
                <div class="form-control bg-light">
                    <?= htmlspecialchars($ticket['reporter']) ?>
                </div>
            </div>

            <!-- Priority -->
            <div class="col-md-3">
                <form method="post"
                      action="/ticketflow/public/tickets/updatePriority/<?= $ticket['id'] ?>">
                    <label class="form-label fw-bold">Priority</label>
                    <select name="priority"
                            class="form-select"
                            onchange="this.form.submit()">
                        <?php
                        $statuses = [
                            'low' => 'Low',
                            'medium' => 'Medium',
                            'high' => 'High',
                            'critical' => 'Critical'
                        ];
                        foreach ($statuses as $key => $label):
                        ?>
                            <option value="<?= $key ?>"
                                <?= $ticket['priority'] === $key ? 'selected' : '' ?>>
                                <?= $label ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- Description -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h5 class="mb-3">Issue Summary</h5>
        <div class="ql-editor ql-container">
            <?= $ticket['description'] ?>
        </div>
    </div>
</div>
<!-- Attachments -->
<?php if (!empty($attachments)): ?>
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h5 class="mb-3">Attachments</h5>
        <ul class="list-group">
            <?php foreach ($attachments as $file): ?>
                <li class="list-group-item">
                    <a href="/ticketflow/public/<?= $file['file_path'] ?>"
                       target="_blank">
                        <?= htmlspecialchars($file['file_name']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<?php endif; ?>

<!-- Comments -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h5 class="mb-4">💬 Comments</h5>

        <?php if (empty($comments)): ?>
            <p class="text-muted">No comments yet.</p>
        <?php endif; ?>

        <div class="comments-list">
            <?php foreach ($comments as $comment): ?>
                <div class="comment-item">
                    <div class="comment-header">
                        <div class="comment-avatar"><?= strtoupper(substr($comment['name'], 0, 1)) ?></div>
                        <div class="comment-meta">
                            <strong class="comment-author"><?= htmlspecialchars($comment['name']) ?></strong>
                            <small class="text-muted comment-time">
                                <?= date('M d, Y \a\t H:i', strtotime($comment['created_at'])) ?>
                            </small>
                        </div>
                        <?php if (Auth::user()['id'] == $comment['user_id'] || Auth::user()['role'] == 'admin'): ?>
                            <div class="ms-auto">
                                <button class="btn btn-sm btn-link text-muted p-0 me-2" 
                                        onclick="editComment(<?= $comment['id'] ?>)" 
                                        title="Edit Comment">
                                    ✏️
                                </button>
                                <button class="btn btn-sm btn-link text-danger p-0" 
                                        onclick="deleteComment(<?= $comment['id'] ?>)" 
                                        title="Delete Comment">
                                    🗑️
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="comment-body">
                        <?= $comment['body'] ?>
                    </div>

                    <?php if (!empty($comment['attachments'])): ?>
                        <div class="comment-attachments">
                            <small class="text-muted">📎 Attachments:</small>
                            <div class="attachments-row">
                                <?php foreach ($comment['attachments'] as $file): ?>
                                    <a href="/ticketflow/public/<?= htmlspecialchars($file['file_path']) ?>"
                                       target="_blank"
                                       class="attachment-link">
                                        📄 <?= htmlspecialchars($file['file_name']) ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>


<!-- Add Comment -->
<div class="card shadow-sm">
    <div class="card-body">
        <h6 class="mb-3">✍️ Add a Comment</h6>
        <form method="post"
              action="/ticketflow/public/tickets/comment/<?= $ticket['id'] ?>" 
              enctype="multipart/form-data"
              id="commentForm"
              onsubmit="return handleFormSubmit(event)">
            <div class="mb-3">
                <div id="commentEditor"></div>
                <input type="hidden" name="body" id="commentBody">
            </div>
            <div class="mb-3">
                <label class="form-label">📎 Attach Files (optional)</label>
                <input type="file" 
                       name="attachments[]" 
                       id="fileInput"
                       class="form-control" 
                       multiple
                       accept=".jpg,.jpeg,.png,.pdf,.docx,.xlsx,.zip,.txt">
                <small class="text-muted">You can select multiple files. Allowed: jpg, png, pdf, docx, xlsx, zip, txt (Max 5MB each)</small>
                <div id="filePreview" class="mt-2"></div>
            </div>
            <button type="submit" class="btn btn-primary rounded-3 px-4 py-2 fw-semibold">
                💬 Post Comment
            </button>
        </form>
    </div>
</div>

<!-- Quill.js Rich Text Editor Script -->
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>

<style>
/* Description area styling */
.ql-container {
    border: none !important;
    font-size: inherit;
}

.ql-editor {
    padding: 12px 0 !important;
}

.ql-editor p {
    margin-bottom: 12px;
}

/* Image resize handles */
.ql-editor img {
    cursor: pointer;
    max-width: 100%;
    height: auto;
    display: inline-block;
}

.ql-editor img.resizing {
    outline: 2px solid #2563eb;
}

.image-resize-handle {
    position: absolute;
    width: 10px;
    height: 10px;
    background: #2563eb;
    border: 2px solid white;
    border-radius: 50%;
    z-index: 100;
}

.image-resize-handle.nw { cursor: nw-resize; }
.image-resize-handle.ne { cursor: ne-resize; }
.image-resize-handle.sw { cursor: sw-resize; }
.image-resize-handle.se { cursor: se-resize; }
</style>

<script>
// Image resizing functionality
let isResizing = false;
let currentImage = null;
let startX, startY, startWidth, startHeight;

function makeImageResizable(img) {
    img.style.cursor = 'pointer';
    
    img.addEventListener('click', function(e) {
        if (!isResizing) {
            selectImage(img);
        }
    });
}

function selectImage(img) {
    // Remove previous selections
    document.querySelectorAll('.ql-editor img').forEach(i => {
        i.classList.remove('resizing');
        i.style.outline = '';
    });
    
    // Remove existing handles
    document.querySelectorAll('.image-resize-handle').forEach(h => h.remove());
    
    img.classList.add('resizing');
    currentImage = img;
    
    // Add four corner resize handles
    const corners = ['nw', 'ne', 'sw', 'se'];
    corners.forEach(corner => {
        const handle = document.createElement('div');
        handle.className = 'image-resize-handle ' + corner;
        handle.dataset.corner = corner;
        positionHandle(img, handle, corner);
        document.body.appendChild(handle);
        handle.addEventListener('mousedown', startResize);
    });
    
    // Click outside to deselect
    setTimeout(() => {
        document.addEventListener('click', function deselectImage(e) {
            if (!img.contains(e.target) && !e.target.classList.contains('image-resize-handle')) {
                img.classList.remove('resizing');
                document.querySelectorAll('.image-resize-handle').forEach(h => h.remove());
                currentImage = null;
                document.removeEventListener('click', deselectImage);
            }
        });
    }, 0);
}

function positionHandle(img, handle, corner) {
    const rect = img.getBoundingClientRect();
    switch(corner) {
        case 'nw':
            handle.style.left = (rect.left + window.scrollX - 5) + 'px';
            handle.style.top = (rect.top + window.scrollY - 5) + 'px';
            break;
        case 'ne':
            handle.style.left = (rect.right + window.scrollX - 5) + 'px';
            handle.style.top = (rect.top + window.scrollY - 5) + 'px';
            break;
        case 'sw':
            handle.style.left = (rect.left + window.scrollX - 5) + 'px';
            handle.style.top = (rect.bottom + window.scrollY - 5) + 'px';
            break;
        case 'se':
            handle.style.left = (rect.right + window.scrollX - 5) + 'px';
            handle.style.top = (rect.bottom + window.scrollY - 5) + 'px';
            break;
    }
}

function startResize(e) {
    e.preventDefault();
    isResizing = true;
    e.target.dataset.corner; // Store which corner
    startX = e.clientX;
    startY = e.clientY;
    startWidth = currentImage.width;
    startHeight = currentImage.height;
    currentImage.dataset.resizeCorner = e.target.dataset.corner;
    
    document.addEventListener('mousemove', doResize);
    document.addEventListener('mouseup', stopResize);
}

function doResize(e) {
    if (!isResizing || !currentImage) return;
    
    const deltaX = e.clientX - startX;
    const deltaY = e.clientY - startY;
    const corner = currentImage.dataset.resizeCorner;
    let delta;
    
    // Calculate delta based on corner being dragged
    switch(corner) {
        case 'se':
        case 'ne':
            delta = Math.max(deltaX, deltaY);
            break;
        case 'sw':
        case 'nw':
            delta = Math.max(-deltaX, -deltaY) * -1;
            break;
    }
    
    const newWidth = Math.max(50, startWidth + delta);
    currentImage.style.width = newWidth + 'px';
    currentImage.style.height = 'auto';
    currentImage.setAttribute('width', newWidth);
    
    // Update all handle positions
    document.querySelectorAll('.image-resize-handle').forEach(handle => {
        positionHandle(currentImage, handle, handle.dataset.corner);
    });
}

        function stopResize() {
            isResizing = false;
            if (currentImage) delete currentImage.dataset.resizeCorner;
            document.removeEventListener('mousemove', doResize);
            document.removeEventListener('mouseup', stopResize);
        }// Initialize Quill editor
var quill = new Quill('#commentEditor', {
    theme: 'snow',
    placeholder: 'Write a comment...',
    modules: {
        toolbar: [
            [{ 'header': [1, 2, 3, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'align': [] }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['blockquote', 'code-block'],
            ['link', 'image'],
            ['clean']
        ]
    }
});

// Handle image paste and drop
quill.getModule('toolbar').addHandler('image', function() {
    const input = document.createElement('input');
    input.setAttribute('type', 'file');
    input.setAttribute('accept', 'image/*');
    input.click();
    
    input.onchange = function() {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const range = quill.getSelection();
                quill.insertEmbed(range.index, 'image', e.target.result);
                
                // Make the newly inserted image resizable
                setTimeout(() => {
                    const images = document.querySelectorAll('.ql-editor img');
                    const lastImage = images[images.length - 1];
                    if (lastImage) makeImageResizable(lastImage);
                }, 100);
            };
            reader.readAsDataURL(file);
        }
    };
});

// Make existing images resizable on load
quill.on('text-change', function() {
    document.querySelectorAll('.ql-editor img').forEach(img => {
        if (!img.hasAttribute('data-resizable')) {
            makeImageResizable(img);
            img.setAttribute('data-resizable', 'true');
        }
    });
});

// File preview functionality with ability to add more files
let filesToUpload = [];
const fileInput = document.getElementById('fileInput');
const filePreview = document.getElementById('filePreview');

fileInput.addEventListener('change', function(e) {
    // Add new files to existing array instead of replacing
    const newFiles = Array.from(this.files);
    filesToUpload = [...filesToUpload, ...newFiles];
    
    // Clear the input so same file can be selected again
    this.value = '';
    
    updateFilePreview();
});

function removeFile(index) {
    filesToUpload.splice(index, 1);
    updateFilePreview();
}

function updateFilePreview() {
    filePreview.innerHTML = '';
    
    if (filesToUpload.length > 0) {
        const filesDiv = document.createElement('div');
        filesDiv.className = 'selected-files mt-2';
        filesDiv.innerHTML = '<strong>Selected files (' + filesToUpload.length + '):</strong>';
        
        filesToUpload.forEach((file, index) => {
            const fileItem = document.createElement('div');
            fileItem.className = 'file-preview-item';
            fileItem.innerHTML = `
                <span class="file-icon">📄</span>
                <span class="file-name">${file.name}</span>
                <span class="file-size">(${(file.size / 1024).toFixed(1)} KB)</span>
                <button type="button" class="btn-remove-file" onclick="removeFile(${index})" title="Remove file">
                    ✕
                </button>
            `;
            filesDiv.appendChild(fileItem);
        });
        
        filePreview.appendChild(filesDiv);
    }
}

// Handle form submission
function handleFormSubmit(event) {
    event.preventDefault();
    
    const commentBody = document.getElementById('commentBody');
    const htmlContent = quill.root.innerHTML;
    const textContent = quill.getText().trim();
    
    // Check if content is empty
    if (textContent.length === 0) {
        alert('Please write a comment before submitting.');
        return false;
    }
    
    // Set the HTML content to the hidden input
    commentBody.value = htmlContent;
    
    // Update file input with all selected files
    if (filesToUpload.length > 0) {
        const dataTransfer = new DataTransfer();
        filesToUpload.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
    }
    
    // Submit the form
    document.getElementById('commentForm').submit();
    return true;
}

// Edit comment function
function editComment(commentId) {
    alert('Edit comment functionality - Comment ID: ' + commentId);
    // TODO: Implement edit comment functionality
    // This would typically open a modal or inline editor
}

// Delete comment function
function deleteComment(commentId) {
    if (confirm('Are you sure you want to delete this comment?')) {
        window.location.href = '/ticketflow/public/tickets/deleteComment/' + commentId;
    }
}
</script>

<?php require_once "../app/views/layout/footer.php"; ?>
