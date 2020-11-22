<?php

include('configuration/db-configuration.php');

$sql1 = 'SELECT stadium_id,stadium_name,stadium_city FROM stadium_table';
$ground_result = mysqli_query($conn, $sql1);
$stadium = mysqli_fetch_all($ground_result,MYSQLI_ASSOC);

$sql2 = 'SELECT team_id,team_name,name FROM team_table';
$team_result = mysqli_query($conn,$sql2);
$teams = mysqli_fetch_all($team_result,MYSQLI_ASSOC);
// to clear the value from memory
mysqli_free_result($ground_result);
mysqli_free_result($team_result);

 // Initializing the values 
$selected_stadium = $selected_team1 = $selected_team2 = $date =  "";
$stadium_err = $team1_err = $team2_err = $team_selected_err = $date_err = "";

if(isset($_POST['insert'])){
    $date = $_POST['date'];
    if(empty($date))
        $date_err = "Select the date";
    foreach($stadium as $std):
        $var =  $std["stadium_id"];
        // echo 'stad'.$var;
        if( isset($_POST['stad-'.$var]) ){
            $selected_stadium = $var;
        }
    endforeach;
        if(empty($selected_stadium))
            $stadium_err = "Please select the stadium";

    foreach($teams as $t):
        $var =  $t["team_id"];
        if( isset($_POST['t1-'.$var]) ){
            $selected_team1 = $var;
        }
    endforeach;
        if(empty($selected_team1))
            $team1_err = "Please select a team";

    foreach($teams as $t):
        $var =  $t["team_id"];
        if( isset($_POST['t2-'.$var]) ){
            $selected_team2 = $var;
        }
        endforeach;
        if(empty($selected_team2))
            $team2_err = "Please select a team";

    if($selected_team1===$selected_team2)
        $team_selected_err = "Team 1 and Team2 are the same ";

    if(empty($stadium_err) & empty($team1_err) & empty($team2_err) & empty($date_err)){
        $query = "INSERT INTO schedule_table (team1,team2,date,stadium) VALUES ('$selected_team1','$selected_team2','$date','$selected_stadium')";	
        if(mysqli_query($conn,$query)){
            //echo "Hello";
            header('location:match-admin.php');   
        }
        else
            echo "Query Error";
    }
        
}

    


mysqli_close($conn);

?>

<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<?php include('templates/header.php') ?>
<?php include('templates/admin-header.php')?>

<div class="add-match">

    <form action="" method="post" class="form-match">
        
    <h1 class="match-heading">GROUND INFORMATION</h1>
        <div class="row">
            <?php  foreach($stadium as $std): ?>
               <div class="cards-col col-lg-4 col-md-6">
               <div class="card">
                    <input type="radio" name="stad-<?php echo htmlspecialchars($std['stadium_id']);?>"> 
                    <img src="images/ground/<?php echo htmlspecialchars($std['stadium_id']);?>.jpg" alt="" class="card-photo">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($std['stadium_name']); ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($std['stadium_city']); ?></h6>
                    </div>
                </div>
               </div>
            <?php endforeach;?>     
        <div>
        <div class="red-text"><?php echo $stadium_err ?>

        <h1 class="match-heading">SELECT TEAM 1</h1>
        <div class="row">
            <?php  foreach($teams as $t): ?>
                <div class="cards-col col-lg-3 col-md-6">
                    <div class="card">
                        <input type="radio" name="t1-<?php echo htmlspecialchars($t['team_id']);?>">
                        <img src="images/team/<?php echo htmlspecialchars($t['team_id']);?>.png" alt="" class="card-photo">
                        <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($t['team_name']); ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($t['name']); ?></h6></div>
                    </div>
                </div>
            <?php endforeach;?>     
        <div>
        <div class="red-text"><?php echo $team1_err?></div>

        <h1 class="match-heading">SELECT TEAM 2</h1>
        <div class="row">
            <?php  foreach($teams as $t): ?>
                <div class="cards-col col-lg-3 col-md-6">
                    <div class="card">
                        <input type="radio" name="t2-<?php echo htmlspecialchars($t['team_id']);?>"> 
                        <img src="images/team/<?php echo htmlspecialchars($t['team_id']);?>.png" alt="" class="card-photo">
                        <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($t['team_name']); ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($t['name']); ?></h6></div>
                    </div>
                </div>
            <?php endforeach;?>     
        <div>
        <div class="red-text"><?php echo $team2_err ?></div>
        <div class="red-text"><?php echo $team_selected_err?></div>

        <br>
        <div class="date-class">
            <input type="date" value="" name="date" placeholder="" >
            <br>
            <div class="red-text"><?php echo $date_err?></div>
            <br>
        </div>
        
        <button type="submit" name="insert"> INSERT MATCH DETAILS</button>   
        </form>
</div>


</html>