<?php

session_start();
include_once 'configuration/db-infocon.php';
include_once 'imp/procedures.php';
include_once 'imp/procedure2.php';

$year1 = 2008;
$year2 = 2019;
$team = "_%_";
$player1 ="_%_";
$player2 = "_%_";
$extra = "_%_";

if(isset($_POST['submit1']) || isset($_POST['submit2']) || isset($_POST['submit3']) ){
        if(isset($_POST['season']) && !empty($_POST['season']))
                $year1 = $year2 = $_POST['season'];
        if(isset($_POST['team']) && !empty($_POST['team']))
            $team = $_POST['team'];
        if(isset($_POST['other']) && !empty($_POST['other']))
            $player2 = $_POST['other'];
        if(isset($_POST['name'])&& !empty($_POST['name']))
            $player1 = $_POST['name'];
}

if(isset($_POST['submit1'])){
       $result1 = mysqli_query($c,"CALL batting('$year1','$year2','$player1','$team','$player2')")  or die("Error: " . mysqli_error($c)); 
       $row1 = mysqli_fetch_assoc($result1);  
          while(mysqli_more_results($c) && mysqli_next_result($c)) {
            $dummyResult = mysqli_use_result($c);
            if($dummyResult instanceof mysqli_result) 
                mysqli_free_result($c);
            }
       $result2 = mysqli_query($c,"CALL bowling('$year1','$year2','$player2','$team','$player1')")  or die("Error: " . mysqli_error($c)); 
       $row2 = mysqli_fetch_assoc($result2);

}
else if(isset($_POST['submit2'])){
    $result1 = mysqli_query($c,"CALL batting('$year1','$year2','$player1','$team','$extra')")  or die("Error: " . mysqli_error($c)); 
    $row1 = mysqli_fetch_assoc($result1);
    while(mysqli_more_results($c) && mysqli_next_result($c)) {
      $dummyResult = mysqli_use_result($c);
      if($dummyResult instanceof mysqli_result) 
          mysqli_free_result($c);
    }
    $result2 = mysqli_query($c,"CALL batting('$year1','$year2','$player2','$team','$extra')")  or die("Error: " . mysqli_error($c)); 
    $row2 = mysqli_fetch_assoc($result2);
}
else if(isset($_POST['submit3'])){
  $result1 = mysqli_query($c,"CALL bowling('$year1','$year2','$extra','$team','$player1')")  or die("Error: " . mysqli_error($c)); 
  $row1 = mysqli_fetch_assoc($result1);
   while(mysqli_more_results($c) && mysqli_next_result($c)) {
     $dummyResult = mysqli_use_result($c);
     if($dummyResult instanceof mysqli_result) 
         mysqli_free_result($c);
   }
  $result2 = mysqli_query($c,"CALL bowling('$year1','$year2','$extra','$team','$player2')")  or die("Error: " . mysqli_error($c)); 
  $row2 = mysqli_fetch_assoc($result2);
}

?>

<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<?php include('templates/header.php') ?>
<?php include('templates/header-logout.php') ?>
<?php include('templates/user-header.php')?>
<link rel="stylesheet" href="stylesheets/all2.css">


<div class="center">

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <div class="row">
      <div class="col-lg-4">
          <form id="res" method="POST" action="">
                <br><br>
                <h3> GET PERFORMANCE OF</h3><br>
                <input type="text" name="name" placeholder="Name"><br><br>
                <label> AGAINST </label><br><br>
                <input type="text" name="team" placeholder="Team"><br><br>
                <input type="text" name="season" placeholder="Season"><br><br>
                <input type="text" name="other" placeholder="Name of the other player"><br><br>
                <button type="submit" name = "submit1">Go</button>
            </form><br><br>
      </div>
      <div class="col-lg-4">
        <form id="res" method="POST" action="">
              <br><br>
              <h3> COMPARE BATSMAN </h3><br><br>
              <input type="text" name="name" placeholder="First Batsman"><br><br>
              <input type="text" name="other" placeholder="Second Batsman"><br><br>
              <label> AGAINST </label><br><br>
              <input type="text" name="team" placeholder="Team"><br><br>
              <input type="text" name="season" placeholder="Season"><br><br> 
              <button type="submit" name = "submit2">Go</button>
          </form><br><br>
      </div>
      <div class="col-lg-4">
        <form id="res" method="POST" action="">
              <br><br>
              <h3> COMPARE BOWLERS  </h3><br><br>
              <input type="text" name="name" placeholder="First Bowler"><br><br>
              <input type="text" name="other" placeholder="Second Bowler"><br><br>
              <label> AGAINST </label><br><br>
              <input type="text" name="team" placeholder="Team"><br><br>
              <input type="text" name="season" placeholder="Season"><br><br> 
              <button type="submit" name = "submit3">Go</button>
          </form><br><br>
      </div>
    </div>

     
  <?php if(isset($_POST['submit1'])){ ?>   
      <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart1);
        google.charts.setOnLoadCallback(drawChart2);
        
        function drawChart1() {
          var data = google.visualization.arrayToDataTable([
                  ['Topic', 'Stats'],
                  ['Dismissed',<?php echo $row1["WICKETS"];?>],
                  ['Fours',<?php echo $row1["FOUR"];?>],
                  ['Sixes',<?php echo $row1["SIX"];?> ],
                  ['Doubles',<?php echo $row1["DOUBLES"];?>],
                  ['Singles',<?php echo $row1["SINGLES"];?>],
                  ['Dot Balls',<?php echo $row1["DOT_BALLS"];?> ]
          ]);
          var options = {
            title: 'BATTING PERFORMANCE Total Runs \n<?php echo $player1?> is <?php echo $row1['TOTAL']?>',
            is3D: true,
          };
          var chart = new google.visualization.PieChart(document.getElementById('piechart1'));
          chart.draw(data, options);
        }    
        function drawChart2() {
          var data = google.visualization.arrayToDataTable([
            ['row1','row2'],
                  ['Wide Runs',<?php echo $row2["WideRuns"];?>],
                  ['Bye Runs',<?php echo $row2["ByeRuns"];?>],
                  ['Leg Bye Runs',<?php echo $row2["LegByeRuns"];?> ],
                  ['Runs From No balls',<?php echo $row2["NoBalls"];?>],
                  ['Total Runs Scored By batsman',<?php echo $row2["ScoredByBatsman"];?>], 
          ]);
          var options = {
            title: 'BOWLING PERFORMANCE\n Total Wickets:<?php echo $player1?> is <?php echo $row2['WICKETS']?>',
            is3D: true,
          };
          var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
          chart.draw(data, options);
        }
      </script>
            <div id="piechart1" style="width: 900px; height: 500px;"></div>
            <div id="piechart2" style="width: 900px; height: 500px;"></div>
  <?php } ?>

  <?php if(isset($_POST['submit2'])){ ?> 
        <script type="text/javascript">
          google.charts.load('current', {'packages':['corechart']});
          google.charts.setOnLoadCallback(drawVisualization1);

        function drawVisualization1() {
          // Some raw data (not necessarily accurate)
          var data = google.visualization.arrayToDataTable([
            ['Stats','<?php echo $player1?>','<?php echo $player2?>'],
            ['Dot Balls',<?php echo $row1["DOT_BALLS"];?> ,<?php echo $row2["DOT_BALLS"];?>],
            ['Singles',<?php echo $row1["SINGLES"];?>,<?php echo $row2["SINGLES"];?>],
            ['Doubles',<?php echo $row1["DOUBLES"];?>,<?php echo $row2["DOUBLES"];?> ],
            ['Four',<?php echo $row1["FOUR"];?>,<?php echo $row2["FOUR"];?> ],
            ['Six',<?php echo $row1["SIX"];?>,<?php echo $row2["SIX"];?>  ],
            ['Dismissals',<?php echo $row1["WICKETS"];?>,<?php echo $row2["WICKETS"];?>  ]
          ]);
          var options = {
            title : 'Batting Performance Stats',
            hAxis: {title: 'Total Runs \n<?php echo $player1?> is <?php echo $row1['TOTAL']?>\n<?php echo $player2?> is <?php echo $row2['TOTAL']?>'},
            seriesType: 'bars',
            series: {5: {type: 'line'}}
          };
          var chart = new google.visualization.ComboChart(document.getElementById('chart_div1'));
          chart.draw(data, options);
        }
      </script>
      <div id="chart_div1" style="width: 900px; height: 500px;"></div>

  <?php } ?>
  
  <?php if(isset($_POST['submit3'])){ ?>
    <script type="text/javascript">
          google.charts.load('current', {'packages':['corechart']});
          google.charts.setOnLoadCallback(drawVisualization1);

        function drawVisualization1() {
          var data = google.visualization.arrayToDataTable([
            ['Stats','<?php echo $player1?>','<?php echo $player2?>'],
                  ['Wide Runs',<?php echo $row1["WideRuns"];?>,<?php echo $row2["WideRuns"];?>],
                  ['Bye Runs',<?php echo $row1["ByeRuns"];?>,<?php echo $row2["ByeRuns"];?>],
                  ['Leg Bye Runs',<?php echo $row1["LegByeRuns"];?> ,<?php echo $row2["LegByeRuns"];?> ],
                  ['Runs From No balls',<?php echo $row1["NoBalls"];?>,<?php echo $row2["NoBalls"];?>],
                  ['Total Runs Scored By batsman',<?php echo $row1["ScoredByBatsman"];?>,<?php echo $row2["ScoredByBatsman"];?>], 
          ]);
          var options = {
            title : 'Bowling Performance Stats',
            hAxis: {title: 'Total Wickets \n<?php echo $player1?> is <?php echo $row1['WICKETS']?>\n<?php echo $player2?> is <?php echo $row2['WICKETS']?>'},
            seriesType: 'bars',
            series: {5: {type: 'line'}}
          };
          var chart = new google.visualization.ComboChart(document.getElementById('chart_div1'));
          chart.draw(data, options);
        }
      </script>
      <div id="chart_div1" style="width: 900px; height: 500px;"></div> 

  <?php } ?>
</div>