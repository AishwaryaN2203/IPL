<?php

$drop_query = "DROP TRIGGER IF EXISTS change_finished";
$result = mysqli_query($conn,$drop_query) or die('no');

$sql = "CREATE TRIGGER change_finished
        BEFORE UPDATE ON schedule_table
        FOR EACH ROW BEGIN 
                IF(new.seats = 0) THEN SET new.finished=0;
                END IF;
        END";

if (!($conn->query($sql) === TRUE) )
            echo "Error updating record: " . $conn->error;

?>

