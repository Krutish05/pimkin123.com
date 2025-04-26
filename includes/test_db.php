<?php
$db_conn = pg_connect("host=localhost dbname=pimkin_site user=postgres password=1");

if (!$db_conn) {
    die("Ошибка подключения: " . pg_last_error());
}

echo "Подключение к PostgreSQL успешно!";
pg_close($db_conn);
?>

