<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'TicketFlow' ?></title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f6f8;
        }
        .sidebar {
            height: 100vh;
            background: #1f2937;
            color: #fff;
        }
        .sidebar a {
            color: #cbd5e1;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
            border-radius: 6px;
        }
        .sidebar a:hover {
            background: #374151;
            color: #fff;
        }
        .content {
            padding: 25px;
        }
    </style>
</head>
<body>
