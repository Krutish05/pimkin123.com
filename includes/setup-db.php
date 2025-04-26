<?php
// setup-db.php
include '../includes/db.php';
// SQL-запрос для создания таблицы статей
$query = <<<SQL
CREATE TABLE IF NOT EXISTS articles (
   id SERIAL PRIMARY KEY,
   title VARCHAR(255) NOT NULL,
   content TEXT,
   created_at TIMESTAMP DEFAULT NOW()
)
SQL;
// Выполнение запроса
$result = pg_query($conn, $query);


if ($result) {
   echo "Таблица 'articles' успешно создана или уже существует!";
} else {
   echo "Ошибка при создании таблицы: " . pg_last_error($conn);
}
// Закрытие соединения (опционально)
pg_close($conn);
?>
