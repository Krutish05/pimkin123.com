<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = pg_escape_string($_POST['title']);
    $content = pg_escape_string($_POST['content']);
   
    $result = pg_query_params(
        $conn,
        "INSERT INTO articles (title, content) VALUES ($1, $2)",
        [$title, $content]
    );
   
    if ($result) {
        header("Location: ../pages/articles.php");
        exit;
    } else {
        $error = pg_last_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить статью</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --secondary: #3f37c9;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --success: #4bb543;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f5f7ff;
            color: var(--dark);
            line-height: 1.6;
        }
        
        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            margin-bottom: 30px;
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 20px 30px;
            position: relative;
        }
        
        .card-header h1 {
            font-size: 24px;
            font-weight: 600;
        }
        
        .card-body {
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-family: inherit;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }
        
        textarea.form-control {
            min-height: 200px;
            resize: vertical;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
        }
        
        .btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        .btn i {
            margin-right: 8px;
        }
        
        .back-link {
            display: inline-flex;
            align-items: center;
            color: var(--gray);
            text-decoration: none;
            margin-top: 20px;
            transition: color 0.3s;
        }
        
        .back-link:hover {
            color: var(--primary);
        }
        
        .back-link i {
            margin-right: 6px;
        }
        
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        
        .alert-danger {
            background-color: #fdecea;
            color: #d32f2f;
            border-left: 4px solid #d32f2f;
        }
        
        .alert i {
            margin-right: 10px;
        }
        
        .floating-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 20px rgba(67, 97, 238, 0.3);
            cursor: pointer;
            transition: all 0.3s;
            z-index: 100;
            text-decoration: none;
        }
        
        .floating-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-3px) scale(1.05);
        }
        
        @media (max-width: 768px) {
            .container {
                margin: 20px auto;
            }
            
            .card-header h1 {
                font-size: 20px;
            }
            
            .card-body {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1><i class="fas fa-plus-circle"></i> Новая статья</h1>
            </div>
            <div class="card-body">
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> Ошибка: <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="title"><i class="fas fa-heading"></i> Заголовок</label>
                        <input type="text" id="title" name="title" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="content"><i class="fas fa-align-left"></i> Содержание</label>
                        <textarea id="content" name="content" class="form-control" required></textarea>
                    </div>
                    
                    <button type="submit" class="btn">
                        <i class="fas fa-save"></i> Опубликовать
                    </button>
                </form>
                
                <a href="../pages/articles.php" class="back-link">
                    <i class="fas fa-arrow-left"></i> Вернуться к списку статей
                </a>
            </div>
        </div>
    </div>
    
    <a href="../pages/articles.php" class="floating-btn">
        <i class="fas fa-list"></i>
    </a>
</body>
</html>