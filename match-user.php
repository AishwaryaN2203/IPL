<?php

include('configuration/db-configuration.php');

$sql = "SELECT match_id,team1,team2,stadium_name,stadium_city,date FROM schedule_table,stadium_table WHERE stadium_id=stadium AND finished=1 ";
$result  = mysqli_query($conn,$sql);
$upmatch = mysqli_fetch_all($result,MYSQLI_ASSOC);

$sql = "SELECT match_id,team1,team2,stadium_name,stadium_city,date FROM schedule_table,stadium_table WHERE stadium_id=stadium AND finished=0 ";
$result  = mysqli_query($conn,$sql);
$fnmatch = mysqli_fetch_all($result,MYSQLI_ASSOC);

$sql = 'SELECT team_name,name FROM team_table';
$result = mysqli_query($conn,$sql);
$team_details = mysqli_fetch_all($result,MYSQLI_ASSOC);
?>

<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<?php include('templates/header.php') ?>
<?php include('templates/user-header.php')?>

<h1 class="match-heading">UPCOMING MATCHES </h1>
        <div class="row">
            <?php  foreach($upmatch as $um): ?>
                <div class="cards-col col-lg-3 col-md-6">
                    <input type="radio" name="<?php echo htmlspecialchars($um['match_id']);?>">
                    <div class="card">
                        <div class="card-body">
                        <h5 class="card-title">Match No: <?php echo htmlspecialchars($um['match_id']); ?></h5>
                        <h5 class="card-title"><?php echo htmlspecialchars($um['team1']); ?> v/s <?php echo htmlspecialchars($um['team2']); ?></h5>
                        <h5 class="card-title"><?php echo htmlspecialchars($um['stadium_name']); ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($um['stadium_city']); ?></h6>
                        <h5 class="card-title">Date: <?php echo htmlspecialchars($um['date']); ?></h5>
                        </div>

                    </div>
                </div>
            <?php endforeach;?>     
        </div>
<h1 class="match-heading">FINISHED MATCHES </h1>
        <div class="row">
            <?php  foreach($fnmatch as $fm): ?>
                <div class="cards-col col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($fm['match_id']); ?></h5>
                        <h5 class="card-title"><?php echo htmlspecialchars($fm['team1']); ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($fm['team2']); ?></h6>
                        <h5 class="card-title"><?php echo htmlspecialchars($fm['stadium_name']); ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($fm['stadium_city']); ?></h6>
                        <h5 class="card-title"><?php echo htmlspecialchars($fm['date']); ?></h5>
                        </div>

                    </div>
                </div>
            <?php endforeach;?>     
        </div>
<?php include('templates/footer.php') ?>


</html>