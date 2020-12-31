<?php 

    session_start();
    $t_no = $_SESSION['ticket_no'];
    include 'configuration/db-configuration.php';

$drop_query = "DROP VIEW IF EXISTS ticket_view";
$result = mysqli_query($conn,$drop_query) or die('no');

$sql = "    CREATE VIEW ticket_view AS
            SELECT schedule_table.match_id,no_of_seats,total_amount,team1,team2
            FROM booking JOIN schedule_table 
            USING(match_id)
            WHERE ticket_id = $t_no";
$result = mysqli_query($conn,$sql) or die('no1') ; 

?>