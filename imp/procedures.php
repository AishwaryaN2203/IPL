<?php
$drop_query = "DROP PROCEDURE IF EXISTS batting";
$result = mysqli_query($c,$drop_query) or die('no');

$sql = "   CREATE PROCEDURE batting(IN start_y int,IN end_y int,IN bat varchar(15),IN team varchar(35),IN bowler_name varchar(20))
            BEGIN
            SELECT sum(batsman_runs)-sum(noball_runs) AS TOTAL,count(*) AS BALLS,
                sum(case when player_dismissed!='' then 1 else 0 end) as WICKETS,
                sum(case when batsman_runs=4 then 1 else 0 end) AS FOUR,
                sum(case when batsman_runs=6 then 1 else 0 end) AS SIX,
                sum(case when batsman_runs=2 then 1 else 0 end) AS DOUBLES,
                sum(case when batsman_runs=1 then 1 else 0 end)-sum(noball_runs) AS SINGLES,
                sum(case when batsman_runs=0 then 1 else 0 end) AS DOT_BALLS
                FROM deliveries JOIN matches  
                ON deliveries.match_id = matches.id 
                WHERE batsman LIKE bat AND deliveries.bowling_team LIKE team AND deliveries.bowler LIKE bowler_name AND matches.season BETWEEN start_y AND end_y;
            END;";
$result = mysqli_query($c,$sql) or die('no1') ; 

?>


