<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'TicketFlow' ?></title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/ticketflow/public/assets/css/app.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    <style>
        :root {
            --bg-primary: #ffffff;
            --bg-secondary: #f5f6f8;
            --text-primary: #111827;
            --text-secondary: #6b7280;
            --sidebar-bg: #1f2937;
            --sidebar-text: #cbd5e1;
            --sidebar-hover: #374151;
            --card-bg: #ffffff;
            --border-color: #e5e7eb;
        }

        [data-theme="dark"] {
            --bg-primary: #111827;
            --bg-secondary: #1f2937;
            --text-primary: #f9fafb;
            --text-secondary: #9ca3af;
            --sidebar-bg: #0f172a;
            --sidebar-text: #cbd5e1;
            --sidebar-hover: #1e293b;
            --card-bg: #1f2937;
            --border-color: #374151;
        }

        body {
            background-color: var(--bg-secondary);
            color: var(--text-primary);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .sidebar {
            min-height: 100vh;
            background: var(--sidebar-bg);
            color: #fff;
        }

        .sidebar a {
            color: var(--sidebar-text);
            text-decoration: none;
            display: block;
            padding: 10px 15px;
            border-radius: 6px;
        }

        .sidebar a:hover {
            background: var(--sidebar-hover);
            color: #fff;
        }

        .content {
            padding: 25px;
        }

        .card {
            background-color: var(--card-bg);
            border-color: var(--border-color);
            color: var(--text-primary);
        }

        .form-control, .form-select {
            background-color: var(--card-bg);
            color: var(--text-primary);
            border-color: var(--border-color);
        }

        [data-theme="dark"] .form-control:focus,
        [data-theme="dark"] .form-select:focus {
            background-color: var(--card-bg);
            color: var(--text-primary);
        }

        .table {
            color: var(--text-primary);
        }

        [data-theme="dark"] .table-light {
            background-color: #374151;
            color: var(--text-primary);
        }

        [data-theme="dark"] .table-hover tbody tr:hover {
            background-color: #374151;
        }

        [data-theme="dark"] .text-muted {
            color: #9ca3af !important;
        }

        [data-theme="dark"] h1, 
        [data-theme="dark"] h2, 
        [data-theme="dark"] h3, 
        [data-theme="dark"] h4, 
        [data-theme="dark"] h5, 
        [data-theme="dark"] h6 {
            color: var(--text-primary);
        }

        [data-theme="dark"] .card-title {
            color: var(--text-primary);
        }

        [data-theme="dark"] a {
            color: #60a5fa;
        }

        [data-theme="dark"] a:hover {
            color: #93c5fd;
        }

        .ticket-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .ticket-item {
            display: block;
            padding: 14px 16px;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            background-color: var(--card-bg);
            text-decoration: none;
            transition: all 0.2s ease;
            color: var(--text-primary);
        }

        .ticket-item:hover {
            border-color: #2563eb;
            background-color: var(--bg-secondary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
        }

        .ticket-item h6 {
            color: var(--text-primary);
            font-weight: 600;
            font-size: 0.95rem;
        }

        .ticket-item small {
            font-size: 0.8rem;
        }

        [data-theme="dark"] .ticket-item:hover {
            border-color: #60a5fa;
            background-color: #374151;
            box-shadow: 0 4px 12px rgba(96, 165, 250, 0.2);
        }

        [data-theme="dark"] .bg-light {
            background-color: var(--card-bg) !important;
            color: var(--text-primary);
        }

        [data-theme="dark"] .form-label {
            color: var(--text-primary);
        }

        [data-theme="dark"] .list-group-item {
            background-color: var(--card-bg);
            border-color: var(--border-color);
            color: var(--text-primary);
        }

        /* Comments Styling */
        .comments-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .comment-item {
            padding: 16px;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            background-color: var(--bg-secondary);
            transition: all 0.2s ease;
        }

        .comment-item:hover {
            border-color: #2563eb;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.1);
        }

        [data-theme="dark"] .comment-item:hover {
            border-color: #60a5fa;
            box-shadow: 0 2px 8px rgba(96, 165, 250, 0.15);
        }

        .comment-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .comment-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
        }

        .comment-meta {
            flex: 1;
        }

        .comment-author {
            display: block;
            font-size: 0.95rem;
            color: var(--text-primary);
        }

        .comment-time {
            display: block;
            font-size: 0.8rem;
            margin-top: 2px;
        }

        .comment-body {
            padding-left: 52px;
            color: var(--text-primary);
            line-height: 1.6;
        }

        .comment-attachments {
            padding-left: 52px;
            margin-top: 12px;
        }

        .attachments-row {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 6px;
        }

        .attachment-link {
            display: inline-block;
            padding: 6px 12px;
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            text-decoration: none;
            color: #2563eb;
            font-size: 0.85rem;
            transition: all 0.2s ease;
            width: fit-content;
        }

        .attachment-link:hover {
            background-color: #eff6ff;
            border-color: #2563eb;
        }

        [data-theme="dark"] .attachment-link {
            color: #60a5fa;
        }

        [data-theme="dark"] .attachment-link:hover {
            background-color: #1e3a8a;
            border-color: #60a5fa;
        }

        /* Quill Editor Styling */
        .ql-container {
            font-size: 14px;
            border-radius: 0 0 8px 8px;
        }
        
        .ql-editor {
            min-height: 180px;
            max-height: 300px;
            overflow-y: auto !important;
        }

        .ql-toolbar.ql-snow {
            border-radius: 8px 8px 0 0;
            background-color: var(--bg-secondary);
            border-color: var(--border-color);
        }

        .ql-container.ql-snow {
            background-color: var(--card-bg);
            border-color: var(--border-color);
        }

        .ql-editor.ql-blank::before {
            color: var(--text-secondary);
            font-style: normal;
        }
        
        [data-theme="dark"] .ql-toolbar.ql-snow {
            background-color: var(--card-bg);
            border-color: var(--border-color);
        }
        
        [data-theme="dark"] .ql-container.ql-snow {
            background-color: var(--card-bg);
            border-color: var(--border-color);
        }
        
        [data-theme="dark"] .ql-editor {
            color: var(--text-primary);
        }

        [data-theme="dark"] .ql-editor.ql-blank::before {
            color: var(--text-secondary);
        }
        
        [data-theme="dark"] .ql-stroke {
            stroke: var(--text-primary);
        }
        
        [data-theme="dark"] .ql-fill {
            fill: var(--text-primary);
        }
        
        [data-theme="dark"] .ql-picker-label {
            color: var(--text-primary);
        }
        
        [data-theme="dark"] .ql-snow .ql-picker-options {
            background-color: var(--card-bg);
            border-color: var(--border-color);
        }

        [data-theme="dark"] .ql-toolbar button:hover,
        [data-theme="dark"] .ql-toolbar button:focus,
        [data-theme="dark"] .ql-toolbar button.ql-active {
            color: #60a5fa;
        }

        [data-theme="dark"] .ql-toolbar button:hover .ql-stroke,
        [data-theme="dark"] .ql-toolbar button:focus .ql-stroke,
        [data-theme="dark"] .ql-toolbar button.ql-active .ql-stroke {
            stroke: #60a5fa;
        }

        [data-theme="dark"] .ql-toolbar button:hover .ql-fill,
        [data-theme="dark"] .ql-toolbar button:focus .ql-fill,
        [data-theme="dark"] .ql-toolbar button.ql-active .ql-fill {
            fill: #60a5fa;
        }

        /* File Preview Styling */
        .selected-files {
            padding: 12px;
            background-color: var(--bg-secondary);
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }

        .selected-files strong {
            display: block;
            margin-bottom: 8px;
            color: var(--text-primary);
            font-size: 0.9rem;
        }

        .file-preview-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 10px;
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            margin-top: 6px;
            transition: all 0.2s ease;
        }

        .file-preview-item:hover {
            border-color: #2563eb;
        }

        .file-icon {
            font-size: 18px;
        }

        .file-name {
            flex: 1;
            font-size: 0.9rem;
            color: var(--text-primary);
            word-break: break-word;
        }

        .file-size {
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        .btn-remove-file {
            background: #dc2626;
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .btn-remove-file:hover {
            background: #b91c1c;
            transform: scale(1.1);
        }

        .theme-toggle {
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 6px;
            background: var(--sidebar-hover);
            color: var(--sidebar-text);
            border: none;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .theme-toggle:hover {
            background: #4b5563;
        }

        /* Button styling for dark mode */
        [data-theme="dark"] .btn-primary {
            color: #ffffff !important;
        }

        /* Avatar styling */
        .avatar-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-text {
            color: white;
            font-size: 28px;
            font-weight: bold;
        }

        /* DataTables Dark Mode */
        [data-theme="dark"] .dataTables_wrapper {
            color: var(--text-primary);
        }

        [data-theme="dark"] table.dataTable {
            background-color: var(--card-bg);
            color: var(--text-primary);
            border-color: var(--border-color);
        }

        [data-theme="dark"] table.dataTable thead th,
        [data-theme="dark"] table.dataTable thead td {
            background-color: #374151;
            color: var(--text-primary);
            border-bottom: 2px solid var(--border-color);
        }

        [data-theme="dark"] table.dataTable tbody tr {
            background-color: var(--card-bg);
            color: var(--text-primary);
        }

        [data-theme="dark"] table.dataTable tbody tr:hover {
            background-color: #374151 !important;
        }

        [data-theme="dark"] table.dataTable tbody td {
            border-color: var(--border-color);
        }

        [data-theme="dark"] .dataTables_info,
        [data-theme="dark"] .dataTables_length label,
        [data-theme="dark"] .dataTables_filter label {
            color: var(--text-primary);
        }

        [data-theme="dark"] .dataTables_length select,
        [data-theme="dark"] .dataTables_filter input {
            background-color: var(--card-bg);
            color: var(--text-primary);
            border-color: var(--border-color);
        }

        [data-theme="dark"] .dataTables_paginate .paginate_button {
            color: var(--text-primary) !important;
            background-color: var(--card-bg);
            border-color: var(--border-color);
        }

        [data-theme="dark"] .dataTables_paginate .paginate_button:hover {
            color: #fff !important;
            background-color: #2563eb;
            border-color: #2563eb;
        }

        [data-theme="dark"] .dataTables_paginate .paginate_button.current {
            color: #fff !important;
            background-color: #2563eb;
            border-color: #2563eb;
        }

        [data-theme="dark"] .dataTables_paginate .paginate_button.disabled {
            color: var(--text-secondary) !important;
            background-color: var(--bg-secondary);
        }

        [data-theme="dark"] .dt-buttons .dt-button {
            background-color: var(--card-bg);
            color: var(--text-primary);
            border-color: var(--border-color);
        }

        [data-theme="dark"] .dt-buttons .dt-button:hover {
            background-color: #374151;
            border-color: #2563eb;
        }

        [data-theme="dark"] table.dataTable.no-footer {
            border-bottom: 1px solid var(--border-color);
        }

        [data-theme="dark"] .dataTables_wrapper .dataTables_paginate {
            color: var(--text-primary);
        }
    </style>
    <script>
        // Apply theme before page renders to prevent flash
        (function() {
            const theme = localStorage.getItem('theme') || 
                         (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>
</head>
<body>
