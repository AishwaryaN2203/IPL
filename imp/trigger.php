<?php

$drop_query = "DROP TRIGGER IF EXISTS change_finished";
$result = mysqli_query($conn,$drop_query) or die('no');

$sql = "CREATE TRIGGER change_finished
        AFTER UPDATE ON schedule_table
        FOR EACH ROW
        BEGIN 
                IF Old.seats = 0  THEN 
                echo 'hi';
                END IF;
        END";

if (!($conn->query($sql) === TRUE) )
            echo "Error updating record: " . $conn->error;

?>
