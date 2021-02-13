<?php
session_start();
include_once 'configuration/db-infocon.php';

$html_table = '<table class="center1" border="5" cellspacing="2" cellpadding="5">';
if(isset($_POST['get-details'])){

  $info = 1;
  if(!empty($_POST['info-of'])) {
      $info = 1;
      for($i=1;$i<=5;$i++){
        if($_POST['info-of']==$i)
          $info = $i;
      }
  }

  $season = 2008;
  if(!empty($_POST['season-ch'])){
    for($season=2008;$season<=2019;$season++){
      if($_POST['season-ch']==$season)
        $sel_season = $season;
    }
  }
  
  if($info == 1 ){
    if(empty($sel_season)){
      $sql = "SELECT batsman AS a ,sum(batsman_runs) AS b FROM deliveries
            GROUP BY batsman ORDER BY sum(batsman_runs) DESC
            LIMIT 10 ;";
    }
    else{
      $sql = "SELECT batsman AS a ,sum(batsman_runs) AS b FROM deliveries,matches
            WHERE deliveries.match_id = matches.id AND matches.season = $sel_season
            GROUP BY batsman 
            ORDER BY sum(batsman_runs) DESC
            LIMIT 10 ;";
    }
    $html_table .='<tr> <th>Sl.no</th> <th>batsman</th> <th>runs</th> </tr>';
  }
 

  elseif($info == 2 ){
    if(empty($sel_season)){
      $sql = "SELECT bowler AS a,count(player_dismissed) AS b
              FROM deliveries
              WHERE (dismissal_kind != 'run out'or dismissal_kind = 'retired hurt' OR dismissal_kind = 'hit wicket') and length(player_dismissed) >0
              GROUP BY bowler
              ORDER BY count(player_dismissed) DESC
              LIMIT 10;";
    }
    else{
      $sql = "SELECT bowler AS a,count(player_dismissed) AS b
      FROM deliveries,matches
      WHERE deliveries.match_id = matches.id AND matches.season = $sel_season AND ( (dismissal_kind != 'run out'or dismissal_kind = 'retired hurt' OR dismissal_kind = 'hit wicket') and length(player_dismissed) >0)
      GROUP BY bowler
      ORDER BY count(player_dismissed) DESC
      LIMIT 10";
    }
    $html_table .='<tr> <th>Sl.no</th> <th>bowler</th> <th>wickets</th> </tr>';
  }


  elseif($info == 3 ){
    if(empty($sel_season)){
      $sql = "SELECT batsman AS a ,sum(case when batsman_runs=4 then 1 else 0 end) - sum(case when legbye_runs=4 then 1 else 0 end) AS b
              FROM deliveries
              WHERE total_runs = 4 GROUP BY batsman
              ORDER by b DESC
              LIMIT 10;";
    }
    else{
      $sql = "SELECT batsman AS a,sum(case when batsman_runs=4 then 1 else 0 end) - sum(case when legbye_runs=4 then 1 else 0 end) AS b
              FROM deliveries,matches
              WHERE total_runs = 4 AND deliveries.match_id = matches.id AND matches.season = $sel_season
              GROUP BY batsman
              ORDER BY b DESC
              LIMIT 10;";
    }
    $html_table .='<tr> <th>Sl.no</th> <th>batsman</th> <th>runs</th> </tr>';
  }
  
  elseif($info == 4 ){
    if(empty($sel_season)){
      $sql = "SELECT batsman AS a, count(total_runs) AS b FROM deliveries
              WHERE total_runs = 6 GROUP BY batsman
              ORDER by count(total_runs) DESC
              LIMIT 10;";
    }
    else{
      $sql = "SELECT batsman AS a,count(total_runs) AS b FROM deliveries,matches
              WHERE total_runs = 6 AND deliveries.match_id = matches.id AND matches.season = $sel_season
              GROUP BY batsman
              ORDER BY count(total_runs) DESC
              LIMIT 10;";
    }
    $html_table .='<tr> <th>Sl.no</th> <th>batsman</th> <th>runs</th> </tr>';
  }
  

  $result  = mysqli_query($c,$sql);
  $match_info = mysqli_fetch_all($result,MYSQLI_ASSOC);
  mysqli_free_result($result);

  $val = 1;
    foreach($match_info as $row) {
      $html_table .= 
      '<tr> <td>'. $val.'</td> <td>' .$row['a']. '</td><td>' .$row['b']. '</td> </tr>';
      $val++;
    }
    $html_table .= '</table>';
  

}

   
?>

<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" href="stylesheets/all-info.css" /> 
<?php include('templates/header.php') ?>
<?php include('templates/header-logout.php') ?>
<?php include('templates/user-header.php')?>
<link rel="stylesheet" href="stylesheets/all-info1.css"> 

  <form action="" method="post">
    <br><br>
    <div class="btn-group btn-group-toggle text-center" data-toggle="buttons">
          <label class="btn btn-secondary"><input type="radio" name="season-ch" value="all">All - season</label>
          <label class="btn btn-secondary"><input type="radio" name="season-ch" value="2008"> 2008</label> 
          <label class="btn btn-secondary"><input type="radio" name="season-ch" value="2009"> 2009</label> 
          <label class="btn btn-secondary"><input type="radio" name="season-ch" value="2010"> 2010</label> 
          <label class="btn btn-secondary"><input type="radio" name="season-ch" value="2011"> 2011</label> 
          <label class="btn btn-secondary"><input type="radio" name="season-ch" value="2012"> 2012</label> 
          <label class="btn btn-secondary"><input type="radio" name="season-ch" value="2013"> 2013</label> 
          <label class="btn btn-secondary"><input type="radio" name="season-ch" value="2014"> 2014</label> 
          <label class="btn btn-secondary"><input type="radio" name="season-ch" value="2015"> 2015</label> 
          <label class="btn btn-secondary"><input type="radio" name="season-ch" value="2016"> 2016</label>
          <label class="btn btn-secondary"><input type="radio" name="season-ch" value="2017"> 2017</label> 
          <label class="btn btn-secondary"><input type="radio" name="season-ch" value="2018"> 2018</label> 
          <label class="btn btn-secondary"><input type="radio" name="season-ch" value="2019"> 2019</label> 
    </div>
    <br><br>
    <div>
       
        <div class="btn-group btn-group-toggle " data-toggle="buttons">
            <label class="btn btn-warning"><input type="radio" name="info-of" value="1"> Most Runs</label><br>
            <label class="btn btn-warning"><input type="radio" name="info-of" value="2">Most Wickets</label><br>
            <label class="btn btn-warning"><input type="radio" name="info-of" value="3">Most Fours</label><br>
            <label class="btn btn-warning"><input type="radio" name="info-of" value="4">Most Sixes</label><br>
        </div>

        <div id="final-table">
          <?php echo $html_table; ?>  
        </div>
    </div>

    
    <br><br>
    <button type="submit" name="get-details" style="font-family: 'Cinzel decorative';font-weight: bolder;"> Go </button> 

  </form>

<?php include('templates/footer.php') ?>

