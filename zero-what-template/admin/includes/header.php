<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - Zero What Solar Admin' : 'Zero What Solar Admin'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        .admin-header {
            background: white;
            padding: 20px 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }
        
        .admin-header h2 {
            color: #1E3A8A;
            margin-bottom: 5px;
            font-weight: 600;
        }
        
        .admin-header .text-muted {
            font-size: 0.95rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #1E3A8A, #3B82F6);
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #3B82F6, #1E3A8A);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 58, 138, 0.3);
        }
        
        .btn-outline-primary {
            border-color: #3B82F6;
            color: #3B82F6;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background: #3B82F6;
            border-color: #3B82F6;
            transform: translateY(-1px);
        }
        
        .form-control:focus {
            border-color: #3B82F6;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        }
        
        .table {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .table thead {
            background: linear-gradient(135deg, #1E3A8A, #3B82F6);
            color: white;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .alert {
            border-radius: 10px;
            border: none;
        }
        
        .badge {
            font-size: 0.8em;
            padding: 0.5em 0.8em;
            border-radius: 6px;
        }
        
        /* Admin Dashboard Specific Styles */
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1E3A8A;
            margin-bottom: 5px;
        }
        
        .recent-activity {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .activity-item {
            padding: 15px 0;
            border-bottom: 1px solid #f1f3f5;
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        /* Mobile toggle button */
        .mobile-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            background: #1E3A8A;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
        }
        
        @media (max-width: 768px) {
            .mobile-toggle {
                display: block;
            }
            
            .stat-card {
                margin-bottom: 1rem;
            }
            
            .admin-header {
                padding: 15px 20px;
                margin-bottom: 20px;
            }
            
            .recent-activity {
                padding: 15px;
            }
            
            .activity-item {
                padding: 10px 0;
                border-bottom: 1px solid #eee;
            }
        }
    </style>
    <?php if (isset($additional_css)) echo $additional_css; ?>
</head>
<body>