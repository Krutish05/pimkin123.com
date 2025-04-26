<?php
include 'includes/db.php';

$query = <<<SQL
CREATE TABLE IF NOT EXISTS articles (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT,
    created_at TIMESTAMP DEFAULT NOW()
)
SQL;

$result = pg_query($db_conn, $query);

if ($result) {
    echo "Таблица 'articles' успешно создана или уже существует!";
} else {
    echo "Ошибка при создании таблицы: " . pg_last_error($db_conn);
}

pg_close($db_conn);
?>

