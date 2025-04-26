<?php
include '../includes/db.php';

// Обработка успешного добавления
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $success_message = "Статья успешно добавлена!";
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Статьи</title>
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
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark);
            display: flex;
            align-items: center;
        }
        
        .page-title i {
            margin-right: 12px;
            color: var(--primary);
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
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }
        
        .btn i {
            margin-right: 8px;
        }
        
        .article-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            margin-bottom: 25px;
            transition: all 0.3s;
            border-left: 4px solid var(--primary);
        }
        
        .article-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .article-header {
            padding: 20px;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .article-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--dark);
        }
        
        .article-date {
            font-size: 14px;
            color: var(--gray);
            display: flex;
            align-items: center;
        }
        
        .article-date i {
            margin-right: 6px;
            font-size: 12px;
        }
        
        .article-content {
            padding: 20px;
            color: #555;
        }
        
        .article-actions {
            padding: 15px 20px;
            background: #f9f9f9;
            display: flex;
            justify-content: flex-end;
            border-top: 1px solid #f0f0f0;
        }
        
        .action-btn {
            background: none;
            border: none;
            color: var(--gray);
            cursor: pointer;
            margin-left: 15px;
            font-size: 14px;
            transition: color 0.3s;
            display: flex;
            align-items: center;
        }
        
        .action-btn:hover {
            color: var(--primary);
        }
        
        .action-btn i {
            margin-right: 5px;
        }
        
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        
        .alert-success {
            background-color: #edf7ed;
            color: var(--success);
            border-left: 4px solid var(--success);
        }
        
        .alert i {
            margin-right: 10px;
        }
        
        .empty-state {
            text-align: center;
            padding: 50px 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .empty-state i {
            font-size: 50px;
            color: var(--gray);
            margin-bottom: 20px;
        }
        
        .empty-state h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color: var(--dark);
        }
        
        .empty-state p {
            color: var(--gray);
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            .container {
                margin: 20px auto;
            }
            
            .header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .page-title {
                margin-bottom: 15px;
            }
            
            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="page-title"><i class="fas fa-newspaper"></i> Все статьи</h1>
            <a href="../pages/add_article.php" class="btn">
                <i class="fas fa-plus"></i> Новая статья
            </a>
        </div>
        
        <?php if(isset($success_message)): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        
        <?php
        $result = pg_query($conn, "SELECT * FROM articles ORDER BY created_at DESC");
        if (pg_num_rows($result) > 0): 
            while ($row = pg_fetch_assoc($result)): 
                $date = date('d.m.Y H:i', strtotime($row['created_at']));
        ?>
            <div class="article-card">
                <div class="article-header">
                    <h2 class="article-title"><?php echo htmlspecialchars($row['title']); ?></h2>
                    <div class="article-date">
                        <i class="far fa-clock"></i> <?php echo $date; ?>
                    </div>
                </div>
                <div class="article-content">
                    <?php echo nl2br(htmlspecialchars($row['content'])); ?>
                </div>
                <div class="article-actions">
                    <button class="action-btn">
                        <i class="far fa-edit"></i> Редактировать
                    </button>
                    <button class="action-btn">
                        <i class="far fa-trash-alt"></i> Удалить
                    </button>
                </div>
            </div>
        <?php 
            endwhile; 
        else: 
        ?>
            <div class="empty-state">
                <i class="far fa-newspaper"></i>
                <h3>Статей пока нет</h3>
                <p>Вы можете создать первую статью, нажав на кнопку "Новая статья"</p>
                <a href="../pages/add_article.php" class="btn">
                    <i class="fas fa-plus"></i> Создать статью
                </a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>