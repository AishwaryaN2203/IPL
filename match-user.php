<?php
session_start();
include('configuration/db-configuration.php');
include('imp/trigger.php');


$sql = "SELECT match_id,team1,team2,stadium_name,stadium_city,date,timing FROM schedule_table,stadium_table WHERE stadium_id=stadium AND finished=1 ";
$result  = mysqli_query($conn,$sql);
$upmatch = mysqli_fetch_all($result,MYSQLI_ASSOC);
mysqli_free_result($result);

$sql = "SELECT match_id,team1,team2,stadium_name,stadium_city,date FROM schedule_table,stadium_table WHERE stadium_id=stadium AND finished=0 ";
$result  = mysqli_query($conn,$sql);
$fnmatch = mysqli_fetch_all($result,MYSQLI_ASSOC);
mysqli_free_result($result);

foreach($upmatch as $um):
    $mno = $um['match_id'];
    $date = $um['date'];
    if(date('Y-m-d')>=$date):
        if (!($conn->query("UPDATE schedule_table SET finished = 0 WHERE match_id = $mno") === TRUE) )
            echo "Error updating record: " . $conn->error;   
    endif; 
endforeach;

$err = "";


if(isset($_POST['insert'])){
    
    if(isset($_POST['upcomming'])){
        foreach($upmatch as $um):
            $var =  $um["match_id"];
            if( $_POST['upcomming'] == $var  ){
                $_SESSION['selected_match_id'] = $var;
                header('location:reserve.php');
            }
        endforeach;
    }
    else{
        $err = "Please choose the matches.";
    }
}



?>

<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<?php include('templates/header.php') ?>
<?php include('templates/header-logout.php')?>
<?php include('templates/user-header.php')?>
<link rel="stylesheet" href="stylesheets/match-user.css"> 
<div class="bg-image"></div>
<h1 class="match-heading">UPCOMING MATCHES </h1>

    <form action="" method="post">
        <div class="row">
            <?php  foreach($upmatch as $um): ?>
                <div class="cards-col col-lg-3 col-md-6 d-flex align-items-stretch mb-3" style="height: 18rem;" >
                    <input type="radio" value="<?php echo htmlspecialchars($um['match_id']);?>" name="upcomming" class="card-input-ele" style=" width: 1em; height: 1em;">
                    <label for="upcomming">
                    <?php
                        $t1 = $um['team1'];
                        $t2 = $um['team2'];
                        $sql = "SELECT name FROM team_table WHERE team_id = $t1 OR team_id = $t2";
                        $result = mysqli_query($conn,$sql);
                        $team_details = mysqli_fetch_all($result);                   
                    ?>
                    <div class="card card-default card-input">
                        <div class="card-body">
                            <h5 class="card-title">Match No: <?php echo htmlspecialchars($um['match_id']); ?></h5>
                            <h5 class="card-title"><?php echo htmlspecialchars( $team_details[0][0]); ?> v/s <?php echo htmlspecialchars( $team_details[1][0]); ?></h5>
                            <h5 class="card-title"><?php echo htmlspecialchars($um['stadium_name']); ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($um['stadium_city']); ?></h6>
                            <h5 class="card-title">Date: <?php echo htmlspecialchars($um['date']); ?></h5>
                            <h5 class="card-title">Date: <?php echo htmlspecialchars($um['timing']); ?></h5>
                        </div>
                    </div>
                    </label>
                </div>
            <?php endforeach;?>     
        </div>
        <button type="submit" name="insert" id="button">BOOK TICKETS</button> 
        <div class="red-text"><?php echo $err ?>
    </form>

<h1 class="match-heading">FINISHED MATCHES </h1>
        <div class="row">
            <?php  foreach($fnmatch as $fm): ?>
                <div class="cards-col col-lg-3 col-md-6">
                    <?php
                        $t1 = $fm['team1'];
                        $t2 = $fm['team2'];
                        $sql = "SELECT name FROM team_table WHERE team_id = $t1 OR team_id = $t2";
                        $result = mysqli_query($conn,$sql);
                        $team_details = mysqli_fetch_all($result);                   
                    ?>
                    <div class="card">
                        <div class="card-body">
                        <h5 class="card-title">Match No:<?php echo htmlspecialchars($fm['match_id']); ?></h5>
                        <h5 class="card-title"><?php echo htmlspecialchars( $team_details[0][0]); ?> v/s <?php echo htmlspecialchars( $team_details[1][0]); ?></h5>
                        <h5 class="card-title"><?php echo htmlspecialchars($fm['stadium_name']); ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted color-whitesmoke"  style="color: whitesmoke;"><?php echo htmlspecialchars($fm['stadium_city']); ?></h6>
                        <h5 class="card-title"><?php echo htmlspecialchars($fm['date']); ?></h5>
                        </div>

                    </div>
                </div>
            <?php endforeach;?>     
        </div>

<?php include('templates/footer.php') ?>


</html>