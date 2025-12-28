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
        body {
            background-color: #f5f6f8;
        }
        .sidebar {
            min-height: 100vh;
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
