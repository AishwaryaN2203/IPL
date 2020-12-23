<?php
$sql_drop = 'DROP TRIGGER IF EXISTS quote';
$result = mysqli_query($c,$sql_drop);

$sql = "  CREATE TRIGGER quote
            BEFORE  INSERT ON price
            for each ROW
            BEGIN 
                IF new.price_value THEN SET new.price_value = 1000;
            END
       ";
$result = mysqli_query($c,$sql) or die('no'); 

?>