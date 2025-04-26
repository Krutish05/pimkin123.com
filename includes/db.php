<?php
$conn = pg_connect("host=127.0.0.1 dbname=pimkin_site user=postgres password=1")
   or die("Connection error: " . pg_last_error());
?>
