<?php 

$drop_query = "DROP PROCEDURE IF EXISTS bowling";
$result = mysqli_query($c,$drop_query) or die('no12');

$sql = "   CREATE PROCEDURE bowling(IN start_y int,IN end_y int,IN bat varchar(15),IN team varchar(35),IN bowler_name varchar(20))
            BEGIN
            SELECT 
                count(*) AS TOTALBALLS,
                sum(case when player_dismissed!='' AND (dismissal_kind != 'run out'or dismissal_kind = 'retired hurt' OR dismissal_kind = 'hit wicket') then 1 else 0 end) as WICKETS,
                sum(wide_runs) AS WideRuns,
                sum(bye_runs) AS ByeRuns,
                sum(legbye_runs) AS LegByeRuns,
                sum(noball_runs) AS NoBalls,
                sum(batsman_runs) AS ScoredByBatsman,
                sum(total_runs) AS TotalRunsConceived
                FROM deliveries JOIN matches  
                ON deliveries.match_id = matches.id 
                WHERE batsman LIKE bat AND deliveries.batting_team LIKE team AND deliveries.bowler LIKE bowler_name AND matches.season BETWEEN start_y AND end_y;
            END;";
$result = mysqli_query($c,$sql) or die('no2') ; 


?>