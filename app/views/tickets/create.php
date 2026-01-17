<?php $title = "Create Ticket"; ?>
<?php require_once "../app/views/layout/header.php"; ?>
<?php require_once "../app/views/layout/sidebar.php"; ?>

<h2>Create Ticket</h2>

<div class="card shadow-sm col-md-8">
    <div class="card-body">
		<form method="post"
			  action="/ticketflow/public/tickets/store/<?= $projectId ?>"
			  enctype="multipart/form-data"
			  id="createTicketForm"
			  onsubmit="return handleTicketFormSubmit(event)">


            <div class="mb-3">
                <label class="form-label">Title</label>
                <input name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <div id="ticketDescriptionEditor"></div>
                <input type="hidden" name="description" id="ticketDescription">
            </div>

            <div class="mb-3">
                <label class="form-label">Priority</label>
                <select name="priority" class="form-select">
                    <option value="low">Low</option>
                    <option value="medium" selected>Medium</option>
                    <option value="high">High</option>
                    <option value="critical">Critical</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Assign To</label>
                <select name="assignee_id" class="form-select">
                    <option value="">Unassigned</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?= $user['id'] ?>">
                            <?= htmlspecialchars($user['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
			
			<div class="mb-3">
				<label class="form-label">Attachment (optional)</label>
				<input type="file" name="attachment" class="form-control">
			</div>

            <button class="btn btn-primary">Create Ticket</button>
            <a href="javascript:history.back()" class="btn btn-secondary">
                Cancel
            </a>
        </form>
    </div>
</div>

<!-- Quill.js Rich Text Editor -->
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>

<style>
/* Image resize handles */
.ql-editor img {
    cursor: pointer;
    max-width: 100%;
    height: auto;
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
        }// Initialize Quill editor for ticket description
var ticketQuill = new Quill('#ticketDescriptionEditor', {
    theme: 'snow',
    placeholder: 'Describe the issue in detail...',
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

// Handle image insertion
ticketQuill.getModule('toolbar').addHandler('image', function() {
    const input = document.createElement('input');
    input.setAttribute('type', 'file');
    input.setAttribute('accept', 'image/*');
    input.click();
    
    input.onchange = function() {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const range = ticketQuill.getSelection();
                ticketQuill.insertEmbed(range.index, 'image', e.target.result);
                
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
ticketQuill.on('text-change', function() {
    document.querySelectorAll('.ql-editor img').forEach(img => {
        if (!img.hasAttribute('data-resizable')) {
            makeImageResizable(img);
            img.setAttribute('data-resizable', 'true');
        }
    });
});

// Handle form submission
function handleTicketFormSubmit(event) {
    const descriptionField = document.getElementById('ticketDescription');
    const htmlContent = ticketQuill.root.innerHTML;
    
    // Set the HTML content to the hidden input
    descriptionField.value = htmlContent;
    
    return true;
}
</script>

<?php require_once "../app/views/layout/footer.php"; ?>
