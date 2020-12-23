<?php
$drop_query = "DROP FUNCTION IF EXISTS book";
$result = mysqli_query($conn,$drop_query) or die('no');


$query = " CREATE FUNCTION book()
           RETURNS INT 
           BEGIN
                DECLARE ticket_id_no INT;
                SELECT max(ticket_id) INTO ticket_id_no FROM booking;    
                RETURN ticket_id_no;
           END";
$result = mysqli_query($conn,$query) or die('no1'); 
?>
