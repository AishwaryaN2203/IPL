<?php
?>
<!doctype html>

<?php include('templates/header.php') ?>
<?php include('templates/header-ls.php')?>
<html lang="en">
<link rel="stylesheet" href="stylesheets/frontpage.css">

<div class="container">
        
       <div class="background">
       <img src="images/main_logo.png" id="logobg" alt="">
        </div>
        
        <div class="heading">
            <h1 id="head">Indian Premier League</h1>

            <p id="body">
            The Indian Premier League (IPL) is a professional Twenty20 cricket league in India usually contested between
             March and May of every year by eight teams representing eight different cities or states in India.
            </p>

            <a href="login_signup.php"><button1>EXPLORE NOW</button1></a>
        </div>


        <div class="image">
            <img id="myimage" src="images/frontpage/Teams.png" alt="">
        </div>

        <div class="empty">


        </div>

        <!-- this is for remaining teams -->

        <div class="list">
            <ol>
                <li onclick="myFun('images/frontpage/rcb.png', 'red', 'Royal Challengers Bangalore', 'images/frontpage/csblogo.png',
'The Royal Challengers Bangalore (RCB) are a franchise cricket team that plays in the Indian Premier League.The team is captained by Virat Kohli and coached by Simon Katich.The team holds the records of both the highest and the lowest totals in the IPL  263/5 and 49 respectively.')">RCB</li>
                <li onclick="myFun('images/frontpage/css3.png', 'gold', 'Chennai Super Kings', 'images/frontpage/csk3.png',
'The Chennai Super Kings (CSK) are a franchise cricket team which plays in the Indian Premier League.The team is captained by Mahendra Singh Dhoni and coached by Stephen Fleming.The Super Kings have lifted the IPL title thrice (in 2010, 2011 and 2018), and has the highest win percentage among all teams in the IPL.')">CSK</li>
                <li onclick="myFun('images/frontpage/dc.png', 'blue', 'Delhi Capitals', 'images/frontpage/ddlogo.png',
' The Delhi Capitals are a franchise cricket team that represents the city of Delhi in the Indian Premier League.Founded in 2008 as the Delhi Daredevils, The team is captained by Shreyas Iyer and coached by Ricky Ponting.The leading run-scorer for the Capitals is Virender Sehwag, while the leading wicket-taker is Amit Mishra.')">DC</li>
                <li onclick="myFun('images/frontpage/mi.png', 'dodgerblue', 'Mumbai Indians', 'images/frontpage/milogo.png',
'The Mumbai Indians are a franchise cricket team that competes in the Indian Premier League.The team is currently captained by Rohit Sharma and coached by Mahela Jayawardene.They have won a record breaking fourth IPL title. Sharma is the leading run scorer of the team while Lasith Malinga is the leading wicket taker of the team and the IPL as well.')">MI</li>
                <li onclick="myFun('images/frontpage/srh.png', 'orangered', 'Sun Raise Hydrabad', 'images/frontpage/srhlogo.png',
'The Sunrisers Hyderabad (SRH) are a franchise cricket team that plays in the Indian Premier League.The team is currently captained by David Warner and coached by Trevor Bayliss.They have won the IPL 1 time till now. Rashid khan is the best bowler and David Warner is the leading run scorer, having won the Orange Cap 3 times, in 2015, 2017, and 2019.Bhuvneshwar Kumar is the leading wicket-taker.')">SRH</li>
                <li onclick="myFun('images/frontpage/kp.png', 'red', 'King XI Punjab', 'images/frontpage/kplogo.png', 
' The Kings XI Punjab (KXIP) are a franchise cricket team that plays in the Indian Premier League.Apart from the 2014 season they topped the league table and finished as runners-up.The team is captained by K. L. Rahul and coached by Anil Kumble.')">KXIP</li>
                <li onclick="myFun('images/frontpage/rr1.png', '#ff3385', 'Rajastan Royals', 'images/frontpage/rrlogo.png', 
'The Rajasthan Royals (RR) are a franchise cricket team that plays in the Indian Premier League.The team won the inaugural edition of the IPL.The team is captained by Steve Smith and coached by Andrew McDonald.The team record run-scorer is Ajinkya Rahane with 2705 runs while the leading wicket-taker is Shane Watson, with 67.')">RR</li>
                <li onclick="myFun('images/frontpage/kkr.png', 'purple', 'Kolkata Knight Riders', 'images/frontpage/kkrlogo.png',
'The Kolkata Knight Riders (KKR) are a franchise cricket team that plays in the Indian Premier League.They became the IPL champions in 2012 and in 2014.The leading run-scorer of the side is Gautam Gambhir, while the leading wicket-taker is Sunil Narine.The team is captained by Eoin Morgan and coached by Brendon McCullum.')">KKR</li>
            </ol>
        </div>

    </div>




<script>

    function myFun(image, colour, head, logo, body){
        document.getElementById('myimage').src=image;
        document.querySelector('.empty').style.backgroundColor=colour;
        document.querySelector('button1').style.backgroundColor=colour;
        document.getElementById('head').innerHTML=head;
        document.getElementById('logobg').src=logo;
        document.getElementById('body').innerHTML=body;
    }


</script>

</html>