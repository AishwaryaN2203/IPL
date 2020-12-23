<?php 
       include_once 'imp/view.php';

    $sql = "SELECT * FROM ticket_view";
    $result=mysqli_query($conn, $sql);
    $a=mysqli_fetch_all($result);  
    mysqli_free_result($result);
    
    $team1 = $a[0][4];
    $team2 = $a[0][5];
    $sql = "SELECT team_name FROM team_table WHERE team_id = $team1 OR team_id = $team2 ";
    $result=mysqli_query($conn, $sql);
    $b=mysqli_fetch_all($result);
    mysqli_free_result($result);
        
?>

<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<?php include('templates/header.php') ?>
<?php include('templates/header-logout.php') ?>
<?php include('templates/user-header.php')?>

<h1 style="text-align:center" >BOOKINGS </h1>
        <div class="row">
                <div class="cards-col mx-auto">
                    <div class="card">
                        <div class="card-body">
						<h5 class="card-title">Ticket No: <?php echo htmlspecialchars($t_no); ?></h5>
						<h5 class="card-title">Match No: <?php echo htmlspecialchars($a[0][0]); ?></h5>
                        <h5 class="card-title">Match:<?php echo htmlspecialchars($b[0][0]); ?> v/s <?php echo htmlspecialchars($b[1][0]); ?></h5>
                        <h5 class="card-title">Gate:<?php echo htmlspecialchars($a[0][1]); ?> </h5>
                        <h5 class="card-title">No of Seats:<?php echo htmlspecialchars($a[0][2]); ?></h5>
                        <h5 class="card-title">Amount:<?php echo htmlspecialchars($a[0][3]); ?></h5>
                        </div>

                    </div>
				</div>
        
		</div>
        <?php include('templates/footer.php') ?>
</html>